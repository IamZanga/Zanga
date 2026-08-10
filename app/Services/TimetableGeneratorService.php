<?php

namespace App\Services;

use App\Models\ClassRoom;
use App\Models\Subject;
use App\Models\Timetable;
use Illuminate\Support\Facades\DB;

class TimetableGeneratorService
{
    private array $days;

    private array $periodKeys;   // teaching periods only, e.g. [1,2,3,4,5,6,7]

    private int $regPeriod;

    private array $validDoublePairs; // e.g. [[1,2],[2,3],[3,4],[5,6],[6,7]]

    public function __construct()
    {
        $this->days = config('school.days');
        $this->regPeriod = config('school.registration_period');
        $breakAfter = config('school.break_after_period');

        $allPeriods = array_keys(config('school.periods'));
        $this->periodKeys = array_values(array_diff($allPeriods, [$this->regPeriod]));

        $this->validDoublePairs = [];
        foreach ($this->periodKeys as $p) {
            $next = $p + 1;
            if (in_array($next, $this->periodKeys, true) && $p !== $breakAfter) {
                $this->validDoublePairs[] = [$p, $next];
            }
        }
    }

    /**
     * @return array{created:int, warnings:string[]}
     */
    public function generate(ClassRoom $classRoom): array
    {
        $warnings = [];
        $created = 0;

        DB::transaction(function () use ($classRoom, &$warnings, &$created) {
            // Global occupancy: [day][periodKey][teacher_id] = true, across ALL classes.
            $globalOccupancy = [];
            foreach (Timetable::whereNotNull('teacher_id')->get() as $entry) {
                $periodKey = $this->labelToKey($entry->period);
                if ($periodKey !== null) {
                    $globalOccupancy[$entry->day][$periodKey][$entry->teacher_id] = true;
                }
            }

            // This class's own grid: [day][periodKey] = true if occupied (by anything, any subject).
            $classGrid = [];
            $existingByDaySubject = []; // [subject_id][day] = true, to respect "one block per subject per day"
            foreach ($classRoom->timetableEntries()->get() as $entry) {
                $periodKey = $this->labelToKey($entry->period);
                if ($periodKey !== null) {
                    $classGrid[$entry->day][$periodKey] = true;
                    $existingByDaySubject[$entry->subject_id][$entry->day] = true;
                }
            }

            $created += $this->placeRegistration($classRoom, $classGrid, $globalOccupancy, $warnings);

            $assignments = $classRoom->teacherAssignments()
                ->with(['teacher', 'subject'])
                ->whereHas('subject', fn ($q) => $q->where('is_registration', false))
                ->get()
                ->sortByDesc('periods_per_week');

            foreach ($assignments as $assignment) {
                $created += $this->placeSubject(
                    $classRoom,
                    $assignment,
                    $classGrid,
                    $globalOccupancy,
                    $existingByDaySubject,
                    $warnings
                );
            }
        });

        return ['created' => $created, 'warnings' => $warnings];
    }

    private function placeRegistration(ClassRoom $classRoom, array &$classGrid, array &$globalOccupancy, array &$warnings): int
    {
        $regSubject = Subject::where('is_registration', true)->first();

        if (! $regSubject) {
            $warnings[] = 'No subject is marked as Registration — skipped period '.$this->regPeriod.' for every day. Mark one subject as "Registration" first.';

            return 0;
        }

        if (! $classRoom->class_teacher_id) {
            $warnings[] = 'This class has no class teacher assigned — skipped Registration periods.';

            return 0;
        }

        $count = 0;
        $label = config('school.periods')[$this->regPeriod]['label'];

        foreach ($this->days as $day) {
            if (! empty($classGrid[$day][$this->regPeriod])) {
                continue; // already filled, leave it alone
            }

            if (! empty($globalOccupancy[$day][$this->regPeriod][$classRoom->class_teacher_id])) {
                $warnings[] = "Class teacher is already booked elsewhere on {$day} at Registration time — skipped.";
                continue;
            }

            Timetable::create([
                'class_id' => $classRoom->id,
                'day' => $day,
                'period' => $label,
                'subject_id' => $regSubject->id,
                'teacher_id' => $classRoom->class_teacher_id,
            ]);

            $classGrid[$day][$this->regPeriod] = true;
            $globalOccupancy[$day][$this->regPeriod][$classRoom->class_teacher_id] = true;
            $count++;
        }

        return $count;
    }

    private function placeSubject(
        ClassRoom $classRoom,
        $assignment,
        array &$classGrid,
        array &$globalOccupancy,
        array &$existingByDaySubject,
        array &$warnings
    ): int {
        $subjectId = $assignment->subject_id;
        $teacherId = $assignment->teacher_id;
        $subjectName = $assignment->subject->name;

        $existingCount = Timetable::where('class_id', $classRoom->id)->where('subject_id', $subjectId)->count();

        if ($existingCount >= $assignment->periods_per_week) {
            return 0; // already fully scheduled (or over), nothing to do
        }

        $placed = 0;

        // Only attempt the double/single split when starting from scratch.
        // If some entries already exist for this subject, top up with singles only —
        // preserving an exact double/single split on a partially-filled subject isn't
        // attempted here.
        if ($existingCount === 0) {
            $doublesNeeded = $assignment->double_periods_per_week;

            for ($i = 0; $i < $doublesNeeded; $i++) {
                if ($this->placeDouble($classRoom, $subjectId, $teacherId, $classGrid, $globalOccupancy, $existingByDaySubject)) {
                    $placed += 2;
                } else {
                    $warnings[] = "Could not place a double period for {$subjectName} — no free consecutive slots for that teacher.";
                }
            }
        }

        $remaining = $assignment->periods_per_week - $existingCount - $placed;

        for ($i = 0; $i < $remaining; $i++) {
            if ($this->placeSingle($classRoom, $subjectId, $teacherId, $classGrid, $globalOccupancy, $existingByDaySubject)) {
                $placed++;
            } else {
                $warnings[] = "Could not place all periods for {$subjectName} — ran out of free slots for that teacher.";
                break;
            }
        }

        return $placed;
    }

    private function placeDouble(ClassRoom $classRoom, int $subjectId, ?int $teacherId, array &$classGrid, array &$globalOccupancy, array &$existingByDaySubject): bool
    {
        $days = collect($this->days)->shuffle();
        $pairs = collect($this->validDoublePairs)->shuffle();

        foreach ($days as $day) {
            if (! empty($existingByDaySubject[$subjectId][$day])) {
                continue; // this subject already has a block that day
            }

            foreach ($pairs as [$p1, $p2]) {
                if (! empty($classGrid[$day][$p1]) || ! empty($classGrid[$day][$p2])) {
                    continue;
                }
                if ($teacherId && (! empty($globalOccupancy[$day][$p1][$teacherId]) || ! empty($globalOccupancy[$day][$p2][$teacherId]))) {
                    continue;
                }

                $labels = config('school.periods');
                foreach ([$p1, $p2] as $p) {
                    Timetable::create([
                        'class_id' => $classRoom->id,
                        'day' => $day,
                        'period' => $labels[$p]['label'],
                        'subject_id' => $subjectId,
                        'teacher_id' => $teacherId,
                    ]);
                    $classGrid[$day][$p] = true;
                    if ($teacherId) {
                        $globalOccupancy[$day][$p][$teacherId] = true;
                    }
                }
                $existingByDaySubject[$subjectId][$day] = true;

                return true;
            }
        }

        return false;
    }

    private function placeSingle(ClassRoom $classRoom, int $subjectId, ?int $teacherId, array &$classGrid, array &$globalOccupancy, array &$existingByDaySubject): bool
    {
        $days = collect($this->days)->shuffle();
        $periods = collect($this->periodKeys)->shuffle();

        foreach ($days as $day) {
            if (! empty($existingByDaySubject[$subjectId][$day])) {
                continue;
            }

            foreach ($periods as $p) {
                if (! empty($classGrid[$day][$p])) {
                    continue;
                }
                if ($teacherId && ! empty($globalOccupancy[$day][$p][$teacherId])) {
                    continue;
                }

                $label = config('school.periods')[$p]['label'];

                Timetable::create([
                    'class_id' => $classRoom->id,
                    'day' => $day,
                    'period' => $label,
                    'subject_id' => $subjectId,
                    'teacher_id' => $teacherId,
                ]);

                $classGrid[$day][$p] = true;
                if ($teacherId) {
                    $globalOccupancy[$day][$p][$teacherId] = true;
                }
                $existingByDaySubject[$subjectId][$day] = true;

                return true;
            }
        }

        return false;
    }

    private function labelToKey(string $label): ?int
    {
        foreach (config('school.periods') as $key => $period) {
            if ($period['label'] === $label) {
                return $key;
            }
        }

        return null;
    }
}

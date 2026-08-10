<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Subject;
use App\Models\Timetable;
use App\Models\User;
use App\Services\TimetableGeneratorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class TimetableController extends Controller
{
    public function index(): View
    {
        $classes = ClassRoom::withCount('timetableEntries')->orderBy('name')->get();

        return view('admin.timetables.index', compact('classes'));
    }

    public function show(ClassRoom $classRoom): View
    {
        $days = config('school.days');
        $periodOrder = array_keys(config('school.periods'));

        $entries = $classRoom->timetableEntries()
            ->with(['subject', 'teacher'])
            ->get()
            ->sortBy(function ($e) use ($days, $periodOrder) {
                $periodKey = $this->labelToKey($e->period);
                return [array_search($e->day, $days), $periodKey === null ? 999 : array_search($periodKey, $periodOrder)];
            })
            ->values();

        return view('admin.timetables.show', compact('classRoom', 'entries'));
    }

    public function create(ClassRoom $classRoom): View
    {
        return view('admin.timetables.create', array_merge(
            ['classRoom' => $classRoom],
            $this->formOptions()
        ));
    }

    public function store(Request $request, ClassRoom $classRoom): RedirectResponse
    {
        $validated = $this->validateRequest($request, $classRoom->id);

        $classRoom->timetableEntries()->create($validated);

        return redirect()->route('admin.timetables.show', $classRoom)->with('status', 'Timetable entry added.');
    }

    public function edit(ClassRoom $classRoom, Timetable $timetable): View
    {
        return view('admin.timetables.edit', array_merge(
            ['classRoom' => $classRoom, 'timetable' => $timetable],
            $this->formOptions()
        ));
    }

    public function update(Request $request, ClassRoom $classRoom, Timetable $timetable): RedirectResponse
    {
        $validated = $this->validateRequest($request, $classRoom->id, $timetable->id);

        $timetable->update($validated);

        return redirect()->route('admin.timetables.show', $classRoom)->with('status', 'Timetable entry updated.');
    }

    public function destroy(ClassRoom $classRoom, Timetable $timetable): RedirectResponse
    {
        $timetable->delete();

        return redirect()->route('admin.timetables.show', $classRoom)->with('status', 'Timetable entry removed.');
    }

    public function generate(ClassRoom $classRoom, TimetableGeneratorService $generator): RedirectResponse
    {
        $result = $generator->generate($classRoom);

        $status = "Auto-generated {$result['created']} timetable entries.";

        if (! empty($result['warnings'])) {
            $status .= ' '.count($result['warnings']).' item(s) could not be placed — see below.';
        }

        return redirect()->route('admin.timetables.show', $classRoom)
            ->with('status', $status)
            ->with('generator_warnings', $result['warnings']);
    }

    private function formOptions(): array
    {
        return [
            'periods' => config('school.periods'),
            'days' => config('school.days'),
            'subjects' => Subject::where('is_registration', false)->orderBy('name')->get(),
            'teachers' => User::where('role', 'teacher')->orderBy('name')->get(),
        ];
    }

    private function validateRequest(Request $request, int $classId, ?int $ignoreId = null): array
    {
        $periodKeys = array_keys(config('school.periods'));

        $validated = $request->validate([
            'day' => ['required', Rule::in(config('school.days'))],
            'period_key' => ['required', Rule::in($periodKeys)],
            'subject_id' => ['required', 'exists:subjects,id'],
            'teacher_id' => ['nullable', Rule::exists('users', 'id')->where(fn ($q) => $q->where('role', 'teacher'))],
        ]);

        $label = config('school.periods')[(int) $validated['period_key']]['label'];

        $sameClassConflict = Timetable::where('class_id', $classId)
            ->where('day', $validated['day'])
            ->where('period', $label)
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists();

        if ($sameClassConflict) {
            throw ValidationException::withMessages([
                'period_key' => 'This class already has an entry for that day and period.',
            ]);
        }

        if (! empty($validated['teacher_id'])) {
            $teacherConflict = Timetable::where('teacher_id', $validated['teacher_id'])
                ->where('day', $validated['day'])
                ->where('period', $label)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists();

            if ($teacherConflict) {
                throw ValidationException::withMessages([
                    'teacher_id' => 'This teacher already has another class at that day and period.',
                ]);
            }
        }

        return [
            'day' => $validated['day'],
            'period' => $label,
            'subject_id' => $validated['subject_id'],
            'teacher_id' => $validated['teacher_id'] ?? null,
        ];
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

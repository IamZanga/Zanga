<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Timetable;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TimetableController extends Controller
{
    public function index(): View
    {
        $teacher = Auth::guard('staff')->user();

        $entries = Timetable::where('teacher_id', $teacher->id)
            ->with('classRoom', 'subject')
            ->get();

        $days = config('school.days');
        $periods = config('school.periods');

        $grid = [];
        foreach ($days as $day) {
            foreach ($periods as $key => $period) {
                $grid[$day][$key] = $entries->first(
                    fn ($e) => $e->day === $day && $e->period === $period['label']
                );
            }
        }

        return view('teacher.timetable', compact('grid', 'days', 'periods'));
    }
}

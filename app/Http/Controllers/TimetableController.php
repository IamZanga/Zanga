<?php

namespace App\Http\Controllers;

use App\Models\Timetable;

class TimetableController extends Controller
{
    public function index()
    {
        $student = auth()->user();

        $entries = Timetable::where('class_id', $student->class_id)
            ->with(['subject', 'teacher'])
            ->get();

        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

        $periods = $entries->pluck('period')->unique()->sort(function ($a, $b) {
            preg_match('/\d+/', $a, $numA);
            preg_match('/\d+/', $b, $numB);
            return ((int) ($numA[0] ?? 0)) <=> ((int) ($numB[0] ?? 0));
        })->values();

        $grid = [];
        foreach ($days as $day) {
            foreach ($periods as $period) {
                $grid[$day][$period] = $entries->first(
                    fn ($e) => $e->day === $day && $e->period === $period
                );
            }
        }

        return view('timetable', compact('grid', 'days', 'periods'));
    }
}

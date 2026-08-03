<?php

namespace App\Http\Controllers;

class GradeController extends Controller
{
    public function index()
    {
        $student = auth()->user();

        $grades = $student->grades()
            ->with(['subject', 'term'])
            ->join('terms', 'grades.term_id', '=', 'terms.id')
            ->orderBy('terms.start_date')
            ->select('grades.*')
            ->get();

        return view('grades', compact('grades'));
    }
}

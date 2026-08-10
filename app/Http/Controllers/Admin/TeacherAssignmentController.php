<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Subject;
use App\Models\TeacherAssignment;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class TeacherAssignmentController extends Controller
{
    public function index(): View
    {
        $assignments = TeacherAssignment::with(['teacher', 'classRoom', 'subject'])
            ->join('users', 'teacher_assignments.teacher_id', '=', 'users.id')
            ->orderBy('users.name')
            ->select('teacher_assignments.*')
            ->get();

        return view('admin.teacher-assignments.index', compact('assignments'));
    }

    public function create(): View
    {
        return view('admin.teacher-assignments.create', $this->formOptions());
    }

    public function store(Request $request): RedirectResponse
    {
        TeacherAssignment::create($this->validateRequest($request));

        return redirect()->route('admin.teacher-assignments.index')->with('status', 'Teacher assignment created.');
    }

    public function edit(TeacherAssignment $teacherAssignment): View
    {
        return view('admin.teacher-assignments.edit', array_merge(
            ['assignment' => $teacherAssignment],
            $this->formOptions()
        ));
    }

    public function update(Request $request, TeacherAssignment $teacherAssignment): RedirectResponse
    {
        $teacherAssignment->update($this->validateRequest($request, $teacherAssignment->id));

        return redirect()->route('admin.teacher-assignments.index')->with('status', 'Teacher assignment updated.');
    }

    public function destroy(TeacherAssignment $teacherAssignment): RedirectResponse
    {
        $teacherAssignment->delete();

        return redirect()->route('admin.teacher-assignments.index')->with('status', 'Teacher assignment removed.');
    }

    private function formOptions(): array
    {
        return [
            'teachers' => User::where('role', 'teacher')->orderBy('name')->get(),
            'classes' => ClassRoom::orderBy('name')->get(),
            'subjects' => Subject::where('is_registration', false)->orderBy('name')->get(),
        ];
    }

    private function validateRequest(Request $request, ?int $ignoreId = null): array
    {
        $validated = $request->validate([
            'teacher_id' => ['required', Rule::exists('users', 'id')->where(fn ($q) => $q->where('role', 'teacher'))],
            'class_id' => ['required', 'exists:classes,id'],
            'subject_id' => ['nullable', 'exists:subjects,id'],
            'is_grade_teacher' => ['nullable', 'boolean'],
            'periods_per_week' => ['required', 'integer', 'min:1', 'max:40'],
            'double_periods_per_week' => ['required', 'integer', 'min:0', 'max:20'],
        ]);

        $validated['is_grade_teacher'] = $request->boolean('is_grade_teacher');

        if (($validated['double_periods_per_week'] * 2) > $validated['periods_per_week']) {
            throw ValidationException::withMessages([
                'double_periods_per_week' => 'Double periods (x2) cannot exceed total periods per week.',
            ]);
        }

        $exists = TeacherAssignment::where('teacher_id', $validated['teacher_id'])
            ->where('class_id', $validated['class_id'])
            ->where('subject_id', $validated['subject_id'])
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists();

        if ($exists) {
            throw ValidationException::withMessages([
                'subject_id' => 'This teacher is already assigned to this class and subject.',
            ]);
        }

        return $validated;
    }
}

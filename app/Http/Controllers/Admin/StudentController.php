<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function index(): View
    {
        $students = Student::with('classRoom')->orderBy('last_name')->orderBy('first_name')->get();

        return view('admin.students.index', compact('students'));
    }

    public function create(): View
    {
        return view('admin.students.create', ['classes' => ClassRoom::orderBy('name')->get()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateRequest($request);

        Student::create([
            'student_number' => $validated['student_number'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'class_id' => $validated['class_id'],
            'email' => $this->deriveEmail($validated['student_number']),
            'password' => Hash::make($validated['student_number']),
            'must_change_password' => true,
        ]);

        return redirect()->route('admin.students.index')->with('status', 'Student account created. Default password is the student number.');
    }

    public function edit(Student $student): View
    {
        return view('admin.students.edit', [
            'student' => $student,
            'classes' => ClassRoom::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Student $student): RedirectResponse
    {
        $validated = $this->validateRequest($request, $student->id);

        $student->update([
            'student_number' => $validated['student_number'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'class_id' => $validated['class_id'],
            'email' => $this->deriveEmail($validated['student_number']),
        ]);

        return redirect()->route('admin.students.index')->with('status', 'Student updated.');
    }

    public function destroy(Student $student): RedirectResponse
    {
        $student->delete();

        return redirect()->route('admin.students.index')->with('status', 'Student deleted.');
    }

    public function resetPassword(Student $student): RedirectResponse
    {
        $student->update([
            'password' => Hash::make($student->student_number),
            'must_change_password' => true,
        ]);

        return redirect()->route('admin.students.index')->with('status', "Password reset for {$student->fullName()}. It is now their student number again.");
    }

    private function deriveEmail(string $studentNumber): string
    {
        return strtolower(str_replace(' ', '', $studentNumber)).'@portal.local';
    }

    private function validateRequest(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'student_number' => [
                'required', 'string', 'max:50',
                Rule::unique('students', 'student_number')->ignore($ignoreId),
            ],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'class_id' => ['required', 'exists:classes,id'],
        ]);
    }
}

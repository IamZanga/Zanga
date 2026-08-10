<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ClassRoomController extends Controller
{
    public function index(): View
    {
        $classes = ClassRoom::withCount('students')
            ->with('classTeacher')
            ->orderBy('name')
            ->get();

        return view('admin.classes.index', compact('classes'));
    }

    public function create(): View
    {
        $teachers = User::where('role', 'teacher')->orderBy('name')->get();

        return view('admin.classes.create', compact('teachers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateRequest($request);

        ClassRoom::create($validated);

        return redirect()->route('admin.classes.index')->with('status', 'Class created.');
    }

    public function edit(ClassRoom $classRoom): View
    {
        $teachers = User::where('role', 'teacher')->orderBy('name')->get();

        return view('admin.classes.edit', compact('classRoom', 'teachers'));
    }

    public function update(Request $request, ClassRoom $classRoom): RedirectResponse
    {
        $validated = $this->validateRequest($request, $classRoom->id);

        $classRoom->update($validated);

        return redirect()->route('admin.classes.index')->with('status', 'Class updated.');
    }

    public function destroy(ClassRoom $classRoom): RedirectResponse
    {
        $classRoom->delete();

        return redirect()->route('admin.classes.index')->with('status', 'Class deleted.');
    }

    private function validateRequest(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'name' => [
                'required', 'string', 'max:255',
                Rule::unique('classes', 'name')->ignore($ignoreId),
            ],
            'class_teacher_id' => [
                'nullable', 'integer',
                Rule::exists('users', 'id')->where(fn ($q) => $q->where('role', 'teacher')),
            ],
        ]);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subject;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SubjectController extends Controller
{
    public function index(): View
    {
        $subjects = Subject::orderBy('name')->get();

        return view('admin.subjects.index', compact('subjects'));
    }

    public function create(): View
    {
        return view('admin.subjects.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateRequest($request);
        $this->applyExclusiveRegistration($validated);

        Subject::create($validated);

        return redirect()->route('admin.subjects.index')->with('status', 'Subject created.');
    }

    public function edit(Subject $subject): View
    {
        return view('admin.subjects.edit', compact('subject'));
    }

    public function update(Request $request, Subject $subject): RedirectResponse
    {
        $validated = $this->validateRequest($request, $subject->id);
        $this->applyExclusiveRegistration($validated, $subject->id);

        $subject->update($validated);

        return redirect()->route('admin.subjects.index')->with('status', 'Subject updated.');
    }

    public function destroy(Subject $subject): RedirectResponse
    {
        $subject->delete();

        return redirect()->route('admin.subjects.index')->with('status', 'Subject deleted.');
    }

    private function validateRequest(Request $request, ?int $ignoreId = null): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => [
                'nullable', 'string', 'max:50',
                Rule::unique('subjects', 'code')->ignore($ignoreId),
            ],
        ]);

        $validated['is_registration'] = $request->boolean('is_registration');

        return $validated;
    }

    /**
     * Only one subject can ever be the Registration subject.
     */
    private function applyExclusiveRegistration(array &$validated, ?int $ignoreId = null): void
    {
        if ($validated['is_registration']) {
            Subject::when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->update(['is_registration' => false]);
        }
    }
}

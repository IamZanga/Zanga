<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Term;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TermController extends Controller
{
    public function index(): View
    {
        $terms = Term::orderByDesc('start_date')->get();

        return view('admin.terms.index', compact('terms'));
    }

    public function create(): View
    {
        return view('admin.terms.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateRequest($request);
        $validated['is_current'] = $request->boolean('is_current');

        if ($validated['is_current']) {
            Term::query()->update(['is_current' => false]);
        }

        Term::create($validated);

        return redirect()->route('admin.terms.index')->with('status', 'Term created.');
    }

    public function edit(Term $term): View
    {
        return view('admin.terms.edit', compact('term'));
    }

    public function update(Request $request, Term $term): RedirectResponse
    {
        $validated = $this->validateRequest($request);
        $validated['is_current'] = $request->boolean('is_current');

        if ($validated['is_current']) {
            Term::where('id', '!=', $term->id)->update(['is_current' => false]);
        }

        $term->update($validated);

        return redirect()->route('admin.terms.index')->with('status', 'Term updated.');
    }

    public function destroy(Term $term): RedirectResponse
    {
        $term->delete();

        return redirect()->route('admin.terms.index')->with('status', 'Term deleted.');
    }

    private function validateRequest(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'academic_year' => ['required', 'string', 'max:20'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;

class NoteController extends Controller
{
    public function index(Request $request)
    {
        $student = auth()->user();

        $subjectFilter = $request->query('subject');

        $query = Note::where('class_id', $student->class_id)->with('subject');
        if ($subjectFilter && $subjectFilter !== 'All') {
            $query->whereHas('subject', fn ($q) => $q->where('name', $subjectFilter));
        }

        $notes = $query->orderBy('created_at', 'desc')->get();

        // Subjects actually attached to this class's notes (drives the filter dropdown)
        $subjects = Note::where('class_id', $student->class_id)
            ->with('subject')
            ->get()
            ->pluck('subject.name')
            ->unique()
            ->values();

        return view('notes', compact('notes', 'subjects', 'subjectFilter'));
    }

    public function download(Note $note)
    {
        abort_unless($note->file_path, 404);

        return Storage::disk('public')->download(
            $note->file_path,
            $note->title . '.' . pathinfo($note->file_path, PATHINFO_EXTENSION)
        );
    }

    public function ask(Request $request, Note $note)
    {
        $request->validate(['question' => 'required|string|max:500']);

        if (!$note->extracted_text) {
            return response()->json(['answer' => "This note doesn't have readable text yet — ask your teacher to re-sync it."], 422);
        }

        $response = Http::withHeaders([
            'x-api-key' => config('services.anthropic.key'),
            'anthropic-version' => '2023-06-01',
            'content-type' => 'application/json',
        ])->post('https://api.anthropic.com/v1/messages', [
            'model' => 'claude-haiku-4-5-20251001',
            'max_tokens' => 1024,
            'messages' => [[
                'role' => 'user',
                'content' => "You are a study assistant. Answer the student's question using ONLY the note content below. If the answer isn't in the note, say so.\n\nNote content:\n{$note->extracted_text}\n\nQuestion: {$request->question}",
            ]],
        ]);

        if ($response->failed()) {
            \Log::error('Anthropic API failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return response()->json(['answer' => 'Sorry, the AI service is unavailable right now.'], 500);
        }

        return response()->json(['answer' => $response->json('content.0.text', 'Sorry, something went wrong.')]);
    }
}

<x-layouts.portal title="Grades">
    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">Term</th>
                    <th class="px-6 py-3">Subject</th>
                    <th class="px-6 py-3">Assessment</th>
                    <th class="px-6 py-3">Score</th>
                    <th class="px-6 py-3">Grade</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($grades as $grade)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $grade->term->name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $grade->subject->name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $grade->assessment_type }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $grade->score }} / {{ $grade->max_score }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded text-xs font-medium bg-blue-50 text-blue-700">{{ $grade->grade ?? '—' }}</span>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-6 py-8 text-center text-gray-400">No grades available yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.portal>

<x-layouts.portal title="Timetable">
    <div class="bg-white rounded-xl shadow-sm border overflow-x-auto">
        <table class="w-full text-sm text-left border-collapse">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 border-b sticky left-0 bg-gray-50">Day</th>
                    @foreach ($periods as $period)
                        <th class="px-4 py-3 border-b border-l">{{ $period }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @forelse ($days as $day)
                    <tr class="border-b">
                        <td class="px-4 py-4 font-medium text-gray-800 sticky left-0 bg-white">{{ $day }}</td>
                        @foreach ($periods as $period)
                            @php $entry = $grid[$day][$period] ?? null; @endphp
                            <td class="px-4 py-4 border-l align-top">
                                @if ($entry)
                                    <p class="font-medium text-gray-800">{{ $entry->subject->name }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5">{{ $entry->teacher->name ?? '—' }}</p>
                                @else
                                    <span class="text-gray-300">—</span>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @empty
                    <tr><td class="px-4 py-8 text-center text-gray-400">No timetable available yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.portal>
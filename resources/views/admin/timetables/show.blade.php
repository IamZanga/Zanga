<x-layouts.admin title="Timetable - {{ $classRoom->name }}">
    <div class="flex items-center justify-between mb-4">
        <a href="{{ route('admin.timetables.index') }}" class="text-sm text-gray-500 hover:text-gray-800">&larr; All Classes</a>
        <div class="flex items-center gap-3">
            <form method="POST" action="{{ route('admin.timetables.generate', $classRoom) }}"
                  onsubmit="return confirm('Auto-fill empty timetable slots for {{ $classRoom->name }} based on teacher assignments? Existing entries will not be touched.');">
                @csrf
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-xs font-semibold uppercase tracking-widest text-gray-700 rounded-md hover:bg-gray-50 transition">
                    Auto-Generate
                </button>
            </form>
            <a href="{{ route('admin.timetables.create', $classRoom) }}"
               class="inline-flex items-center px-4 py-2 bg-gray-800 text-white text-xs font-semibold uppercase tracking-widest rounded-md hover:bg-gray-700 transition">
                Add Entry
            </a>
        </div>
    </div>

    @if (session('generator_warnings') && count(session('generator_warnings')) > 0)
        <div class="mb-6 bg-amber-50 border border-amber-200 text-amber-800 text-sm rounded-lg px-4 py-3">
            <p class="font-semibold mb-1">Some periods couldn't be auto-placed:</p>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach (session('generator_warnings') as $warning)
                    <li>{{ $warning }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">Day</th>
                    <th class="px-6 py-3">Period</th>
                    <th class="px-6 py-3">Subject</th>
                    <th class="px-6 py-3">Teacher</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($entries as $entry)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $entry->day }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $entry->period }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $entry->subject->name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $entry->teacher->name ?? '—' }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.timetables.edit', [$classRoom, $entry]) }}" class="text-blue-600 font-medium hover:underline">Edit</a>

                            <form method="POST" action="{{ route('admin.timetables.destroy', [$classRoom, $entry]) }}"
                                  class="inline"
                                  onsubmit="return confirm('Remove this timetable entry?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 font-medium hover:underline ml-4">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-6 py-8 text-center text-gray-400">No timetable entries yet for {{ $classRoom->name }}. Try Auto-Generate, or add entries manually.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.admin>

<x-layouts.admin title="Timetable Management">
    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">Class</th>
                    <th class="px-6 py-3">Entries</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($classes as $classRoom)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $classRoom->name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $classRoom->timetable_entries_count }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.timetables.show', $classRoom) }}" class="text-blue-600 font-medium hover:underline">Manage Timetable</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="px-6 py-8 text-center text-gray-400">No classes yet. Create a class first.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.admin>

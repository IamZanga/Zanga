<x-layouts.admin title="Classes">
    <div class="flex items-center justify-end mb-4">
        <a href="{{ route('admin.classes.create') }}"
           class="inline-flex items-center px-4 py-2 bg-gray-800 text-white text-xs font-semibold uppercase tracking-widest rounded-md hover:bg-gray-700 transition">
            New Class
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">Name</th>
                    <th class="px-6 py-3">Class Teacher</th>
                    <th class="px-6 py-3">Students</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($classes as $classRoom)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $classRoom->name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $classRoom->classTeacher->name ?? '—' }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $classRoom->students_count }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.classes.edit', $classRoom) }}" class="text-blue-600 font-medium hover:underline">Edit</a>

                            <form method="POST" action="{{ route('admin.classes.destroy', $classRoom) }}"
                                  class="inline"
                                  onsubmit="return confirm('Delete {{ $classRoom->name }}? This will also delete all students, timetable entries, and teacher assignments linked to this class. This cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 font-medium hover:underline ml-4">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-6 py-8 text-center text-gray-400">No classes yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.admin>

<x-layouts.admin title="Students">
    <div class="flex items-center justify-end mb-4">
        <a href="{{ route('admin.students.create') }}"
           class="inline-flex items-center px-4 py-2 bg-gray-800 text-white text-xs font-semibold uppercase tracking-widest rounded-md hover:bg-gray-700 transition">
            New Student
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">Name</th>
                    <th class="px-6 py-3">Student Number</th>
                    <th class="px-6 py-3">Class</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($students as $student)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $student->fullName() }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $student->student_number }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $student->classRoom->name ?? '—' }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.students.edit', $student) }}" class="text-blue-600 font-medium hover:underline">Edit</a>

                            <form method="POST" action="{{ route('admin.students.destroy', $student) }}"
                                  class="inline"
                                  onsubmit="return confirm('Delete {{ $student->fullName() }}? This will also delete all their grades, attendance records, warnings, and report cards. This cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 font-medium hover:underline ml-4">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-6 py-8 text-center text-gray-400">No students yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.admin>

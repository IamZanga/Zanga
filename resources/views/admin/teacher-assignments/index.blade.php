<x-layouts.admin title="Teacher Assignments">
    <div class="flex items-center justify-end mb-4">
        <a href="{{ route('admin.teacher-assignments.create') }}"
           class="inline-flex items-center px-4 py-2 bg-gray-800 text-white text-xs font-semibold uppercase tracking-widest rounded-md hover:bg-gray-700 transition">
            New Assignment
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">Teacher</th>
                    <th class="px-6 py-3">Class</th>
                    <th class="px-6 py-3">Subject</th>
                    <th class="px-6 py-3">Periods/Week</th>
                    <th class="px-6 py-3">Grade Teacher?</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($assignments as $assignment)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $assignment->teacher->name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $assignment->classRoom->name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $assignment->subject->name ?? '—' }}</td>
                        <td class="px-6 py-4 text-gray-600">
                            {{ $assignment->periods_per_week }}
                            @if ($assignment->double_periods_per_week)
                                <span class="text-xs text-gray-400">({{ $assignment->double_periods_per_week }} double)</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if ($assignment->is_grade_teacher)
                                <span class="px-2 py-1 rounded text-xs font-medium bg-green-50 text-green-700">Yes</span>
                            @else
                                <span class="text-gray-300 text-xs">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.teacher-assignments.edit', $assignment) }}" class="text-blue-600 font-medium hover:underline">Edit</a>

                            <form method="POST" action="{{ route('admin.teacher-assignments.destroy', $assignment) }}"
                                  class="inline"
                                  onsubmit="return confirm('Remove this assignment? The teacher will lose access to this class/subject.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 font-medium hover:underline ml-4">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="px-6 py-8 text-center text-gray-400">No teacher assignments yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.admin>

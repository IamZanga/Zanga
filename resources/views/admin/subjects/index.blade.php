<x-layouts.admin title="Subjects">
    <div class="flex items-center justify-end mb-4">
        <a href="{{ route('admin.subjects.create') }}"
           class="inline-flex items-center px-4 py-2 bg-gray-800 text-white text-xs font-semibold uppercase tracking-widest rounded-md hover:bg-gray-700 transition">
            New Subject
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">Name</th>
                    <th class="px-6 py-3">Code</th>
                    <th class="px-6 py-3">Registration?</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($subjects as $subject)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $subject->name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $subject->code ?? '—' }}</td>
                        <td class="px-6 py-4">
                            @if ($subject->is_registration)
                                <span class="px-2 py-1 rounded text-xs font-medium bg-green-50 text-green-700">Yes</span>
                            @else
                                <span class="text-gray-300 text-xs">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.subjects.edit', $subject) }}" class="text-blue-600 font-medium hover:underline">Edit</a>

                            <form method="POST" action="{{ route('admin.subjects.destroy', $subject) }}"
                                  class="inline"
                                  onsubmit="return confirm('Delete {{ $subject->name }}? This will also delete all grades, notes, and timetable entries for this subject, and unassign any teachers linked to it. This cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 font-medium hover:underline ml-4">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="px-6 py-8 text-center text-gray-400">No subjects yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.admin>

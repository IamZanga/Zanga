<x-layouts.admin title="Terms">
    <div class="flex items-center justify-end mb-4">
        <a href="{{ route('admin.terms.create') }}"
           class="inline-flex items-center px-4 py-2 bg-gray-800 text-white text-xs font-semibold uppercase tracking-widest rounded-md hover:bg-gray-700 transition">
            New Term
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">Term</th>
                    <th class="px-6 py-3">Academic Year</th>
                    <th class="px-6 py-3">Dates</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($terms as $term)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-800">{{ $term->name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $term->academic_year }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $term->start_date->format('M j, Y') }} – {{ $term->end_date->format('M j, Y') }}</td>
                        <td class="px-6 py-4">
                            @if ($term->is_current)
                                <span class="px-2 py-1 rounded text-xs font-medium bg-green-50 text-green-700">Current</span>
                            @else
                                <span class="text-gray-300 text-xs">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.terms.edit', $term) }}" class="text-blue-600 font-medium hover:underline">Edit</a>

                            <form method="POST" action="{{ route('admin.terms.destroy', $term) }}"
                                  class="inline"
                                  onsubmit="return confirm('Delete {{ $term->name }} ({{ $term->academic_year }})? This will also delete all grades and report cards for this term, and clear the term on any related attendance records. This cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 font-medium hover:underline ml-4">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-6 py-8 text-center text-gray-400">No terms yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.admin>

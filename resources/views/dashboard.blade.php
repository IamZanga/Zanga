<x-layouts.portal title="Dashboard">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <a href="{{ route('timetable') }}" class="bg-white rounded-xl shadow-sm border p-6 hover:shadow-md transition">
            <p class="text-sm font-medium text-gray-500">Timetable</p>
            <p class="text-xl font-semibold text-gray-800 mt-1">View schedule</p>
        </a>

        <a href="{{ route('grades') }}" class="bg-white rounded-xl shadow-sm border p-6 hover:shadow-md transition">
            <p class="text-sm font-medium text-gray-500">Grades</p>
            <p class="text-xl font-semibold text-gray-800 mt-1">View term results</p>
        </a>

        <a href="{{ route('notes') }}" class="bg-white rounded-xl shadow-sm border p-6 hover:shadow-md transition">
            <p class="text-sm font-medium text-gray-500">Notes</p>
            <p class="text-xl font-semibold text-gray-800 mt-1">View materials</p>
        </a>

    </div>
</x-layouts.portal>
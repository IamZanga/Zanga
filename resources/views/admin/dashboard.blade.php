<x-layouts.admin title="Admin Dashboard">
    <div class="bg-white rounded-xl shadow-sm border p-8">
        <h1 class="text-lg font-semibold text-gray-800">Welcome, {{ auth('staff')->user()->name }}</h1>
        <p class="text-sm text-gray-500 mt-1">Admin modules (classes, subjects, terms, teacher assignments, student accounts, timetable authoring) go here.</p>
    </div>
</x-layouts.admin>

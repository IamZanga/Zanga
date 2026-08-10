<x-layouts.admin title="New Timetable Entry - {{ $classRoom->name }}">
    <div class="bg-white rounded-xl shadow-sm border p-8 max-w-lg">
        <form method="POST" action="{{ route('admin.timetables.store', $classRoom) }}">
            @include('admin.timetables._form', ['submitLabel' => 'Add Entry'])
        </form>
    </div>
</x-layouts.admin>

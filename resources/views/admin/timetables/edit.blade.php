<x-layouts.admin title="Edit Timetable Entry - {{ $classRoom->name }}">
    <div class="bg-white rounded-xl shadow-sm border p-8 max-w-lg">
        <form method="POST" action="{{ route('admin.timetables.update', [$classRoom, $timetable]) }}">
            @method('PUT')
            @include('admin.timetables._form', ['submitLabel' => 'Save Changes'])
        </form>
    </div>
</x-layouts.admin>

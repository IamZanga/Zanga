<x-layouts.admin title="New Teacher Assignment">
    <div class="bg-white rounded-xl shadow-sm border p-8 max-w-lg">
        <form method="POST" action="{{ route('admin.teacher-assignments.store') }}">
            @include('admin.teacher-assignments._form', ['submitLabel' => 'Create Assignment'])
        </form>
    </div>
</x-layouts.admin>

<x-layouts.admin title="Edit Teacher Assignment">
    <div class="bg-white rounded-xl shadow-sm border p-8 max-w-lg">
        <form method="POST" action="{{ route('admin.teacher-assignments.update', $assignment) }}">
            @method('PUT')
            @include('admin.teacher-assignments._form', ['submitLabel' => 'Save Changes'])
        </form>
    </div>
</x-layouts.admin>

<x-layouts.admin title="New Student">
    <div class="bg-white rounded-xl shadow-sm border p-8 max-w-lg">
        <form method="POST" action="{{ route('admin.students.store') }}">
            @include('admin.students._form', ['submitLabel' => 'Create Student'])
        </form>
    </div>
</x-layouts.admin>

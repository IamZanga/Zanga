<x-layouts.admin title="Edit Class">
    <div class="bg-white rounded-xl shadow-sm border p-8 max-w-lg">
        <form method="POST" action="{{ route('admin.classes.update', $classRoom) }}">
            @method('PUT')
            @include('admin.classes._form', ['submitLabel' => 'Save Changes'])
        </form>
    </div>
</x-layouts.admin>

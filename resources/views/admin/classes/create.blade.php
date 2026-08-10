<x-layouts.admin title="New Class">
    <div class="bg-white rounded-xl shadow-sm border p-8 max-w-lg">
        <form method="POST" action="{{ route('admin.classes.store') }}">
            @include('admin.classes._form', ['submitLabel' => 'Create Class'])
        </form>
    </div>
</x-layouts.admin>

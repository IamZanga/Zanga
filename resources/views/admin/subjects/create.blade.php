<x-layouts.admin title="New Subject">
    <div class="bg-white rounded-xl shadow-sm border p-8 max-w-lg">
        <form method="POST" action="{{ route('admin.subjects.store') }}">
            @include('admin.subjects._form', ['submitLabel' => 'Create Subject'])
        </form>
    </div>
</x-layouts.admin>

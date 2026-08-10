<x-layouts.admin title="New Term">
    <div class="bg-white rounded-xl shadow-sm border p-8 max-w-lg">
        <form method="POST" action="{{ route('admin.terms.store') }}">
            @include('admin.terms._form', ['submitLabel' => 'Create Term'])
        </form>
    </div>
</x-layouts.admin>

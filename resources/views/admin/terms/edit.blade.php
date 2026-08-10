<x-layouts.admin title="Edit Term">
    <div class="bg-white rounded-xl shadow-sm border p-8 max-w-lg">
        <form method="POST" action="{{ route('admin.terms.update', $term) }}">
            @method('PUT')
            @include('admin.terms._form', ['submitLabel' => 'Save Changes'])
        </form>
    </div>
</x-layouts.admin>

<x-layouts.admin title="Edit Subject">
    <div class="bg-white rounded-xl shadow-sm border p-8 max-w-lg">
        <form method="POST" action="{{ route('admin.subjects.update', $subject) }}">
            @method('PUT')
            @include('admin.subjects._form', ['submitLabel' => 'Save Changes'])
        </form>
    </div>
</x-layouts.admin>

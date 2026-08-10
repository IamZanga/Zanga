<x-layouts.admin title="Edit Student">
    <div class="bg-white rounded-xl shadow-sm border p-8 max-w-lg">
        <form method="POST" action="{{ route('admin.students.update', $student) }}">
            @method('PUT')
            @include('admin.students._form', ['submitLabel' => 'Save Changes'])
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border p-8 max-w-lg mt-6">
        <h2 class="text-sm font-semibold text-gray-800">Reset Password</h2>
        <p class="text-sm text-gray-500 mt-1">Resets this student's password back to their student number ({{ $student->student_number }}) and forces them to set a new one on next login.</p>
        <form method="POST" action="{{ route('admin.students.reset-password', $student) }}" class="mt-4"
              onsubmit="return confirm('Reset password for {{ $student->fullName() }}?');">
            @csrf
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-xs font-semibold uppercase tracking-widest text-gray-700 rounded-md hover:bg-gray-50 transition">
                Reset Password
            </button>
        </form>
    </div>
</x-layouts.admin>

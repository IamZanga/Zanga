@csrf

<div class="grid grid-cols-2 gap-4">
    <div>
        <x-input-label for="first_name" value="First Name" />
        <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full"
                      value="{{ old('first_name', $student->first_name ?? '') }}" required autofocus />
        <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="last_name" value="Last Name" />
        <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full"
                      value="{{ old('last_name', $student->last_name ?? '') }}" required />
        <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
    </div>
</div>

<div class="mt-4">
    <x-input-label for="student_number" value="Student Number (Exam Number)" />
    <x-text-input id="student_number" name="student_number" type="text" class="mt-1 block w-full"
                  value="{{ old('student_number', $student->student_number ?? '') }}" required placeholder="e.g. KSSS-0002" />
    <x-input-error :messages="$errors->get('student_number')" class="mt-2" />
    <p class="text-xs text-gray-400 mt-1">This is also the student's login ID and default password.</p>
</div>

<div class="mt-4">
    <x-input-label for="class_id" value="Class" />
    <select id="class_id" name="class_id" required
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        <option value="">— Select a class —</option>
        @foreach ($classes as $classRoom)
            <option value="{{ $classRoom->id }}"
                @selected(old('class_id', $student->class_id ?? null) == $classRoom->id)>
                {{ $classRoom->name }}
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('class_id')" class="mt-2" />
</div>

<div class="flex items-center justify-end gap-3 mt-6">
    <a href="{{ route('admin.students.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Cancel</a>
    <x-primary-button>{{ $submitLabel ?? 'Save' }}</x-primary-button>
</div>

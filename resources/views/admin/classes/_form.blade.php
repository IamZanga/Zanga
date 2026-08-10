@csrf

<div>
    <x-input-label for="name" value="Class Name" />
    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                  value="{{ old('name', $classRoom->name ?? '') }}" required autofocus placeholder="e.g. 11A" />
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="class_teacher_id" value="Class Teacher" />
    <select id="class_teacher_id" name="class_teacher_id"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        <option value="">— None assigned —</option>
        @foreach ($teachers as $teacher)
            <option value="{{ $teacher->id }}"
                @selected(old('class_teacher_id', $classRoom->class_teacher_id ?? null) == $teacher->id)>
                {{ $teacher->name }}
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('class_teacher_id')" class="mt-2" />
</div>

<div class="flex items-center justify-end gap-3 mt-6">
    <a href="{{ route('admin.classes.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Cancel</a>
    <x-primary-button>{{ $submitLabel ?? 'Save' }}</x-primary-button>
</div>

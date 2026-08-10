@csrf

<div>
    <x-input-label for="name" value="Subject Name" />
    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                  value="{{ old('name', $subject->name ?? '') }}" required autofocus placeholder="e.g. Mathematics" />
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="code" value="Subject Code (optional)" />
    <x-text-input id="code" name="code" type="text" class="mt-1 block w-full"
                  value="{{ old('code', $subject->code ?? '') }}" placeholder="e.g. MATH" />
    <x-input-error :messages="$errors->get('code')" class="mt-2" />
</div>

<div class="mt-4">
    <label class="inline-flex items-center">
        <input type="checkbox" name="is_registration" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
               @checked(old('is_registration', $subject->is_registration ?? false))>
        <span class="ms-2 text-sm text-gray-700">This is the Registration subject</span>
    </label>
    <p class="text-xs text-gray-400 mt-1">Only one subject can be Registration. The timetable generator auto-places it at Period 0 every day, taught by each class's assigned class teacher. Checking this will un-check any other subject currently marked as Registration.</p>
</div>

<div class="flex items-center justify-end gap-3 mt-6">
    <a href="{{ route('admin.subjects.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Cancel</a>
    <x-primary-button>{{ $submitLabel ?? 'Save' }}</x-primary-button>
</div>

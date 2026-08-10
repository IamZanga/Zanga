@csrf

<div>
    <x-input-label for="name" value="Term Name" />
    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full"
                  value="{{ old('name', $term->name ?? '') }}" required autofocus placeholder="e.g. Term 1" />
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="academic_year" value="Academic Year" />
    <x-text-input id="academic_year" name="academic_year" type="text" class="mt-1 block w-full"
                  value="{{ old('academic_year', $term->academic_year ?? '') }}" required placeholder="e.g. 2026" />
    <x-input-error :messages="$errors->get('academic_year')" class="mt-2" />
</div>

<div class="grid grid-cols-2 gap-4 mt-4">
    <div>
        <x-input-label for="start_date" value="Start Date" />
        <x-text-input id="start_date" name="start_date" type="date" class="mt-1 block w-full"
                      value="{{ old('start_date', isset($term) ? $term->start_date->format('Y-m-d') : '') }}" required />
        <x-input-error :messages="$errors->get('start_date')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="end_date" value="End Date" />
        <x-text-input id="end_date" name="end_date" type="date" class="mt-1 block w-full"
                      value="{{ old('end_date', isset($term) ? $term->end_date->format('Y-m-d') : '') }}" required />
        <x-input-error :messages="$errors->get('end_date')" class="mt-2" />
    </div>
</div>

<div class="mt-4">
    <label class="inline-flex items-center">
        <input type="checkbox" name="is_current" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
               @checked(old('is_current', $term->is_current ?? false))>
        <span class="ms-2 text-sm text-gray-700">Mark as the current term</span>
    </label>
    <p class="text-xs text-gray-400 mt-1">Marking this current will automatically unmark whichever term is currently active.</p>
</div>

<div class="flex items-center justify-end gap-3 mt-6">
    <a href="{{ route('admin.terms.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Cancel</a>
    <x-primary-button>{{ $submitLabel ?? 'Save' }}</x-primary-button>
</div>

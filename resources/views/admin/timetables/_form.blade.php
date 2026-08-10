@csrf

<div>
    <x-input-label for="day" value="Day" />
    <select id="day" name="day" required
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        <option value="">— Select a day —</option>
        @foreach ($days as $day)
            <option value="{{ $day }}" @selected(old('day', $timetable->day ?? null) === $day)>{{ $day }}</option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('day')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="period_key" value="Period" />
    <select id="period_key" name="period_key" required
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        <option value="">— Select a period —</option>
        @php $currentLabel = $timetable->period ?? null; @endphp
        @foreach ($periods as $key => $period)
            <option value="{{ $key }}" @selected(old('period_key', $currentLabel === $period['label'] ? $key : null) == $key)>
                {{ $period['label'] }} ({{ $period['start'] }}–{{ $period['end'] }})
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('period_key')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="subject_id" value="Subject" />
    <select id="subject_id" name="subject_id" required
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        <option value="">— Select a subject —</option>
        @foreach ($subjects as $subject)
            <option value="{{ $subject->id }}" @selected(old('subject_id', $timetable->subject_id ?? null) == $subject->id)>{{ $subject->name }}</option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('subject_id')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="teacher_id" value="Teacher (optional)" />
    <select id="teacher_id" name="teacher_id"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        <option value="">— None assigned —</option>
        @foreach ($teachers as $teacher)
            <option value="{{ $teacher->id }}" @selected(old('teacher_id', $timetable->teacher_id ?? null) == $teacher->id)>{{ $teacher->name }}</option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('teacher_id')" class="mt-2" />
</div>

<div class="flex items-center justify-end gap-3 mt-6">
    <a href="{{ route('admin.timetables.show', $classRoom) }}" class="text-sm text-gray-600 hover:text-gray-900">Cancel</a>
    <x-primary-button>{{ $submitLabel ?? 'Save' }}</x-primary-button>
</div>

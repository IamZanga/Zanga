@csrf

<div>
    <x-input-label for="teacher_id" value="Teacher" />
    <select id="teacher_id" name="teacher_id" required
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        <option value="">— Select a teacher —</option>
        @foreach ($teachers as $teacher)
            <option value="{{ $teacher->id }}"
                @selected(old('teacher_id', $assignment->teacher_id ?? null) == $teacher->id)>
                {{ $teacher->name }}
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('teacher_id')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="class_id" value="Class" />
    <select id="class_id" name="class_id" required
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        <option value="">— Select a class —</option>
        @foreach ($classes as $classRoom)
            <option value="{{ $classRoom->id }}"
                @selected(old('class_id', $assignment->class_id ?? null) == $classRoom->id)>
                {{ $classRoom->name }}
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('class_id')" class="mt-2" />
</div>

<div class="mt-4">
    <x-input-label for="subject_id" value="Subject (optional)" />
    <select id="subject_id" name="subject_id"
            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        <option value="">— None —</option>
        @foreach ($subjects as $subject)
            <option value="{{ $subject->id }}"
                @selected(old('subject_id', $assignment->subject_id ?? null) == $subject->id)>
                {{ $subject->name }}
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('subject_id')" class="mt-2" />
    <p class="text-xs text-gray-400 mt-1">Leave blank if this assignment is purely for being the class's grade teacher, not tied to a specific subject.</p>
</div>

<div class="mt-4">
    <label class="inline-flex items-center">
        <input type="checkbox" name="is_grade_teacher" value="1" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
               @checked(old('is_grade_teacher', $assignment->is_grade_teacher ?? false))>
        <span class="ms-2 text-sm text-gray-700">This teacher is the grade teacher for this class</span>
    </label>
    <x-input-error :messages="$errors->get('is_grade_teacher')" class="mt-2" />
</div>

<div class="grid grid-cols-2 gap-4 mt-4">
    <div>
        <x-input-label for="periods_per_week" value="Periods per Week" />
        <x-text-input id="periods_per_week" name="periods_per_week" type="number" min="1" max="40" class="mt-1 block w-full"
                      value="{{ old('periods_per_week', $assignment->periods_per_week ?? 1) }}" required />
        <x-input-error :messages="$errors->get('periods_per_week')" class="mt-2" />
    </div>
    <div>
        <x-input-label for="double_periods_per_week" value="Of Which, Double Periods" />
        <x-text-input id="double_periods_per_week" name="double_periods_per_week" type="number" min="0" max="20" class="mt-1 block w-full"
                      value="{{ old('double_periods_per_week', $assignment->double_periods_per_week ?? 0) }}" required />
        <x-input-error :messages="$errors->get('double_periods_per_week')" class="mt-2" />
    </div>
</div>
<p class="text-xs text-gray-400 mt-1">Used by the timetable auto-generator. E.g. 5 periods/week with 1 double = one 2-period block + 3 single periods.</p>

<div class="flex items-center justify-end gap-3 mt-6">
    <a href="{{ route('admin.teacher-assignments.index') }}" class="text-sm text-gray-600 hover:text-gray-900">Cancel</a>
    <x-primary-button>{{ $submitLabel ?? 'Save' }}</x-primary-button>
</div>

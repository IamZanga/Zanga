<?php if (isset($component)) { $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.admin','data' => ['title' => 'Timetable - '.e($classRoom->name).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Timetable - '.e($classRoom->name).'']); ?>
    <div class="flex items-center justify-between mb-4">
        <a href="<?php echo e(route('admin.timetables.index')); ?>" class="text-sm text-gray-500 hover:text-gray-800">&larr; All Classes</a>
        <div class="flex items-center gap-3">
            <form method="POST" action="<?php echo e(route('admin.timetables.generate', $classRoom)); ?>"
                  onsubmit="return confirm('Auto-fill empty timetable slots for <?php echo e($classRoom->name); ?> based on teacher assignments? Existing entries will not be touched.');">
                <?php echo csrf_field(); ?>
                <button type="submit" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-xs font-semibold uppercase tracking-widest text-gray-700 rounded-md hover:bg-gray-50 transition">
                    Auto-Generate
                </button>
            </form>
            <a href="<?php echo e(route('admin.timetables.create', $classRoom)); ?>"
               class="inline-flex items-center px-4 py-2 bg-gray-800 text-white text-xs font-semibold uppercase tracking-widest rounded-md hover:bg-gray-700 transition">
                Add Entry
            </a>
        </div>
    </div>

    <?php if(session('generator_warnings') && count(session('generator_warnings')) > 0): ?>
        <div class="mb-6 bg-amber-50 border border-amber-200 text-amber-800 text-sm rounded-lg px-4 py-3">
            <p class="font-semibold mb-1">Some periods couldn't be auto-placed:</p>
            <ul class="list-disc list-inside space-y-0.5">
                <?php $__currentLoopData = session('generator_warnings'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $warning): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($warning); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">Day</th>
                    <th class="px-6 py-3">Period</th>
                    <th class="px-6 py-3">Subject</th>
                    <th class="px-6 py-3">Teacher</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                <?php $__empty_1 = true; $__currentLoopData = $entries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $entry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-800"><?php echo e($entry->day); ?></td>
                        <td class="px-6 py-4 text-gray-600"><?php echo e($entry->period); ?></td>
                        <td class="px-6 py-4 text-gray-600"><?php echo e($entry->subject->name); ?></td>
                        <td class="px-6 py-4 text-gray-600"><?php echo e($entry->teacher->name ?? '—'); ?></td>
                        <td class="px-6 py-4 text-right">
                            <a href="<?php echo e(route('admin.timetables.edit', [$classRoom, $entry])); ?>" class="text-blue-600 font-medium hover:underline">Edit</a>

                            <form method="POST" action="<?php echo e(route('admin.timetables.destroy', [$classRoom, $entry])); ?>"
                                  class="inline"
                                  onsubmit="return confirm('Remove this timetable entry?');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-red-600 font-medium hover:underline ml-4">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="5" class="px-6 py-8 text-center text-gray-400">No timetable entries yet for <?php echo e($classRoom->name); ?>. Try Auto-Generate, or add entries manually.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3)): ?>
<?php $attributes = $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3; ?>
<?php unset($__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc8c9fd5d7827a77a31381de67195f0c3)): ?>
<?php $component = $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3; ?>
<?php unset($__componentOriginalc8c9fd5d7827a77a31381de67195f0c3); ?>
<?php endif; ?>
<?php /**PATH C:\Users\user\Desktop\Laravel Migration\Students Portal\resources\views/admin/timetables/show.blade.php ENDPATH**/ ?>
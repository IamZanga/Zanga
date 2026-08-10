<?php if (isset($component)) { $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.admin','data' => ['title' => 'Teacher Assignments']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Teacher Assignments']); ?>
    <div class="flex items-center justify-end mb-4">
        <a href="<?php echo e(route('admin.teacher-assignments.create')); ?>"
           class="inline-flex items-center px-4 py-2 bg-gray-800 text-white text-xs font-semibold uppercase tracking-widest rounded-md hover:bg-gray-700 transition">
            New Assignment
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">Teacher</th>
                    <th class="px-6 py-3">Class</th>
                    <th class="px-6 py-3">Subject</th>
                    <th class="px-6 py-3">Periods/Week</th>
                    <th class="px-6 py-3">Grade Teacher?</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                <?php $__empty_1 = true; $__currentLoopData = $assignments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $assignment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-800"><?php echo e($assignment->teacher->name); ?></td>
                        <td class="px-6 py-4 text-gray-600"><?php echo e($assignment->classRoom->name); ?></td>
                        <td class="px-6 py-4 text-gray-600"><?php echo e($assignment->subject->name ?? '—'); ?></td>
                        <td class="px-6 py-4 text-gray-600">
                            <?php echo e($assignment->periods_per_week); ?>

                            <?php if($assignment->double_periods_per_week): ?>
                                <span class="text-xs text-gray-400">(<?php echo e($assignment->double_periods_per_week); ?> double)</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4">
                            <?php if($assignment->is_grade_teacher): ?>
                                <span class="px-2 py-1 rounded text-xs font-medium bg-green-50 text-green-700">Yes</span>
                            <?php else: ?>
                                <span class="text-gray-300 text-xs">—</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="<?php echo e(route('admin.teacher-assignments.edit', $assignment)); ?>" class="text-blue-600 font-medium hover:underline">Edit</a>

                            <form method="POST" action="<?php echo e(route('admin.teacher-assignments.destroy', $assignment)); ?>"
                                  class="inline"
                                  onsubmit="return confirm('Remove this assignment? The teacher will lose access to this class/subject.');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-red-600 font-medium hover:underline ml-4">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="6" class="px-6 py-8 text-center text-gray-400">No teacher assignments yet.</td></tr>
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
<?php /**PATH C:\Users\user\Desktop\Laravel Migration\Students Portal\resources\views/admin/teacher-assignments/index.blade.php ENDPATH**/ ?>
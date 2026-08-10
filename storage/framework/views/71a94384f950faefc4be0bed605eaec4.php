<?php if (isset($component)) { $__componentOriginal9768243ef9a1691d6a25d3a0a16e62a2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9768243ef9a1691d6a25d3a0a16e62a2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.portal','data' => ['title' => 'Grades']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.portal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Grades']); ?>
    <div class="bg-white rounded-xl shadow-sm border overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">Term</th>
                    <th class="px-6 py-3">Subject</th>
                    <th class="px-6 py-3">Assessment</th>
                    <th class="px-6 py-3">Score</th>
                    <th class="px-6 py-3">Grade</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                <?php $__empty_1 = true; $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 font-medium text-gray-800"><?php echo e($grade->term->name); ?></td>
                        <td class="px-6 py-4 text-gray-600"><?php echo e($grade->subject->name); ?></td>
                        <td class="px-6 py-4 text-gray-600"><?php echo e($grade->assessment_type); ?></td>
                        <td class="px-6 py-4 text-gray-600"><?php echo e($grade->score); ?> / <?php echo e($grade->max_score); ?></td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded text-xs font-medium bg-blue-50 text-blue-700"><?php echo e($grade->grade ?? '—'); ?></span>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="5" class="px-6 py-8 text-center text-gray-400">No grades available yet.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9768243ef9a1691d6a25d3a0a16e62a2)): ?>
<?php $attributes = $__attributesOriginal9768243ef9a1691d6a25d3a0a16e62a2; ?>
<?php unset($__attributesOriginal9768243ef9a1691d6a25d3a0a16e62a2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9768243ef9a1691d6a25d3a0a16e62a2)): ?>
<?php $component = $__componentOriginal9768243ef9a1691d6a25d3a0a16e62a2; ?>
<?php unset($__componentOriginal9768243ef9a1691d6a25d3a0a16e62a2); ?>
<?php endif; ?>
<?php /**PATH C:\Users\user\Desktop\Laravel Migration\Students Portal\resources\views/grades.blade.php ENDPATH**/ ?>
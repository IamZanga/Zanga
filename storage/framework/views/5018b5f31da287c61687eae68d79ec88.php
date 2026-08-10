<?php if (isset($component)) { $__componentOriginal9768243ef9a1691d6a25d3a0a16e62a2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9768243ef9a1691d6a25d3a0a16e62a2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.portal','data' => ['title' => 'Timetable']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.portal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Timetable']); ?>
    <div class="bg-white rounded-xl shadow-sm border overflow-x-auto">
        <table class="w-full text-sm text-left border-collapse">
            <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 border-b sticky left-0 bg-gray-50">Day</th>
                    <?php $__currentLoopData = $periods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $period): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <th class="px-4 py-3 border-b border-l"><?php echo e($period); ?></th>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $days; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="border-b">
                        <td class="px-4 py-4 font-medium text-gray-800 sticky left-0 bg-white"><?php echo e($day); ?></td>
                        <?php $__currentLoopData = $periods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $period): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $entry = $grid[$day][$period] ?? null; ?>
                            <td class="px-4 py-4 border-l align-top">
                                <?php if($entry): ?>
                                    <p class="font-medium text-gray-800"><?php echo e($entry->subject->name); ?></p>
                                    <p class="text-xs text-gray-500 mt-0.5"><?php echo e($entry->teacher->name ?? '—'); ?></p>
                                <?php else: ?>
                                    <span class="text-gray-300">—</span>
                                <?php endif; ?>
                            </td>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td class="px-4 py-8 text-center text-gray-400">No timetable available yet.</td></tr>
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
<?php endif; ?><?php /**PATH C:\Users\user\Desktop\Laravel Migration\Students Portal\resources\views/timetable.blade.php ENDPATH**/ ?>
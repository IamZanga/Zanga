<?php if (isset($component)) { $__componentOriginal9768243ef9a1691d6a25d3a0a16e62a2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9768243ef9a1691d6a25d3a0a16e62a2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.portal','data' => ['title' => 'Dashboard']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.portal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Dashboard']); ?>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        <a href="<?php echo e(route('timetable')); ?>" class="bg-white rounded-xl shadow-sm border p-6 hover:shadow-md transition">
            <p class="text-sm font-medium text-gray-500">Timetable</p>
            <p class="text-xl font-semibold text-gray-800 mt-1">View schedule</p>
        </a>

        <a href="<?php echo e(route('grades')); ?>" class="bg-white rounded-xl shadow-sm border p-6 hover:shadow-md transition">
            <p class="text-sm font-medium text-gray-500">Grades</p>
            <p class="text-xl font-semibold text-gray-800 mt-1">View term results</p>
        </a>

        <a href="<?php echo e(route('notes')); ?>" class="bg-white rounded-xl shadow-sm border p-6 hover:shadow-md transition">
            <p class="text-sm font-medium text-gray-500">Notes</p>
            <p class="text-xl font-semibold text-gray-800 mt-1">View materials</p>
        </a>

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
<?php endif; ?><?php /**PATH C:\Users\user\Desktop\Laravel Migration\Students Portal\resources\views/dashboard.blade.php ENDPATH**/ ?>
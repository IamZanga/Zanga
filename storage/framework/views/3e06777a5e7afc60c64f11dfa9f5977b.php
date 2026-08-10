<?php if (isset($component)) { $__componentOriginalc8c9fd5d7827a77a31381de67195f0c3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc8c9fd5d7827a77a31381de67195f0c3 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.admin','data' => ['title' => 'Edit Student']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.admin'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Edit Student']); ?>
    <div class="bg-white rounded-xl shadow-sm border p-8 max-w-lg">
        <form method="POST" action="<?php echo e(route('admin.students.update', $student)); ?>">
            <?php echo method_field('PUT'); ?>
            <?php echo $__env->make('admin.students._form', ['submitLabel' => 'Save Changes'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </form>
    </div>

    <div class="bg-white rounded-xl shadow-sm border p-8 max-w-lg mt-6">
        <h2 class="text-sm font-semibold text-gray-800">Reset Password</h2>
        <p class="text-sm text-gray-500 mt-1">Resets this student's password back to their student number (<?php echo e($student->student_number); ?>) and forces them to set a new one on next login.</p>
        <form method="POST" action="<?php echo e(route('admin.students.reset-password', $student)); ?>" class="mt-4"
              onsubmit="return confirm('Reset password for <?php echo e($student->fullName()); ?>?');">
            <?php echo csrf_field(); ?>
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 text-xs font-semibold uppercase tracking-widest text-gray-700 rounded-md hover:bg-gray-50 transition">
                Reset Password
            </button>
        </form>
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
<?php /**PATH C:\Users\user\Desktop\Laravel Migration\Students Portal\resources\views/admin/students/edit.blade.php ENDPATH**/ ?>
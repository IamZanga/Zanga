<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e($title ?? 'Admin'); ?> - Kaunda Square Secondary School</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div class="flex min-h-screen">
        <aside class="w-64 bg-[#0B1739] text-white flex flex-col shrink-0">
            <div class="px-6 py-6 border-b border-white/10">
                <p class="font-semibold text-sm tracking-wide">Kaunda Square Secondary School</p>
                <p class="text-xs text-blue-300 mt-0.5">Admin</p>
            </div>

            <?php
                $navItems = [
                    ['label' => 'Dashboard', 'route' => 'admin.dashboard'],
                    ['label' => 'Classes', 'route' => 'admin.classes.index'],
                    ['label' => 'Subjects', 'route' => 'admin.subjects.index'],
                    ['label' => 'Terms', 'route' => 'admin.terms.index'],
                    ['label' => 'Teacher Assignments', 'route' => 'admin.teacher-assignments.index'],
                    ['label' => 'Students', 'route' => 'admin.students.index'],
                    ['label' => 'Timetable', 'route' => 'admin.timetables.index'],
                ];
            ?>

            <nav class="flex-1 px-3 py-4 space-y-1">
                <?php $__currentLoopData = $navItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route($item['route'])); ?>"
                       class="block px-3 py-2 rounded-lg text-sm font-medium transition
                              <?php echo e(request()->routeIs($item['route'].'*') ? 'bg-blue-600 text-white' : 'text-white/70 hover:bg-white/5 hover:text-white'); ?>">
                        <?php echo e($item['label']); ?>

                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </nav>

            <div class="px-6 py-4 border-t border-white/10">
                <form method="POST" action="<?php echo e(route('staff.logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="text-sm text-white/60 hover:text-white transition">Sign Out</button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col">
            <header class="bg-white border-b px-8 py-5">
                <h1 class="text-lg font-semibold text-gray-800"><?php echo e($title ?? 'Admin'); ?></h1>
            </header>
            <main class="flex-1 p-8">
                <?php if(session('status')): ?>
                    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg px-4 py-3">
                        <?php echo e(session('status')); ?>

                    </div>
                <?php endif; ?>

                <?php echo e($slot); ?>

            </main>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\Users\user\Desktop\Laravel Migration\Students Portal\resources\views/components/layouts/admin.blade.php ENDPATH**/ ?>
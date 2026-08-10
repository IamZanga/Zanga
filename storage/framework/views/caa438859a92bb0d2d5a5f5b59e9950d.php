<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e($title ?? 'Student Portal'); ?> - Kaunda Square Secondary School</title>
    <link rel="manifest" href="/manifest.json">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.13.5/cdn.min.js" defer></script>
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div class="flex min-h-screen">
        <aside class="w-64 bg-[#0B1739] text-white flex flex-col shrink-0">
            <div class="px-6 py-6 border-b border-white/10">
                <p class="font-semibold text-sm tracking-wide">Kaunda Square Secondary School</p>
                <p class="text-xs text-blue-300 mt-0.5">Student Portal</p>
            </div>

            <div class="px-6 py-6 border-b border-white/10 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-blue-500/20 flex items-center justify-center text-sm font-medium">
                    <?php echo e(substr(auth()->user()->first_name, 0, 1)); ?><?php echo e(substr(auth()->user()->last_name, 0, 1)); ?>

                </div>
                <div>
                    <p class="text-sm font-medium"><?php echo e(auth()->user()->first_name); ?> <?php echo e(auth()->user()->last_name); ?></p>
                    <p class="text-xs text-white/50"><?php echo e(auth()->user()->class); ?> - <?php echo e(auth()->user()->stream); ?></p>
                </div>
            </div>

            <?php
                $navItems = [
                    ['label' => 'Dashboard', 'route' => 'dashboard'],
                    ['label' => 'Timetable', 'route' => 'timetable'],
                    ['label' => 'Grades', 'route' => 'grades'],
                    ['label' => 'Notes', 'route' => 'notes'],
                ];
            ?>

            <nav class="flex-1 px-3 py-4 space-y-1">
                <?php $__currentLoopData = $navItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route($item['route'])); ?>"
                       class="block px-3 py-2 rounded-lg text-sm font-medium transition
                              <?php echo e(request()->routeIs($item['route']) ? 'bg-blue-600 text-white' : 'text-white/70 hover:bg-white/5 hover:text-white'); ?>">
                        <?php echo e($item['label']); ?>

                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </nav>

            <div class="px-6 py-4 border-t border-white/10">
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="text-sm text-white/60 hover:text-white transition">Sign Out</button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col">
            <header class="bg-white border-b px-8 py-5">
                <h1 class="text-lg font-semibold text-gray-800"><?php echo e($title ?? 'Dashboard'); ?></h1>
            </header>
            <main class="flex-1 p-8">
                <?php echo e($slot); ?>

            </main>
        </div>
    </div>

    <script>
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/sw.js')
                .then(() => console.log('Service worker registered'))
                .catch((err) => console.error('Service worker registration failed', err));
        }
    </script>
</body>
</html><?php /**PATH C:\Users\user\Desktop\Laravel Migration\Students Portal\resources\views/components/layouts/portal.blade.php ENDPATH**/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Teacher Dashboard - Kaunda Square Secondary School</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div class="min-h-screen flex flex-col">
        <header class="bg-[#0B1739] text-white px-8 py-5 flex items-center justify-between">
            <div>
                <p class="font-semibold text-sm tracking-wide">Kaunda Square Secondary School</p>
                <p class="text-xs text-blue-300 mt-0.5">Teacher Dashboard</p>
            </div>
            <form method="POST" action="<?php echo e(route('staff.logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="text-sm text-white/60 hover:text-white transition">Sign Out</button>
            </form>
        </header>

        <main class="flex-1 p-8">
            <div class="bg-white rounded-xl shadow-sm border p-8">
                <h1 class="text-lg font-semibold text-gray-800">Welcome, <?php echo e(auth('staff')->user()->name); ?></h1>
                <p class="text-sm text-gray-500 mt-1">Teacher modules (grade entry, attendance, timetable view, warnings, materials upload) go here.</p>
            </div>
        </main>
    </div>
</body>
</html>
<?php /**PATH C:\Users\user\Desktop\Laravel Migration\Students Portal\resources\views/teacher/dashboard.blade.php ENDPATH**/ ?>
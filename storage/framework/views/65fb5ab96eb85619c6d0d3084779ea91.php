<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e($title ?? 'Dashboard'); ?> - MedisCare</title>
    <link rel="manifest" href="<?php echo e(asset('manifest.json')); ?>">
    <meta name="theme-color" content="#0f766e">
    <link rel="apple-touch-icon" href="<?php echo e(asset('icons/icon-192x192.png')); ?>">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="MedisCare">
    <link rel="apple-touch-startup-image" href="<?php echo e(asset('icons/splash-1080x1920.png')); ?>">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-slate-50 min-h-screen pb-20 md:pb-0" x-data="{ sidebarOpen: false }">

    
    <aside class="hidden md:flex md:flex-col md:w-64 md:fixed md:inset-y-0 bg-white border-r border-slate-200">
        <div class="h-16 flex items-center px-6 font-semibold text-teal-700">MedisCare</div>
        <nav class="flex-1 px-3 space-y-1 text-sm">
            <a href="<?php echo e(route('dashboard')); ?>" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-100">Dashboard</a>
            <a href="<?php echo e(route('patients.index')); ?>" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-100">Pasien</a>
            <a href="<?php echo e(route('schedules.index')); ?>" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-100">Jadwal Dokter</a>
            <a href="<?php echo e(route('queue.index')); ?>" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-100">Antrean</a>
            <a href="<?php echo e(route('reports.index')); ?>" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-100">Laporan</a>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create', \App\Models\Invoice::class)): ?>
                <a href="<?php echo e(route('invoices.index')); ?>" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-100">Invoice</a>
            <?php endif; ?>
            <?php if(auth()->user()->hasPermission('pharmacy.manage')): ?>
                <a href="<?php echo e(route('prescriptions.index')); ?>" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-100">Resep</a>
            <?php endif; ?>
                <a href="<?php echo e(route('polyclinics.index')); ?>" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-100">Poliklinik</a>
            <?php if(auth()->user()->hasPermission('users.manage')): ?>
                <a href="<?php echo e(route('users.index')); ?>" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-100">Pengguna</a>
            <?php endif; ?>
            <?php if(auth()->user()->hasRole('super_admin', 'admin_rs')): ?>
                <a href="<?php echo e(route('settings.index')); ?>" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-100">Pengaturan</a>
            <?php endif; ?>
                <a href="<?php echo e(route('notifications.index')); ?>" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-100">
                Notifikasi
                <?php if(auth()->user()->unreadNotifications()->count() > 0): ?>
                    <span class="text-xs bg-red-500 text-white rounded-full px-1.5"><?php echo e(auth()->user()->unreadNotifications()->count()); ?></span>
            <?php endif; ?>
        </a>
        <a href="<?php echo e(route('profile.show')); ?>" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-100">Profil</a>
    </nav>
</aside>

    <div class="md:pl-64">
        <header class="h-16 flex items-center justify-between px-4 bg-white border-b border-slate-200 sticky top-0 z-10">
            <h1 class="font-semibold text-slate-800"><?php echo e($title ?? 'Dashboard'); ?></h1>
            <span class="text-xs text-slate-500"><?php echo e(auth()->user()->name); ?> &middot; <?php echo e(auth()->user()->role?->name); ?></span>
        </header>

        <main class="p-4">
            <?php if(session('status')): ?>
                <div class="mb-4 rounded-xl bg-teal-50 text-teal-800 text-sm px-4 py-3"><?php echo e(session('status')); ?></div>
            <?php endif; ?>
            <?php echo e($slot); ?>

        </main>
    </div>

    
<nav class="md:hidden fixed bottom-0 inset-x-0 bg-white border-t border-slate-200 flex justify-around py-2 z-20">
    <a href="<?php echo e(route('dashboard')); ?>" class="flex flex-col items-center text-xs text-teal-700 px-2 py-1">
        <span class="text-lg">🏠</span>Dashboard
    </a>
    <a href="<?php echo e(route('patients.index')); ?>" class="flex flex-col items-center text-xs text-slate-500 px-2 py-1">
        <span class="text-lg">🧑‍🤝‍🧑</span>Pasien
    </a>
    <a href="<?php echo e(route('schedules.index')); ?>" class="flex flex-col items-center text-xs text-slate-500 px-2 py-1">
        <span class="text-lg">🗓️</span>Jadwal
    </a>
    <a href="<?php echo e(route('queue.index')); ?>" class="flex flex-col items-center text-xs text-slate-500 px-2 py-1">
        <span class="text-lg">🎫</span>Antrean
    </a>
    <a href="<?php echo e(route('profile.show')); ?>" class="flex flex-col items-center text-xs text-slate-500 px-2 py-1">
        <span class="text-lg">👤</span>Profil
    </a>
</nav>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/js/charts.js']); ?>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\xampp5\htdocs\Project_SIMRS\mediscare\resources\views/components/layouts/app.blade.php ENDPATH**/ ?>
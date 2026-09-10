<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e($title ?? 'MedisCare'); ?> - MedisCare SIMRS</title>
    <link rel="manifest" href="<?php echo e(asset('manifest.json')); ?>">
    <meta name="theme-color" content="#0f766e">
    <link rel="apple-touch-icon" href="<?php echo e(asset('icons/icon-192x192.png')); ?>">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center px-4">
    <div class="w-full max-w-sm">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-teal-600 text-white text-xl font-bold mb-3">M+</div>
            <h1 class="text-xl font-semibold text-slate-800">MedisCare</h1>
            <p class="text-sm text-slate-500">Sistem Informasi Manajemen Rumah Sakit</p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm p-6">
            <?php echo e($slot); ?>

        </div>
    </div>
</body>
</html>
<?php /**PATH C:\xampp5\htdocs\Project_SIMRS\mediscare\resources\views/components/layouts/guest.blade.php ENDPATH**/ ?>
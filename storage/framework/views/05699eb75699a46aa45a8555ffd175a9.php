<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Dashboard Antrean']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Dashboard Antrean']); ?>
    <form method="GET" class="mb-4">
        <select name="polyclinic_id" onchange="this.form.submit()" class="rounded-xl border-slate-300 text-sm py-2.5 px-4">
            <option value="">Semua Poli</option>
            <?php $__currentLoopData = $polyclinics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $polyclinic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($polyclinic->id); ?>" <?php if($polyclinicId == $polyclinic->id): echo 'selected'; endif; ?>><?php echo e($polyclinic->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </form>

    <div class="grid md:grid-cols-2 gap-4 mb-6">
        <div class="bg-teal-600 text-white rounded-2xl shadow-sm p-6 text-center">
            <p class="text-xs uppercase tracking-wide opacity-80 mb-1">Nomor Saat Ini</p>
            <p class="text-5xl font-bold"><?php echo e($current->queue_number ?? '-'); ?></p>
            <p class="text-sm opacity-80 mt-1"><?php echo e($current?->appointment?->patient?->full_name ?? 'Belum ada panggilan'); ?></p>
        </div>
        <div class="bg-white rounded-2xl shadow-sm p-6 text-center">
            <p class="text-xs uppercase tracking-wide text-slate-400 mb-1">Berikutnya</p>
            <p class="text-5xl font-bold text-slate-700"><?php echo e($waiting->first()->queue_number ?? '-'); ?></p>
            <p class="text-sm text-slate-400 mt-1"><?php echo e($waiting->first()?->appointment?->patient?->full_name ?? 'Tidak ada antrean'); ?></p>
        </div>
    </div>

    <?php if($current): ?>
        <div class="flex gap-2 mb-6">
            <form method="POST" action="<?php echo e(route('queue.recall', $current)); ?>">
                <?php echo csrf_field(); ?>
                <button class="px-4 py-2.5 bg-slate-800 text-white rounded-xl text-sm">🔁 Panggil Ulang</button>
            </form>
            <form method="POST" action="<?php echo e(route('queue.complete', $current)); ?>">
                <?php echo csrf_field(); ?>
                <button class="px-4 py-2.5 bg-teal-600 text-white rounded-xl text-sm">✓ Selesaikan</button>
            </form>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-2xl shadow-sm p-4">
        <div class="flex items-center justify-between mb-3">
            <h3 class="text-sm font-semibold text-slate-700">Daftar Menunggu (<?php echo e($waiting->count()); ?>)</h3>
            <span class="text-xs text-slate-400"><?php echo e($completedCount); ?> selesai hari ini</span>
        </div>
        <div class="space-y-2">
            <?php $__empty_1 = true; $__currentLoopData = $waiting; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $queue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="flex items-center justify-between border-b last:border-0 border-slate-100 py-2 text-sm">
                    <div>
                        <span class="font-semibold text-teal-700"><?php echo e($queue->queue_number); ?></span>
                        <span class="text-slate-600 ml-2"><?php echo e($queue->appointment->patient->full_name); ?></span>
                    </div>
                    <div class="flex gap-2">
                        <form method="POST" action="<?php echo e(route('queue.call', $queue)); ?>">
                            <?php echo csrf_field(); ?>
                            <button class="px-3 py-1.5 bg-teal-600 text-white rounded-lg text-xs">Panggil</button>
                        </form>
                        <form method="POST" action="<?php echo e(route('queue.skip', $queue)); ?>">
                            <?php echo csrf_field(); ?>
                            <button class="px-3 py-1.5 bg-slate-100 text-slate-600 rounded-lg text-xs">Lewati</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-sm text-slate-400 text-center py-6">Tidak ada antrean menunggu.</p>
            <?php endif; ?>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $attributes = $__attributesOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__attributesOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $component = $__componentOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__componentOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?>
<?php /**PATH C:\xampp5\htdocs\Project_SIMRS\mediscare\resources\views/queue/index.blade.php ENDPATH**/ ?>
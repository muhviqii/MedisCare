<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Jadwal Dokter']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Jadwal Dokter']); ?>
    <div class="flex flex-wrap items-center gap-2 mb-4">
        <div class="flex bg-white rounded-xl shadow-sm p-1 text-sm">
            <?php $__currentLoopData = ['daily' => 'Harian', 'weekly' => 'Mingguan', 'monthly' => 'Bulanan']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <a href="<?php echo e(route('schedules.index', ['view' => $key])); ?>"
                   class="px-3 py-1.5 rounded-lg <?php echo e($view === $key ? 'bg-teal-600 text-white' : 'text-slate-500'); ?>"><?php echo e($label); ?></a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <select onchange="location.href='<?php echo e(route('schedules.index')); ?>?view=<?php echo e($view); ?>&doctor_id='+this.value"
                class="rounded-xl border-slate-300 text-sm py-2 px-3">
            <option value="">Semua Dokter</option>
            <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($doctor->id); ?>" <?php if(request('doctor_id') == $doctor->id): echo 'selected'; endif; ?>><?php echo e($doctor->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create', \App\Models\DoctorSchedule::class)): ?>
        <?php endif; ?>
        <a href="<?php echo e(route('schedules.create')); ?>" class="ml-auto px-4 py-2 bg-teal-600 text-white rounded-xl text-sm font-medium">+ Tambah Jadwal</a>
    </div>

    <p class="text-xs text-slate-500 mb-3"><?php echo e($start->translatedFormat('d M Y')); ?> &ndash; <?php echo e($end->translatedFormat('d M Y')); ?></p>

    <div class="space-y-4">
        <?php $__empty_1 = true; $__currentLoopData = $schedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $daySchedules): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white rounded-2xl shadow-sm p-4">
                <h3 class="text-sm font-semibold text-slate-700 mb-2"><?php echo e(\Illuminate\Support\Carbon::parse($date)->translatedFormat('l, d F Y')); ?></h3>
                <div class="space-y-2">
                    <?php $__currentLoopData = $daySchedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $schedule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center justify-between text-sm py-2 border-b last:border-0 border-slate-100">
                            <div>
                                <p class="font-medium text-slate-800"><?php echo e($schedule->doctor->name); ?></p>
                                <p class="text-xs text-slate-500"><?php echo e($schedule->start_time); ?>-<?php echo e($schedule->end_time); ?> &middot; <?php echo e($schedule->polyclinic?->name ?? $schedule->doctor->polyclinic?->name); ?></p>
                            </div>
                            <span class="text-xs px-2 py-0.5 rounded-full
                                <?php echo e(match($schedule->status) { 'available' => 'bg-teal-50 text-teal-700', 'on_leave' => 'bg-amber-50 text-amber-700', 'cancelled' => 'bg-red-50 text-red-700', default => 'bg-slate-100 text-slate-500' }); ?>">
                                <?php echo e(match($schedule->status) { 'available' => 'Tersedia', 'on_leave' => 'Cuti', 'holiday' => 'Libur', 'cancelled' => 'Dibatalkan', default => $schedule->status }); ?>

                            </span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-sm text-slate-400 text-center py-8">Tidak ada jadwal pada rentang ini.</p>
        <?php endif; ?>
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
<?php /**PATH C:\xampp5\htdocs\Project_SIMRS\mediscare\resources\views/schedules/index.blade.php ENDPATH**/ ?>
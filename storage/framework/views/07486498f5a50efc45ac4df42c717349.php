<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Tambah Jadwal Dokter']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Tambah Jadwal Dokter']); ?>
    <div class="max-w-xl mx-auto bg-white rounded-2xl shadow-sm p-5">
        <h2 class="font-semibold text-slate-800 mb-4">Tambah Jadwal Dokter</h2>

        <?php if(session('conflicts')): ?>
            <div class="mb-4 rounded-xl bg-amber-50 text-amber-800 text-sm px-4 py-3">
                <p class="font-medium mb-1">⚠ Jadwal bertabrakan terdeteksi:</p>
                <ul class="list-disc list-inside">
                    <?php $__currentLoopData = session('conflicts'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conflict): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($conflict->start_time); ?>-<?php echo e($conflict->end_time); ?> (<?php echo e(ucfirst($conflict->status)); ?>)</li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <label class="flex items-center gap-2 mt-2">
                    <input type="checkbox" form="schedule-form" name="force" value="1" class="rounded border-amber-400">
                    Tetap simpan meskipun bertabrakan
                </label>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('schedules.store')); ?>" id="schedule-form" class="space-y-4">
            <?php echo csrf_field(); ?>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Dokter <span class="text-red-500">*</span></label>
                <select name="doctor_id" required class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                    <option value="">-- Pilih Dokter --</option>
                    <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($doctor->id); ?>" <?php if(old('doctor_id') == $doctor->id): echo 'selected'; endif; ?>><?php echo e($doctor->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['doctor_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal <span class="text-red-500">*</span></label>
                <input type="date" name="schedule_date" value="<?php echo e(old('schedule_date')); ?>" required
                       class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                <?php $__errorArgs = ['schedule_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Jam Mulai <span class="text-red-500">*</span></label>
                    <input type="time" name="start_time" value="<?php echo e(old('start_time')); ?>" required
                           class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Jam Selesai <span class="text-red-500">*</span></label>
                    <input type="time" name="end_time" value="<?php echo e(old('end_time')); ?>" required
                           class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                </div>
            </div>
            <?php $__errorArgs = ['end_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-xs -mt-2"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Ruangan</label>
                <input type="text" name="room" value="<?php echo e(old('room')); ?>" class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Status <span class="text-red-500">*</span></label>
                <select name="status" required class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                    <?php $__currentLoopData = ['available' => 'Tersedia', 'on_leave' => 'Cuti', 'holiday' => 'Libur', 'cancelled' => 'Dibatalkan']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($value); ?>" <?php if(old('status', 'available') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <button type="submit" class="w-full bg-teal-600 text-white rounded-xl py-3 text-sm font-medium hover:bg-teal-700">
                Simpan Jadwal
            </button>
        </form>
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
<?php /**PATH C:\xampp5\htdocs\Project_SIMRS\mediscare\resources\views/schedules/create.blade.php ENDPATH**/ ?>
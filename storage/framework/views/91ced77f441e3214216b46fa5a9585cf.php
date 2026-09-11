<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => $patient->full_name]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($patient->full_name)]); ?>
    <div class="flex items-center justify-between mb-4">
        <div>
            <h2 class="font-semibold text-slate-800 text-lg"><?php echo e($patient->full_name); ?></h2>
            <p class="text-xs text-slate-500"><?php echo e($patient->medical_record_number); ?> &middot; NIK <?php echo e($patient->nik); ?> &middot; <?php echo e($patient->age()); ?> tahun</p>
        </div>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $patient)): ?>
            <a href="<?php echo e(route('patients.edit', $patient)); ?>" class="px-4 py-2 bg-slate-800 text-white rounded-xl text-sm">Edit</a>
        <?php endif; ?>
    </div>

    <div class="grid md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white rounded-2xl shadow-sm p-4 md:col-span-2">
            <h3 class="text-sm font-semibold text-slate-700 mb-3">Informasi Pasien</h3>
            <dl class="grid grid-cols-2 gap-y-2 text-sm">
                <dt class="text-slate-400">Jenis Kelamin</dt><dd><?php echo e($patient->gender === 'male' ? 'Laki-laki' : 'Perempuan'); ?></dd>
                <dt class="text-slate-400">Tanggal Lahir</dt><dd><?php echo e($patient->birth_date->translatedFormat('d F Y')); ?></dd>
                <dt class="text-slate-400">Golongan Darah</dt><dd><?php echo e($patient->blood_type); ?></dd>
                <dt class="text-slate-400">Alergi</dt><dd><?php echo e($patient->allergies ?: '-'); ?></dd>
                <dt class="text-slate-400">Telepon</dt><dd><?php echo e($patient->phone ?: '-'); ?></dd>
                <dt class="text-slate-400">Alamat</dt><dd><?php echo e($patient->address ?: '-'); ?></dd>
                <dt class="text-slate-400">Kontak Darurat</dt><dd><?php echo e($patient->emergency_contact_name ?: '-'); ?> (<?php echo e($patient->emergency_contact_phone ?: '-'); ?>)</dd>
            </dl>
        </div>
        <div class="bg-white rounded-2xl shadow-sm p-4">
            <h3 class="text-sm font-semibold text-slate-700 mb-3">Status</h3>
            <span class="text-xs px-3 py-1 rounded-full <?php echo e($patient->status === 'active' ? 'bg-teal-50 text-teal-700' : 'bg-slate-100 text-slate-500'); ?>">
                <?php echo e($patient->status === 'active' ? 'Aktif' : 'Nonaktif'); ?>

            </span>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create', \App\Models\MedicalRecord::class)): ?>
                <a href="<?php echo e(route('medical-records.create', ['patient_id' => $patient->id])); ?>"
                   class="mt-4 block text-center bg-teal-600 text-white rounded-xl py-2.5 text-sm font-medium hover:bg-teal-700">
                    + Rekam Medis Baru
                </a>
            <?php endif; ?>
        </div>
    </div>

    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('viewAny', \App\Models\MedicalRecord::class)): ?>
    <div class="bg-white rounded-2xl shadow-sm p-4 mb-4">
        <h3 class="text-sm font-semibold text-slate-700 mb-3">Riwayat Rekam Medis</h3>
        <?php $__empty_1 = true; $__currentLoopData = $patient->medicalRecords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <a href="<?php echo e(route('medical-records.show', $record)); ?>" class="flex items-center justify-between py-2 border-b last:border-0 border-slate-100">
                <span class="text-sm text-slate-700"><?php echo e($record->examination_date->translatedFormat('d M Y')); ?> &middot; <?php echo e($record->record_code); ?></span>
                <span class="text-xs text-teal-700">Lihat &rarr;</span>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-sm text-slate-400">Belum ada rekam medis.</p>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <div class="bg-white rounded-2xl shadow-sm p-4">
        <h3 class="text-sm font-semibold text-slate-700 mb-3">Riwayat Kunjungan</h3>
        <?php $__empty_1 = true; $__currentLoopData = $patient->appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appointment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="flex items-center justify-between py-2 border-b last:border-0 border-slate-100 text-sm">
                <span><?php echo e($appointment->appointment_date->translatedFormat('d M Y')); ?> &middot; <?php echo e($appointment->appointment_code); ?></span>
                <span class="text-xs text-slate-500"><?php echo e(ucfirst($appointment->status)); ?></span>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-sm text-slate-400">Belum ada riwayat kunjungan.</p>
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
<?php /**PATH C:\xampp5\htdocs\Project_SIMRS\mediscare\resources\views/patients/show.blade.php ENDPATH**/ ?>
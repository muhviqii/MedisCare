<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Detail Rekam Medis']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Detail Rekam Medis']); ?>
    <div class="max-w-2xl mx-auto space-y-4">
        <div class="bg-white rounded-2xl shadow-sm p-5">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <h2 class="font-semibold text-slate-800"><?php echo e($medicalRecord->record_code); ?></h2>
                    <p class="text-xs text-slate-500"><?php echo e($medicalRecord->patient->full_name); ?> &middot; <?php echo e($medicalRecord->examination_date->translatedFormat('d F Y H:i')); ?></p>
                </div>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $medicalRecord)): ?>
                    <a href="<?php echo e(route('medical-records.edit', $medicalRecord)); ?>" class="px-3 py-2 bg-slate-800 text-white rounded-xl text-xs">Edit</a>
                <?php endif; ?>
            </div>

            <dl class="grid grid-cols-2 gap-y-2 text-sm">
                <dt class="text-slate-400">Dokter</dt><dd><?php echo e($medicalRecord->doctor->name ?? '-'); ?></dd>
                <dt class="text-slate-400">Keluhan Utama</dt><dd><?php echo e($medicalRecord->chief_complaint ?: '-'); ?></dd>
                <dt class="text-slate-400">Tekanan Darah</dt><dd><?php echo e($medicalRecord->blood_pressure ?: '-'); ?></dd>
                <dt class="text-slate-400">Denyut Nadi</dt><dd><?php echo e($medicalRecord->pulse_rate ?: '-'); ?></dd>
                <dt class="text-slate-400">Suhu</dt><dd><?php echo e($medicalRecord->temperature ?: '-'); ?> &deg;C</dd>
                <dt class="text-slate-400">Saturasi O2</dt><dd><?php echo e($medicalRecord->oxygen_saturation ?: '-'); ?>%</dd>
                <dt class="text-slate-400">Berat/Tinggi</dt><dd><?php echo e($medicalRecord->weight_kg ?: '-'); ?> kg / <?php echo e($medicalRecord->height_cm ?: '-'); ?> cm</dd>
            </dl>
        </div>

        <?php if($medicalRecord->diagnoses->isNotEmpty()): ?>
        <div class="bg-white rounded-2xl shadow-sm p-5">
            <h3 class="text-sm font-semibold text-slate-700 mb-2">Diagnosis</h3>
            <?php $__currentLoopData = $medicalRecord->diagnoses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $diagnosis): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <p class="text-sm py-1"><?php echo e($diagnosis->diagnosis_name); ?> <?php if($diagnosis->icd10_code): ?> <span class="text-xs text-slate-400">(<?php echo e($diagnosis->icd10_code); ?>)</span><?php endif; ?></p>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>

        <div class="bg-white rounded-2xl shadow-sm p-5">
            <h3 class="text-sm font-semibold text-slate-700 mb-2">Catatan Dokter & Rencana Terapi</h3>
            <p class="text-sm text-slate-600 whitespace-pre-line"><?php echo e($medicalRecord->doctor_notes ?: '-'); ?></p>
            <p class="text-sm text-slate-600 whitespace-pre-line mt-2"><?php echo e($medicalRecord->treatment_plan ?: '-'); ?></p>
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
<?php /**PATH C:\xampp5\htdocs\Project_SIMRS\mediscare\resources\views/medical-records/show.blade.php ENDPATH**/ ?>
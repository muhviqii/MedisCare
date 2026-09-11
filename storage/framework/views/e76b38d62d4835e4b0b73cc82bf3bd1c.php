<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Rekam Medis Baru']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Rekam Medis Baru']); ?>
    <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-sm p-5">
        <h2 class="font-semibold text-slate-800 mb-1">Rekam Medis Baru</h2>
        <p class="text-xs text-slate-500 mb-4">Pasien: <?php echo e($patient->full_name); ?> (<?php echo e($patient->medical_record_number); ?>)</p>

        <form method="POST" action="<?php echo e(route('medical-records.store')); ?>" class="space-y-4">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="patient_id" value="<?php echo e($patient->id); ?>">

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Dokter <span class="text-red-500">*</span></label>
                <select name="doctor_id" required class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                    <option value="">-- Pilih Dokter --</option>
                    <?php $__currentLoopData = \App\Models\Doctor::where('status', 'active')->orderBy('name')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($doctor->id); ?>" <?php if(old('doctor_id') == $doctor->id): echo 'selected'; endif; ?>>
                            <?php echo e($doctor->name); ?> (<?php echo e($doctor->specialty?->name); ?>)
                        </option>
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
                <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal & Waktu Pemeriksaan <span class="text-red-500">*</span></label>
                <input type="datetime-local" name="examination_date" value="<?php echo e(old('examination_date', now()->format('Y-m-d\TH:i'))); ?>" required
                       class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Keluhan Utama</label>
                <textarea name="chief_complaint" rows="2" class="w-full rounded-xl border-slate-300 text-sm py-3 px-4"><?php echo e(old('chief_complaint')); ?></textarea>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Tekanan Darah</label>
                    <input type="text" name="blood_pressure" placeholder="120/80" class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Denyut Nadi</label>
                    <input type="number" name="pulse_rate" class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Suhu (&deg;C)</label>
                    <input type="number" step="0.1" name="temperature" class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Saturasi O2 (%)</label>
                    <input type="number" name="oxygen_saturation" class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Berat Badan (kg)</label>
                    <input type="number" step="0.1" name="weight_kg" class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Tinggi Badan (cm)</label>
                    <input type="number" step="0.1" name="height_cm" class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Diagnosis</label>
                <input type="text" name="diagnoses[0][diagnosis_name]" placeholder="Nama diagnosis"
                       class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Catatan Dokter</label>
                <textarea name="doctor_notes" rows="3" class="w-full rounded-xl border-slate-300 text-sm py-3 px-4"><?php echo e(old('doctor_notes')); ?></textarea>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Rencana Terapi</label>
                <textarea name="treatment_plan" rows="2" class="w-full rounded-xl border-slate-300 text-sm py-3 px-4"><?php echo e(old('treatment_plan')); ?></textarea>
            </div>

            <button type="submit" class="w-full bg-teal-600 text-white rounded-xl py-3 text-sm font-medium hover:bg-teal-700">
                Simpan Rekam Medis
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
<?php /**PATH C:\xampp5\htdocs\Project_SIMRS\mediscare\resources\views/medical-records/create.blade.php ENDPATH**/ ?>
<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Laporan Kunjungan']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Laporan Kunjungan']); ?>
    <form method="GET" class="flex gap-2 flex-wrap mb-4">
        <input type="date" name="from" value="<?php echo e(request('from')); ?>" class="rounded-xl border-slate-300 text-sm py-2 px-3">
        <input type="date" name="to" value="<?php echo e(request('to')); ?>" class="rounded-xl border-slate-300 text-sm py-2 px-3">
        <select name="doctor_id" class="rounded-xl border-slate-300 text-sm py-2 px-3">
            <option value="">Semua Dokter</option>
            <?php $__currentLoopData = $doctors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doctor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($doctor->id); ?>" <?php if(request('doctor_id') == $doctor->id): echo 'selected'; endif; ?>><?php echo e($doctor->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <select name="polyclinic_id" class="rounded-xl border-slate-300 text-sm py-2 px-3">
            <option value="">Semua Poli</option>
            <?php $__currentLoopData = $polyclinics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $poly): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($poly->id); ?>" <?php if(request('polyclinic_id') == $poly->id): echo 'selected'; endif; ?>><?php echo e($poly->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <button class="px-4 py-2 bg-slate-800 text-white rounded-xl text-sm">Filter</button>
    </form>

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                <tr><th class="text-left px-4 py-3">Tanggal</th><th class="text-left px-4 py-3">Pasien</th><th class="text-left px-4 py-3">Dokter</th><th class="text-left px-4 py-3">Poli</th><th class="text-left px-4 py-3">Status</th></tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php $__currentLoopData = $visits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $visit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="px-4 py-3"><?php echo e($visit->appointment_date->translatedFormat('d M Y')); ?></td>
                        <td class="px-4 py-3"><?php echo e($visit->patient->full_name); ?></td>
                        <td class="px-4 py-3"><?php echo e($visit->doctor->name); ?></td>
                        <td class="px-4 py-3"><?php echo e($visit->polyclinic->name); ?></td>
                        <td class="px-4 py-3"><?php echo e(ucfirst(str_replace('_',' ',$visit->status))); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <div class="mt-4"><?php echo e($visits->links()); ?></div>
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
<?php /**PATH C:\xampp5\htdocs\Project_SIMRS\mediscare\resources\views/reports/visits.blade.php ENDPATH**/ ?>
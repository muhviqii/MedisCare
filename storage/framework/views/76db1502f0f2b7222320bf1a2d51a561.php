<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Penggunaan Bed']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Penggunaan Bed']); ?>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
        <?php $__currentLoopData = $occupancyByClass; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-white rounded-2xl shadow-sm p-4 text-center">
                <p class="text-xl font-bold text-slate-800"><?php echo e($count); ?></p>
                <p class="text-xs text-slate-500"><?php echo e(strtoupper(str_replace('_',' ',$class))); ?></p>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                <tr><th class="text-left px-4 py-3">Pasien</th><th class="text-left px-4 py-3">Kamar/Bed</th><th class="text-left px-4 py-3">Masuk</th><th class="text-left px-4 py-3">Keluar</th></tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php $__currentLoopData = $admissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="px-4 py-3"><?php echo e($admission->patient->full_name); ?></td>
                        <td class="px-4 py-3"><?php echo e($admission->bed->room->room_number); ?>/<?php echo e($admission->bed->bed_number); ?></td>
                        <td class="px-4 py-3"><?php echo e($admission->admission_date->translatedFormat('d M Y')); ?></td>
                        <td class="px-4 py-3"><?php echo e($admission->discharge_date?->translatedFormat('d M Y') ?? '-'); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <div class="mt-4"><?php echo e($admissions->links()); ?></div>
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
<?php /**PATH C:\xampp5\htdocs\Project_SIMRS\mediscare\resources\views/reports/bed-usage.blade.php ENDPATH**/ ?>
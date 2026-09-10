<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Daftar Resep']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Daftar Resep']); ?>
    <form method="GET" class="mb-4">
        <select name="status" onchange="this.form.submit()" class="rounded-xl border-slate-300 text-sm py-2.5 px-4">
            <option value="">Semua Status</option>
            <option value="pending" <?php if(request('status') === 'pending'): echo 'selected'; endif; ?>>Menunggu</option>
            <option value="dispensed" <?php if(request('status') === 'dispensed'): echo 'selected'; endif; ?>>Sudah Diserahkan</option>
        </select>
    </form>

    <div class="space-y-2">
        <?php $__empty_1 = true; $__currentLoopData = $prescriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prescription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white rounded-2xl shadow-sm p-4">
                <div class="flex items-center justify-between mb-2">
                    <div>
                        <p class="font-medium text-slate-800"><?php echo e($prescription->patient->full_name); ?></p>
                        <p class="text-xs text-slate-500"><?php echo e($prescription->prescription_code); ?> &middot; <?php echo e($prescription->doctor->name); ?></p>
                    </div>
                    <span class="text-xs px-2 py-0.5 rounded-full <?php echo e($prescription->status === 'dispensed' ? 'bg-teal-50 text-teal-700' : 'bg-amber-50 text-amber-700'); ?>">
                        <?php echo e($prescription->status === 'dispensed' ? 'Sudah Diserahkan' : 'Menunggu'); ?>

                    </span>
                </div>
                <ul class="text-xs text-slate-500 list-disc list-inside mb-2">
                    <?php $__currentLoopData = $prescription->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($item->medication->name); ?> — <?php echo e($item->dosage); ?>, <?php echo e($item->frequency); ?> (<?php echo e($item->quantity); ?> <?php echo e($item->medication->unit); ?>)</li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <?php if($prescription->status === 'pending'): ?>
                    <form method="POST" action="<?php echo e(route('prescriptions.dispense', $prescription)); ?>">
                        <?php echo csrf_field(); ?>
                        <button class="px-3 py-1.5 bg-teal-600 text-white rounded-lg text-xs">Serahkan ke Pasien</button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-sm text-slate-400 text-center py-8">Belum ada resep.</p>
        <?php endif; ?>
    </div>
    <div class="mt-4"><?php echo e($prescriptions->links()); ?></div>
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
<?php /**PATH C:\xampp5\htdocs\Project_SIMRS\mediscare\resources\views/pharmacy/prescriptions/index.blade.php ENDPATH**/ ?>
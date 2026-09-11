<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Invoice']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Invoice']); ?>
    <form method="GET" class="mb-4">
        <select name="status" onchange="this.form.submit()" class="rounded-xl border-slate-300 text-sm py-2.5 px-4">
            <option value="">Semua Status</option>
            <?php $__currentLoopData = ['pending' => 'Pending', 'unpaid' => 'Belum Dibayar', 'partial' => 'Dibayar Sebagian', 'paid' => 'Lunas', 'cancelled' => 'Dibatalkan']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($value); ?>" <?php if(request('status') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </form>

    <div class="space-y-2">
        <?php $__empty_1 = true; $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <a href="<?php echo e(route('invoices.show', $invoice)); ?>" class="block bg-white rounded-2xl shadow-sm p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-medium text-slate-800"><?php echo e($invoice->patient->full_name); ?></p>
                        <p class="text-xs text-slate-500"><?php echo e($invoice->invoice_number); ?> &middot; <?php echo e(ucfirst($invoice->service_type)); ?></p>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold text-slate-800">Rp<?php echo e(number_format($invoice->grand_total, 0, ',', '.')); ?></p>
                        <span class="text-xs px-2 py-0.5 rounded-full
                            <?php echo e(match($invoice->status) { 'paid' => 'bg-teal-50 text-teal-700', 'partial' => 'bg-amber-50 text-amber-700', 'unpaid' => 'bg-red-50 text-red-700', default => 'bg-slate-100 text-slate-500' }); ?>">
                            <?php echo e(ucfirst($invoice->status)); ?>

                        </span>
                    </div>
                </div>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-sm text-slate-400 text-center py-8">Belum ada invoice.</p>
        <?php endif; ?>
    </div>
    <div class="mt-4"><?php echo e($invoices->links()); ?></div>
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
<?php /**PATH C:\xampp5\htdocs\Project_SIMRS\mediscare\resources\views/billing/invoices/index.blade.php ENDPATH**/ ?>
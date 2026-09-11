<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Laporan Pendapatan']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Laporan Pendapatan']); ?>
    <div class="flex items-center justify-between mb-4 flex-wrap gap-2">
        <form method="GET" class="flex gap-2 flex-wrap">
            <input type="date" name="from" value="<?php echo e(request('from')); ?>" class="rounded-xl border-slate-300 text-sm py-2 px-3">
            <input type="date" name="to" value="<?php echo e(request('to')); ?>" class="rounded-xl border-slate-300 text-sm py-2 px-3">
            <select name="status" class="rounded-xl border-slate-300 text-sm py-2 px-3">
                <option value="">Semua Status</option>
                <?php $__currentLoopData = ['unpaid' => 'Belum Dibayar', 'partial' => 'Sebagian', 'paid' => 'Lunas']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($value); ?>" <?php if(request('status') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <button class="px-4 py-2 bg-slate-800 text-white rounded-xl text-sm">Filter</button>
        </form>
        <div class="flex gap-2">
            <a href="<?php echo e(route('reports.export.invoices', request()->query())); ?>" class="px-4 py-2 bg-teal-600 text-white rounded-xl text-sm">⬇ Excel</a>
            <a href="<?php echo e(route('reports.export.revenue-pdf', request()->query())); ?>" class="px-4 py-2 bg-slate-800 text-white rounded-xl text-sm">⬇ PDF</a>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm p-4 mb-4">
        <p class="text-xs text-slate-500">Total Pendapatan (sesuai filter)</p>
        <p class="text-2xl font-semibold text-teal-700">Rp<?php echo e(number_format($totalRevenue, 0, ',', '.')); ?></p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                <tr><th class="text-left px-4 py-3">No. Invoice</th><th class="text-left px-4 py-3">Pasien</th><th class="text-right px-4 py-3">Total</th><th class="text-right px-4 py-3">Dibayar</th><th class="text-left px-4 py-3">Status</th></tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="px-4 py-3"><?php echo e($invoice->invoice_number); ?></td>
                        <td class="px-4 py-3"><?php echo e($invoice->patient->full_name); ?></td>
                        <td class="px-4 py-3 text-right">Rp<?php echo e(number_format($invoice->grand_total, 0, ',', '.')); ?></td>
                        <td class="px-4 py-3 text-right">Rp<?php echo e(number_format($invoice->paid_amount, 0, ',', '.')); ?></td>
                        <td class="px-4 py-3"><?php echo e(ucfirst($invoice->status)); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
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
<?php /**PATH C:\xampp5\htdocs\Project_SIMRS\mediscare\resources\views/reports/revenue.blade.php ENDPATH**/ ?>
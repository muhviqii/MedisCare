<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Laporan']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Laporan']); ?>
    <div class="grid md:grid-cols-2 gap-4">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('viewDetailed', \App\Models\Patient::class)): ?>
        <a href="<?php echo e(route('reports.patients')); ?>" class="bg-white rounded-2xl shadow-sm p-5">
            <h3 class="font-semibold text-slate-800">Laporan Pasien</h3>
            <p class="text-xs text-slate-500 mt-1">Data pasien dengan filter tanggal & status</p>
        </a>
        <?php endif; ?>
        <a href="<?php echo e(route('reports.visits')); ?>" class="bg-white rounded-2xl shadow-sm p-5">
            <h3 class="font-semibold text-slate-800">Laporan Kunjungan</h3>
            <p class="text-xs text-slate-500 mt-1">Kunjungan rawat jalan per dokter, poli, status</p>
        </a>
        <a href="<?php echo e(route('reports.revenue')); ?>" class="bg-white rounded-2xl shadow-sm p-5">
            <h3 class="font-semibold text-slate-800">Laporan Pendapatan</h3>
            <p class="text-xs text-slate-500 mt-1">Invoice & pembayaran per periode</p>
        </a>
        <a href="<?php echo e(route('reports.bed-usage')); ?>" class="bg-white rounded-2xl shadow-sm p-5">
            <h3 class="font-semibold text-slate-800">Penggunaan Bed</h3>
            <p class="text-xs text-slate-500 mt-1">Okupansi kamar per kelas</p>
        </a>
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
<?php /**PATH C:\xampp5\htdocs\Project_SIMRS\mediscare\resources\views/reports/index.blade.php ENDPATH**/ ?>
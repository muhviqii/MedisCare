<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Pengaturan']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Pengaturan']); ?>
    <div class="max-w-lg mx-auto bg-white rounded-2xl shadow-sm p-5">
        <h2 class="font-semibold text-slate-800 mb-4">Pengaturan Sistem</h2>
        <p class="text-xs text-slate-500 mb-4">
            Nilai di bawah ini bersumber dari file <code>.env</code> / konfigurasi server dan
            bersifat read-only di sini — sesuai prinsip keamanan (Bagian 28), kredensial dan
            konfigurasi sensitif tidak diubah lewat antarmuka web.
        </p>
        <dl class="divide-y divide-slate-100 text-sm">
            <?php $__currentLoopData = $settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex justify-between py-2">
                    <dt class="text-slate-500"><?php echo e(ucwords(str_replace('_', ' ', $key))); ?></dt>
                    <dd class="font-medium text-slate-800">
                        <?php if(is_bool($value)): ?>
                            <?php echo e($value ? 'Aktif' : 'Nonaktif'); ?>

                        <?php else: ?>
                            <?php echo e($value); ?>

                        <?php endif; ?>
                    </dd>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </dl>
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
<?php /**PATH C:\xampp5\htdocs\Project_SIMRS\mediscare\resources\views/settings/index.blade.php ENDPATH**/ ?>
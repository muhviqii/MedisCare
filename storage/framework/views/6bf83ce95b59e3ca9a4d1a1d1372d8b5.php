<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Poliklinik']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Poliklinik']); ?>
    <div class="flex justify-end mb-4">
        <?php if(auth()->user()->hasRole('super_admin', 'admin_rs')): ?>
            <a href="<?php echo e(route('polyclinics.create')); ?>" class="px-4 py-2.5 bg-teal-600 text-white rounded-xl text-sm font-medium">+ Tambah Poli</a>
        <?php endif; ?>
    </div>

    <div class="grid md:grid-cols-2 gap-3">
        <?php $__currentLoopData = $polyclinics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $polyclinic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-white rounded-2xl shadow-sm p-4 flex items-center justify-between">
                <div>
                    <p class="font-medium text-slate-800"><?php echo e($polyclinic->name); ?></p>
                    <p class="text-xs text-slate-500"><?php echo e($polyclinic->code); ?> &middot; <?php echo e($polyclinic->specialty?->name); ?></p>
                </div>
                <?php if(auth()->user()->hasRole('super_admin', 'admin_rs')): ?>
                    <form method="POST" action="<?php echo e(route('polyclinics.toggle', $polyclinic)); ?>">
                        <?php echo csrf_field(); ?>
                        <button class="text-xs px-2 py-1 rounded-full <?php echo e($polyclinic->is_active ? 'bg-teal-50 text-teal-700' : 'bg-slate-100 text-slate-500'); ?>">
                            <?php echo e($polyclinic->is_active ? 'Aktif' : 'Nonaktif'); ?>

                        </button>
                    </form>
                <?php endif; ?>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <div class="mt-4"><?php echo e($polyclinics->links()); ?></div>
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
<?php /**PATH C:\xampp5\htdocs\Project_SIMRS\mediscare\resources\views/polyclinics/index.blade.php ENDPATH**/ ?>
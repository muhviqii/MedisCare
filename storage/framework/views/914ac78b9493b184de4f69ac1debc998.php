<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Notifikasi']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Notifikasi']); ?>
    <div class="flex justify-end mb-4">
        <form method="POST" action="<?php echo e(route('notifications.read-all')); ?>">
            <?php echo csrf_field(); ?>
            <button class="text-sm text-teal-700">Tandai semua sudah dibaca</button>
        </form>
    </div>

    <div class="space-y-2">
        <?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white rounded-2xl shadow-sm p-4 <?php echo e($notification->read_at ? 'opacity-60' : ''); ?>">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-medium text-slate-800 text-sm"><?php echo e($notification->data['title'] ?? 'Notifikasi'); ?></p>
                        <p class="text-xs text-slate-500 mt-1"><?php echo e($notification->data['message'] ?? ''); ?></p>
                        <p class="text-xs text-slate-400 mt-1"><?php echo e($notification->created_at->diffForHumans()); ?></p>
                    </div>
                    <?php if (! ($notification->read_at)): ?>
                        <form method="POST" action="<?php echo e(route('notifications.read', $notification->id)); ?>">
                            <?php echo csrf_field(); ?>
                            <button class="text-xs text-teal-700">Tandai dibaca</button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-sm text-slate-400 text-center py-8">Tidak ada notifikasi.</p>
        <?php endif; ?>
    </div>
    <div class="mt-4"><?php echo e($notifications->links()); ?></div>
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
<?php /**PATH C:\xampp5\htdocs\Project_SIMRS\mediscare\resources\views/notifications/index.blade.php ENDPATH**/ ?>
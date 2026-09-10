<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Audit Log']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Audit Log']); ?>
    <form method="GET" class="flex gap-2 flex-wrap mb-4">
        <input type="text" name="module" value="<?php echo e(request('module')); ?>" placeholder="Modul (mis. patients)" class="rounded-xl border-slate-300 text-sm py-2 px-3">
        <input type="date" name="from" value="<?php echo e(request('from')); ?>" class="rounded-xl border-slate-300 text-sm py-2 px-3">
        <input type="date" name="to" value="<?php echo e(request('to')); ?>" class="rounded-xl border-slate-300 text-sm py-2 px-3">
        <button class="px-4 py-2 bg-slate-800 text-white rounded-xl text-sm">Filter</button>
    </form>

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                <tr><th class="text-left px-4 py-3">Waktu</th><th class="text-left px-4 py-3">User</th><th class="text-left px-4 py-3">Role</th><th class="text-left px-4 py-3">Aksi</th><th class="text-left px-4 py-3">Modul</th><th class="text-left px-4 py-3">IP</th></tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="px-4 py-3 text-slate-500"><?php echo e($log->created_at->format('d/m/Y H:i')); ?></td>
                        <td class="px-4 py-3"><?php echo e($log->user->name ?? '-'); ?></td>
                        <td class="px-4 py-3 text-slate-500"><?php echo e($log->role_snapshot); ?></td>
                        <td class="px-4 py-3"><?php echo e($log->action); ?></td>
                        <td class="px-4 py-3 text-slate-500"><?php echo e($log->module); ?><?php echo e($log->record_id ? " #{$log->record_id}" : ''); ?></td>
                        <td class="px-4 py-3 text-slate-400 text-xs"><?php echo e($log->ip_address); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <div class="mt-4"><?php echo e($logs->links()); ?></div>
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
<?php /**PATH C:\xampp5\htdocs\Project_SIMRS\mediscare\resources\views/audit/index.blade.php ENDPATH**/ ?>
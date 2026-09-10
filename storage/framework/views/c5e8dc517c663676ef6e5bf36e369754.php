<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Manajemen Pengguna']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Manajemen Pengguna']); ?>
    <div class="flex items-center justify-between mb-4 flex-wrap gap-2">
        <form method="GET" class="flex gap-2">
            <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari nama..." class="rounded-xl border-slate-300 text-sm py-2.5 px-4">
            <select name="role_id" class="rounded-xl border-slate-300 text-sm py-2.5 px-4">
                <option value="">Semua Role</option>
                <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($role->id); ?>" <?php if(request('role_id') == $role->id): echo 'selected'; endif; ?>><?php echo e($role->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <button class="px-4 py-2.5 bg-slate-800 text-white rounded-xl text-sm">Filter</button>
        </form>
        <a href="<?php echo e(route('users.create')); ?>" class="px-4 py-2.5 bg-teal-600 text-white rounded-xl text-sm font-medium">+ Tambah Pengguna</a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                <tr><th class="text-left px-4 py-3">Nama</th><th class="text-left px-4 py-3">Email</th><th class="text-left px-4 py-3">Role</th><th class="text-left px-4 py-3">Status</th><th class="text-right px-4 py-3">Aksi</th></tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td class="px-4 py-3 font-medium text-slate-800"><?php echo e($user->name); ?></td>
                        <td class="px-4 py-3 text-slate-500"><?php echo e($user->email); ?></td>
                        <td class="px-4 py-3"><?php echo e($user->role?->name); ?></td>
                        <td class="px-4 py-3">
                            <span class="text-xs px-2 py-0.5 rounded-full <?php echo e($user->is_active ? 'bg-teal-50 text-teal-700' : 'bg-slate-100 text-slate-500'); ?>">
                                <?php echo e($user->is_active ? 'Aktif' : 'Nonaktif'); ?>

                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="<?php echo e(route('users.edit', $user)); ?>" class="text-teal-700">Edit</a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <div class="mt-4"><?php echo e($users->links()); ?></div>
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
<?php /**PATH C:\xampp5\htdocs\Project_SIMRS\mediscare\resources\views/users/index.blade.php ENDPATH**/ ?>
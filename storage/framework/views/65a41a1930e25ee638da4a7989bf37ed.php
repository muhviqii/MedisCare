<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Data Pasien']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Data Pasien']); ?>
    <div class="flex items-center justify-between mb-4">
        <form method="GET" class="flex-1 flex gap-2 max-w-md">
            <input type="text" name="search" value="<?php echo e(request('search')); ?>" placeholder="Cari nama, NIK, atau no. RM..."
                   class="flex-1 rounded-xl border-slate-300 text-sm py-2.5 px-4 focus:ring-teal-600 focus:border-teal-600">
            <button class="px-4 py-2.5 bg-slate-800 text-white rounded-xl text-sm">Cari</button>
        </form>
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create', \App\Models\Patient::class)): ?>
            <a href="<?php echo e(route('patients.create')); ?>" class="ml-3 px-4 py-2.5 bg-teal-600 text-white rounded-xl text-sm font-medium whitespace-nowrap">
                + Tambah Pasien
            </a>
        <?php endif; ?>
    </div>

    
    <div class="md:hidden space-y-3">
        <?php $__empty_1 = true; $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <a href="<?php echo e(route('patients.show', $patient)); ?>" class="block bg-white rounded-2xl shadow-sm p-4">
                <div class="flex items-center justify-between">
                    <p class="font-medium text-slate-800"><?php echo e($patient->full_name); ?></p>
                    <span class="text-xs px-2 py-0.5 rounded-full <?php echo e($patient->status === 'active' ? 'bg-teal-50 text-teal-700' : 'bg-slate-100 text-slate-500'); ?>">
                        <?php echo e($patient->status === 'active' ? 'Aktif' : 'Nonaktif'); ?>

                    </span>
                </div>
                <p class="text-xs text-slate-500 mt-1"><?php echo e($patient->medical_record_number); ?> &middot; NIK <?php echo e($patient->nik); ?></p>
                <p class="text-xs text-slate-400 mt-1"><?php echo e($patient->phone); ?></p>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-center text-sm text-slate-400 py-8">Belum ada data pasien.</p>
        <?php endif; ?>
    </div>

    <div class="hidden md:block bg-white rounded-2xl shadow-sm overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-slate-500 text-xs uppercase">
                <tr>
                    <th class="text-left px-4 py-3">No. RM</th>
                    <th class="text-left px-4 py-3">Nama</th>
                    <th class="text-left px-4 py-3">NIK</th>
                    <th class="text-left px-4 py-3">Telepon</th>
                    <th class="text-left px-4 py-3">Status</th>
                    <th class="text-right px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php $__empty_1 = true; $__currentLoopData = $patients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $patient): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-50">
                        <td class="px-4 py-3 text-slate-500"><?php echo e($patient->medical_record_number); ?></td>
                        <td class="px-4 py-3 font-medium text-slate-800"><?php echo e($patient->full_name); ?></td>
                        <td class="px-4 py-3 text-slate-500"><?php echo e($patient->nik); ?></td>
                        <td class="px-4 py-3 text-slate-500"><?php echo e($patient->phone); ?></td>
                        <td class="px-4 py-3">
                            <span class="text-xs px-2 py-0.5 rounded-full <?php echo e($patient->status === 'active' ? 'bg-teal-50 text-teal-700' : 'bg-slate-100 text-slate-500'); ?>">
                                <?php echo e($patient->status === 'active' ? 'Aktif' : 'Nonaktif'); ?>

                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="<?php echo e(route('patients.show', $patient)); ?>" class="text-teal-700 text-sm">Detail</a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr><td colspan="6" class="text-center text-slate-400 py-8">Belum ada data pasien.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-4"><?php echo e($patients->links()); ?></div>
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
<?php /**PATH C:\xampp5\htdocs\Project_SIMRS\mediscare\resources\views/patients/index.blade.php ENDPATH**/ ?>
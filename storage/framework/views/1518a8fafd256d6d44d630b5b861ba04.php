<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Tambah Poli']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Tambah Poli']); ?>
    <div class="max-w-lg mx-auto bg-white rounded-2xl shadow-sm p-5">
        <h2 class="font-semibold text-slate-800 mb-4">Tambah Poli Baru</h2>
        <form method="POST" action="<?php echo e(route('polyclinics.store')); ?>" class="space-y-4">
            <?php echo csrf_field(); ?>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Nama Poli <span class="text-red-500">*</span></label>
                <input type="text" name="name" required class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Kode <span class="text-red-500">*</span></label>
                <input type="text" name="code" required placeholder="POLI-XXX" class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Spesialisasi</label>
                <select name="specialty_id" class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                    <option value="">-- Pilih --</option>
                    <?php $__currentLoopData = $specialties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $specialty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($specialty->id); ?>"><?php echo e($specialty->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Lokasi</label>
                <input type="text" name="location" class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
            </div>
            <button type="submit" class="w-full bg-teal-600 text-white rounded-xl py-3 text-sm font-medium hover:bg-teal-700">Simpan</button>
        </form>
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
<?php /**PATH C:\xampp5\htdocs\Project_SIMRS\mediscare\resources\views/polyclinics/create.blade.php ENDPATH**/ ?>
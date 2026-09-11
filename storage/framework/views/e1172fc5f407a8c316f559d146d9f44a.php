<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => ['title' => 'Profil Saya']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Profil Saya']); ?>
    <div class="max-w-lg mx-auto space-y-6">
        <div class="bg-white rounded-2xl shadow-sm p-5">
            <h2 class="font-semibold text-slate-800 mb-4">Informasi Profil</h2>
            <form method="POST" action="<?php echo e(route('profile.update')); ?>" enctype="multipart/form-data" class="space-y-4">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" value="<?php echo e(old('name', $user->name)); ?>" required
                           class="w-full rounded-xl border-slate-300 focus:ring-teal-600 focus:border-teal-600 text-sm py-3 px-4">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                    <input type="email" value="<?php echo e($user->email); ?>" disabled
                           class="w-full rounded-xl border-slate-200 bg-slate-100 text-sm py-3 px-4 text-slate-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Nomor Telepon</label>
                    <input type="text" name="phone" value="<?php echo e(old('phone', $user->phone)); ?>"
                           class="w-full rounded-xl border-slate-300 focus:ring-teal-600 focus:border-teal-600 text-sm py-3 px-4">
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Foto Profil</label>
                    <input type="file" name="avatar" accept="image/*" class="w-full text-sm">
                </div>
                <button type="submit" class="w-full bg-teal-600 text-white rounded-xl py-3 text-sm font-medium hover:bg-teal-700">
                    Simpan Perubahan
                </button>
            </form>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-5">
            <h2 class="font-semibold text-slate-800 mb-4">Ubah Kata Sandi</h2>
            <form method="POST" action="<?php echo e(route('profile.password')); ?>" class="space-y-4">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Kata Sandi Saat Ini</label>
                    <input type="password" name="current_password" required
                           class="w-full rounded-xl border-slate-300 focus:ring-teal-600 focus:border-teal-600 text-sm py-3 px-4">
                    <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Kata Sandi Baru</label>
                    <input type="password" name="password" required
                           class="w-full rounded-xl border-slate-300 focus:ring-teal-600 focus:border-teal-600 text-sm py-3 px-4">
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Konfirmasi Kata Sandi Baru</label>
                    <input type="password" name="password_confirmation" required
                           class="w-full rounded-xl border-slate-300 focus:ring-teal-600 focus:border-teal-600 text-sm py-3 px-4">
                </div>
                <button type="submit" class="w-full bg-slate-800 text-white rounded-xl py-3 text-sm font-medium hover:bg-slate-900">
                    Ubah Kata Sandi
                </button>
            </form>
        </div>
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
<?php /**PATH C:\xampp5\htdocs\Project_SIMRS\mediscare\resources\views/users/profile.blade.php ENDPATH**/ ?>
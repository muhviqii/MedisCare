
<div class="grid md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">NIK <span class="text-red-500">*</span></label>
        <input type="text" name="nik" maxlength="16" value="<?php echo e(old('nik', $patient->nik ?? '')); ?>" required
               class="w-full rounded-xl border-slate-300 focus:ring-teal-600 focus:border-teal-600 text-sm py-3 px-4">
        <?php $__errorArgs = ['nik'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
        <input type="text" name="full_name" value="<?php echo e(old('full_name', $patient->full_name ?? '')); ?>" required
               class="w-full rounded-xl border-slate-300 focus:ring-teal-600 focus:border-teal-600 text-sm py-3 px-4">
        <?php $__errorArgs = ['full_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Nama Panggilan</label>
        <input type="text" name="nickname" value="<?php echo e(old('nickname', $patient->nickname ?? '')); ?>"
               class="w-full rounded-xl border-slate-300 focus:ring-teal-600 focus:border-teal-600 text-sm py-3 px-4">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
        <select name="gender" required class="w-full rounded-xl border-slate-300 focus:ring-teal-600 focus:border-teal-600 text-sm py-3 px-4">
            <option value="male" <?php if(old('gender', $patient->gender ?? '') === 'male'): echo 'selected'; endif; ?>>Laki-laki</option>
            <option value="female" <?php if(old('gender', $patient->gender ?? '') === 'female'): echo 'selected'; endif; ?>>Perempuan</option>
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Tempat Lahir</label>
        <input type="text" name="birth_place" value="<?php echo e(old('birth_place', $patient->birth_place ?? '')); ?>"
               class="w-full rounded-xl border-slate-300 focus:ring-teal-600 focus:border-teal-600 text-sm py-3 px-4">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Lahir <span class="text-red-500">*</span></label>
        <input type="date" name="birth_date" max="<?php echo e(now()->toDateString()); ?>"
               value="<?php echo e(old('birth_date', isset($patient) ? $patient->birth_date->toDateString() : '')); ?>" required
               class="w-full rounded-xl border-slate-300 focus:ring-teal-600 focus:border-teal-600 text-sm py-3 px-4">
        <?php $__errorArgs = ['birth_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="text-red-600 text-xs mt-1"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-slate-700 mb-1">Alamat</label>
        <textarea name="address" rows="2" class="w-full rounded-xl border-slate-300 focus:ring-teal-600 focus:border-teal-600 text-sm py-3 px-4"><?php echo e(old('address', $patient->address ?? '')); ?></textarea>
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Nomor Telepon</label>
        <input type="text" name="phone" value="<?php echo e(old('phone', $patient->phone ?? '')); ?>"
               class="w-full rounded-xl border-slate-300 focus:ring-teal-600 focus:border-teal-600 text-sm py-3 px-4">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
        <input type="email" name="email" value="<?php echo e(old('email', $patient->email ?? '')); ?>"
               class="w-full rounded-xl border-slate-300 focus:ring-teal-600 focus:border-teal-600 text-sm py-3 px-4">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Golongan Darah</label>
        <select name="blood_type" class="w-full rounded-xl border-slate-300 focus:ring-teal-600 focus:border-teal-600 text-sm py-3 px-4">
            <?php $__currentLoopData = ['unknown' => 'Tidak diketahui', 'A' => 'A', 'B' => 'B', 'AB' => 'AB', 'O' => 'O']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($value); ?>" <?php if(old('blood_type', $patient->blood_type ?? 'unknown') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Status Perkawinan</label>
        <select name="marital_status" class="w-full rounded-xl border-slate-300 focus:ring-teal-600 focus:border-teal-600 text-sm py-3 px-4">
            <option value="">-</option>
            <?php $__currentLoopData = ['single' => 'Belum Menikah', 'married' => 'Menikah', 'divorced' => 'Cerai', 'widowed' => 'Janda/Duda']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($value); ?>" <?php if(old('marital_status', $patient->marital_status ?? '') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-slate-700 mb-1">Alergi</label>
        <input type="text" name="allergies" value="<?php echo e(old('allergies', $patient->allergies ?? '')); ?>" placeholder="Contoh: Alergi penisilin"
               class="w-full rounded-xl border-slate-300 focus:ring-teal-600 focus:border-teal-600 text-sm py-3 px-4">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Kontak Darurat</label>
        <input type="text" name="emergency_contact_name" value="<?php echo e(old('emergency_contact_name', $patient->emergency_contact_name ?? '')); ?>"
               class="w-full rounded-xl border-slate-300 focus:ring-teal-600 focus:border-teal-600 text-sm py-3 px-4">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">No. Kontak Darurat</label>
        <input type="text" name="emergency_contact_phone" value="<?php echo e(old('emergency_contact_phone', $patient->emergency_contact_phone ?? '')); ?>"
               class="w-full rounded-xl border-slate-300 focus:ring-teal-600 focus:border-teal-600 text-sm py-3 px-4">
    </div>
    <?php if(isset($patient)): ?>
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
            <select name="status" class="w-full rounded-xl border-slate-300 focus:ring-teal-600 focus:border-teal-600 text-sm py-3 px-4">
                <option value="active" <?php if($patient->status === 'active'): echo 'selected'; endif; ?>>Aktif</option>
                <option value="inactive" <?php if($patient->status === 'inactive'): echo 'selected'; endif; ?>>Nonaktif</option>
            </select>
        </div>
    <?php endif; ?>
</div>
<?php /**PATH C:\xampp5\htdocs\Project_SIMRS\mediscare\resources\views/patients/_form.blade.php ENDPATH**/ ?>
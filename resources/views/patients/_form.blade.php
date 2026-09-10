{{-- Partial form dipakai oleh create.blade.php & edit.blade.php --}}
<div class="grid md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">NIK <span class="text-red-500">*</span></label>
        <input type="text" name="nik" maxlength="16" value="{{ old('nik', $patient->nik ?? '') }}" required
               class="w-full rounded-xl border-slate-300 focus:ring-teal-600 focus:border-teal-600 text-sm py-3 px-4">
        @error('nik') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
        <input type="text" name="full_name" value="{{ old('full_name', $patient->full_name ?? '') }}" required
               class="w-full rounded-xl border-slate-300 focus:ring-teal-600 focus:border-teal-600 text-sm py-3 px-4">
        @error('full_name') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Nama Panggilan</label>
        <input type="text" name="nickname" value="{{ old('nickname', $patient->nickname ?? '') }}"
               class="w-full rounded-xl border-slate-300 focus:ring-teal-600 focus:border-teal-600 text-sm py-3 px-4">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
        <select name="gender" required class="w-full rounded-xl border-slate-300 focus:ring-teal-600 focus:border-teal-600 text-sm py-3 px-4">
            <option value="male" @selected(old('gender', $patient->gender ?? '') === 'male')>Laki-laki</option>
            <option value="female" @selected(old('gender', $patient->gender ?? '') === 'female')>Perempuan</option>
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Tempat Lahir</label>
        <input type="text" name="birth_place" value="{{ old('birth_place', $patient->birth_place ?? '') }}"
               class="w-full rounded-xl border-slate-300 focus:ring-teal-600 focus:border-teal-600 text-sm py-3 px-4">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Lahir <span class="text-red-500">*</span></label>
        <input type="date" name="birth_date" max="{{ now()->toDateString() }}"
               value="{{ old('birth_date', isset($patient) ? $patient->birth_date->toDateString() : '') }}" required
               class="w-full rounded-xl border-slate-300 focus:ring-teal-600 focus:border-teal-600 text-sm py-3 px-4">
        @error('birth_date') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-slate-700 mb-1">Alamat</label>
        <textarea name="address" rows="2" class="w-full rounded-xl border-slate-300 focus:ring-teal-600 focus:border-teal-600 text-sm py-3 px-4">{{ old('address', $patient->address ?? '') }}</textarea>
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Nomor Telepon</label>
        <input type="text" name="phone" value="{{ old('phone', $patient->phone ?? '') }}"
               class="w-full rounded-xl border-slate-300 focus:ring-teal-600 focus:border-teal-600 text-sm py-3 px-4">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
        <input type="email" name="email" value="{{ old('email', $patient->email ?? '') }}"
               class="w-full rounded-xl border-slate-300 focus:ring-teal-600 focus:border-teal-600 text-sm py-3 px-4">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Golongan Darah</label>
        <select name="blood_type" class="w-full rounded-xl border-slate-300 focus:ring-teal-600 focus:border-teal-600 text-sm py-3 px-4">
            @foreach (['unknown' => 'Tidak diketahui', 'A' => 'A', 'B' => 'B', 'AB' => 'AB', 'O' => 'O'] as $value => $label)
                <option value="{{ $value }}" @selected(old('blood_type', $patient->blood_type ?? 'unknown') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Status Perkawinan</label>
        <select name="marital_status" class="w-full rounded-xl border-slate-300 focus:ring-teal-600 focus:border-teal-600 text-sm py-3 px-4">
            <option value="">-</option>
            @foreach (['single' => 'Belum Menikah', 'married' => 'Menikah', 'divorced' => 'Cerai', 'widowed' => 'Janda/Duda'] as $value => $label)
                <option value="{{ $value }}" @selected(old('marital_status', $patient->marital_status ?? '') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-slate-700 mb-1">Alergi</label>
        <input type="text" name="allergies" value="{{ old('allergies', $patient->allergies ?? '') }}" placeholder="Contoh: Alergi penisilin"
               class="w-full rounded-xl border-slate-300 focus:ring-teal-600 focus:border-teal-600 text-sm py-3 px-4">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Kontak Darurat</label>
        <input type="text" name="emergency_contact_name" value="{{ old('emergency_contact_name', $patient->emergency_contact_name ?? '') }}"
               class="w-full rounded-xl border-slate-300 focus:ring-teal-600 focus:border-teal-600 text-sm py-3 px-4">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">No. Kontak Darurat</label>
        <input type="text" name="emergency_contact_phone" value="{{ old('emergency_contact_phone', $patient->emergency_contact_phone ?? '') }}"
               class="w-full rounded-xl border-slate-300 focus:ring-teal-600 focus:border-teal-600 text-sm py-3 px-4">
    </div>
    @isset($patient)
        <div>
            <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
            <select name="status" class="w-full rounded-xl border-slate-300 focus:ring-teal-600 focus:border-teal-600 text-sm py-3 px-4">
                <option value="active" @selected($patient->status === 'active')>Aktif</option>
                <option value="inactive" @selected($patient->status === 'inactive')>Nonaktif</option>
            </select>
        </div>
    @endisset
</div>

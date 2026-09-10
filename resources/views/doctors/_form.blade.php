<div class="grid md:grid-cols-2 gap-4">
    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-slate-700 mb-1">Nama Lengkap (dengan gelar) <span class="text-red-500">*</span></label>
        <input type="text" name="name" value="{{ old('name', $doctor->name ?? '') }}" required
               class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
        @error('name') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">NIP</label>
        <input type="text" name="nip" value="{{ old('nip', $doctor->nip ?? '') }}"
               class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
        @error('nip') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Nomor STR</label>
        <input type="text" name="str_number" value="{{ old('str_number', $doctor->str_number ?? '') }}"
               class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Nomor SIP</label>
        <input type="text" name="sip_number" value="{{ old('sip_number', $doctor->sip_number ?? '') }}"
               class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Spesialisasi <span class="text-red-500">*</span></label>
        <select name="specialty_id" required class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
            <option value="">-- Pilih --</option>
            @foreach ($specialties as $specialty)
                <option value="{{ $specialty->id }}" @selected(old('specialty_id', $doctor->specialty_id ?? '') == $specialty->id)>{{ $specialty->name }}</option>
            @endforeach
        </select>
        @error('specialty_id') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Poli</label>
        <select name="polyclinic_id" class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
            <option value="">-- Pilih --</option>
            @foreach ($polyclinics as $polyclinic)
                <option value="{{ $polyclinic->id }}" @selected(old('polyclinic_id', $doctor->polyclinic_id ?? '') == $polyclinic->id)>{{ $polyclinic->name }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
        <input type="email" name="email" value="{{ old('email', $doctor->email ?? '') }}"
               class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
        @error('email') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Nomor Telepon</label>
        <input type="text" name="phone" value="{{ old('phone', $doctor->phone ?? '') }}"
               class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Foto</label>
        <input type="file" name="photo" accept="image/*" class="w-full text-sm">
    </div>
    <div>
        <label class="block text-sm font-medium text-slate-700 mb-1">Status <span class="text-red-500">*</span></label>
        <select name="status" required class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
            @foreach (['active' => 'Aktif', 'on_leave' => 'Cuti', 'inactive' => 'Nonaktif'] as $value => $label)
                <option value="{{ $value }}" @selected(old('status', $doctor->status ?? 'active') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
</div>

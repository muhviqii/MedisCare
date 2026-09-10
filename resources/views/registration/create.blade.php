<x-layouts.app title="Pendaftaran Pasien">
    <div class="max-w-xl mx-auto bg-white rounded-2xl shadow-sm p-5" x-data="{ patientMode: 'existing' }">
        <h2 class="font-semibold text-slate-800 mb-4">Pendaftaran Pasien</h2>

        <form method="POST" action="{{ route('registration.store') }}" class="space-y-4">
            @csrf

            {{-- Step 1: Pasien lama/baru --}}
            <div class="flex bg-slate-100 rounded-xl p-1 text-sm">
                <button type="button" @click="patientMode = 'existing'"
                        :class="patientMode === 'existing' ? 'bg-white shadow-sm' : ''"
                        class="flex-1 py-2 rounded-lg">Pasien Lama</button>
                <button type="button" @click="patientMode = 'new'"
                        :class="patientMode === 'new' ? 'bg-white shadow-sm' : ''"
                        class="flex-1 py-2 rounded-lg">Pasien Baru</button>
            </div>

            <div x-show="patientMode === 'existing'">
                <label class="block text-sm font-medium text-slate-700 mb-1">Cari Pasien (No. RM / NIK / Nama)</label>
                <input type="number" name="patient_id" placeholder="Masukkan ID Pasien (hasil pencarian dari modul Pasien)"
                       class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                <p class="text-xs text-slate-400 mt-1">Gunakan <a href="{{ route('patients.index') }}" class="text-teal-700">Daftar Pasien</a> untuk mencari No. RM terlebih dahulu.</p>
                @error('patient_id') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div x-show="patientMode === 'new'" class="space-y-3">
                <input type="text" name="new_patient[nik]" maxlength="16" placeholder="NIK (16 digit)"
                       class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                @error('new_patient.nik') <p class="text-red-600 text-xs -mt-2">{{ $message }}</p> @enderror
                <input type="text" name="new_patient[full_name]" placeholder="Nama Lengkap"
                       class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                <select name="new_patient[gender]" class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                    <option value="male">Laki-laki</option>
                    <option value="female">Perempuan</option>
                </select>
                <input type="date" name="new_patient[birth_date]" max="{{ now()->toDateString() }}"
                       class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                @error('new_patient.birth_date') <p class="text-red-600 text-xs -mt-2">{{ $message }}</p> @enderror
                <input type="text" name="new_patient[phone]" placeholder="Nomor Telepon"
                       class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
            </div>

            {{-- Step 2: Poli --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Poli <span class="text-red-500">*</span></label>
                <select name="polyclinic_id" id="polyclinic_id" required class="w-full rounded-xl border-slate-300 text-sm py-3 px-4"
                        onchange="loadDoctors(this.value)">
                    <option value="">-- Pilih Poli --</option>
                    @foreach ($polyclinics as $polyclinic)
                        <option value="{{ $polyclinic->id }}">{{ $polyclinic->name }}</option>
                    @endforeach
                </select>
                @error('polyclinic_id') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Step 3: Dokter (dimuat via fetch berdasar poli) --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Dokter <span class="text-red-500">*</span></label>
                <select name="doctor_id" id="doctor_id" required class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                    <option value="">-- Pilih Poli Terlebih Dahulu --</option>
                </select>
                @error('doctor_id') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Step 4: Tanggal --}}
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Tanggal Kunjungan <span class="text-red-500">*</span></label>
                <input type="date" name="appointment_date" min="{{ now()->toDateString() }}" value="{{ old('appointment_date', now()->toDateString()) }}" required
                       class="w-full rounded-xl border-slate-300 text-sm py-3 px-4">
                @error('appointment_date') <p class="text-red-600 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Catatan</label>
                <textarea name="notes" rows="2" class="w-full rounded-xl border-slate-300 text-sm py-3 px-4"></textarea>
            </div>

            <button type="submit" class="w-full bg-teal-600 text-white rounded-xl py-3 text-sm font-medium hover:bg-teal-700">
                Daftar &amp; Ambil Nomor Antrean
            </button>
        </form>
    </div>

    <script>
        async function loadDoctors(polyclinicId) {
            const select = document.getElementById('doctor_id');
            select.innerHTML = '<option value="">Memuat...</option>';
            if (!polyclinicId) {
                select.innerHTML = '<option value="">-- Pilih Poli Terlebih Dahulu --</option>';
                return;
            }
            const res = await fetch(`/registration/polyclinics/${polyclinicId}/doctors`);
            const doctors = await res.json();
            select.innerHTML = '<option value="">-- Pilih Dokter --</option>' +
                doctors.map(d => `<option value="${d.id}">${d.name}</option>`).join('');
        }
    </script>
</x-layouts.app>

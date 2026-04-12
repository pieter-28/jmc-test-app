<form method="POST" action="{{ isset($employee) ? route('employees.update', $employee) : route('employees.store') }}">
    @csrf
    @if (isset($employee))
        @method('PUT')
    @endif

    <div class="row">
        <!-- NIP -->
        <div class="col-md-6 mb-3">
            <label for="nip" class="form-label">NIP (Min: 8 karakter, hanya angka)</label>
            <input type="text" class="form-control @error('nip') is-invalid @enderror" id="nip" name="nip"
                value="{{ old('nip', $employee->nip ?? '') }}" placeholder="12345678" required>
            @error('nip')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <!-- Nama Pegawai -->
        <div class="col-md-6 mb-3">
            <label for="name" class="form-label">Nama Pegawai</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name"
                value="{{ old('name', $employee->name ?? '') }}" required>
            @error('name')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="row">
        <!-- Email -->
        <div class="col-md-6 mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                name="email" value="{{ old('email', $employee->email ?? '') }}" required>
            @error('email')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <!-- Nomor Telepon -->
        <div class="col-md-6 mb-3">
            <label for="phone" class="form-label">Nomor Telepon (Format internasional: +628...)</label>
            <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone"
                name="phone" value="{{ old('phone', $employee->phone ?? '') }}" required>
            @error('phone')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="row">
        <!-- Tempat Lahir -->
        <div class="col-md-6 mb-3">
            <label for="place_of_birth" class="form-label">Tempat Lahir</label>
            <input type="text" class="form-control @error('place_of_birth') is-invalid @enderror" id="place_of_birth"
                name="place_of_birth" value="{{ old('place_of_birth', $employee->place_of_birth ?? '') }}" required>
            @error('place_of_birth')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <!-- Tanggal Lahir -->
        <div class="col-md-6 mb-3">
            <label for="date_of_birth" class="form-label">Tanggal Lahir (DD/MM/YYYY)</label>
            <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" id="date_of_birth"
                name="date_of_birth" value="{{ old('date_of_birth', $employee->date_of_birth ?? '') }}" required>
            @error('date_of_birth')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <!-- Location Section -->
    <h6 class="mb-3 mt-4">Alamat</h6>

    <div class="row">
        <!-- Provinsi -->
        <div class="col-md-4 mb-3">
            <label for="province_id" class="form-label">Provinsi</label>
            <select class="form-select @error('province_id') is-invalid @enderror" id="province_id" name="province_id"
                required>
                <option value="">Pilih Provinsi</option>
                @foreach ($provinces as $province)
                    <option value="{{ $province->id }}" @selected(old('province_id', $employee->province_id ?? '') == $province->id)>
                        {{ $province->name }}
                    </option>
                @endforeach
            </select>
            @error('province_id')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <!-- Kabupaten -->
        <div class="col-md-4 mb-3">
            <label for="district_id" class="form-label">Kabupaten</label>
            <select class="form-select @error('district_id') is-invalid @enderror" id="district_id" name="district_id"
                required>
                <option value="">Pilih Kabupaten</option>
            </select>
            @error('district_id')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <!-- Kecamatan -->
        <div class="col-md-4 mb-3">
            <label for="sub_district_id" class="form-label">Kecamatan</label>
            <select class="form-select @error('sub_district_id') is-invalid @enderror" id="sub_district_id"
                name="sub_district_id" required>
                <option value="">Pilih Kecamatan</option>
            </select>
            @error('sub_district_id')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="row">
        <!-- Alamat Lengkap -->
        <div class="col-md-12 mb-3">
            <label for="address" class="form-label">Alamat Lengkap</label>
            <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="3"
                required>{{ old('address', $employee->address ?? '') }}</textarea>
            @error('address')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <!-- Family & Employment Info -->
    <h6 class="mb-3 mt-4">Informasi Keluarga & Pekerjaan</h6>

    <div class="row">
        <!-- Status Kawin -->
        <div class="col-md-4 mb-3">
            <label class="form-label">Status Kawin</label>
            <div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="marital_status" id="marital_kawin"
                        value="kawin" @checked(old('marital_status', $employee->marital_status ?? '') === 'kawin')>
                    <label class="form-check-label" for="marital_kawin">Kawin</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="marital_status" id="marital_not"
                        value="tidak kawin" @checked(old('marital_status', $employee->marital_status ?? '') === 'tidak kawin')>
                    <label class="form-check-label" for="marital_not">Tidak Kawin</label>
                </div>
            </div>
        </div>

        <!-- Jumlah Anak -->
        <div class="col-md-4 mb-3">
            <label for="number_of_children" class="form-label">Jumlah Anak (Max: 99)</label>
            <input type="number" class="form-control @error('number_of_children') is-invalid @enderror"
                id="number_of_children" name="number_of_children" min="0" max="99"
                value="{{ old('number_of_children', $employee->number_of_children ?? 0) }}">
            @error('number_of_children')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <!-- Tanggal Masuk -->
        <div class="col-md-4 mb-3">
            <label for="start_date" class="form-label">Tanggal Masuk (DD/MM/YYYY)</label>
            <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="start_date"
                name="start_date" value="{{ old('start_date', $employee->start_date ?? '') }}" required>
            @error('start_date')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <div class="row">
        <!-- Jabatan -->
        <div class="col-md-4 mb-3">
            <label for="position_id" class="form-label">Jabatan</label>
            <select class="form-select @error('position_id') is-invalid @enderror" id="position_id"
                name="position_id" required>
                <option value="">Pilih Jabatan</option>
                @foreach ($positions as $position)
                    <option value="{{ $position->id }}" @selected(old('position_id', $employee->position_id ?? '') == $position->id)>
                        {{ $position->name }}
                    </option>
                @endforeach
            </select>
            @error('position_id')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <!-- Departemen -->
        <div class="col-md-4 mb-3">
            <label for="department_id" class="form-label">Departemen</label>
            <select class="form-select @error('department_id') is-invalid @enderror" id="department_id"
                name="department_id" required>
                <option value="">Pilih Departemen</option>
                @foreach ($departments as $department)
                    <option value="{{ $department->id }}" @selected(old('department_id', $employee->department_id ?? '') == $department->id)>
                        {{ $department->name }}
                    </option>
                @endforeach
            </select>
            @error('department_id')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <!-- Tipe Pegawai -->
        <div class="col-md-4 mb-3">
            <label for="employment_type" class="form-label">Tipe Pegawai</label>
            <select class="form-select @error('employment_type') is-invalid @enderror" id="employment_type"
                name="employment_type" required>
                <option value="">Pilih Tipe</option>
                <option value="tetap" @selected(old('employment_type', $employee->employment_type ?? '') === 'tetap')>Tetap</option>
                <option value="kontrak" @selected(old('employment_type', $employee->employment_type ?? '') === 'kontrak')>Kontrak</option>
                <option value="magang" @selected(old('employment_type', $employee->employment_type ?? '') === 'magang')>Magang</option>
            </select>
            @error('employment_type')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <!-- Education -->
    <h6 class="mb-3 mt-4">Pendidikan</h6>
    <div id="education-container">
        <!-- Education rows will be added here -->
    </div>
    <button type="button" class="btn btn-sm btn-secondary mb-3" id="add-education">
        <i class="fas fa-plus"></i> Tambah Pendidikan
    </button>

    <!-- Submit Buttons -->
    <div class="mt-4">
        <button type="submit" class="btn btn-primary">
            <i class="fas fa-save"></i> {{ isset($employee) ? 'Simpan Perubahan' : 'Simpan' }}
        </button>
        <a href="{{ route('employees.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</form>

<script>
    let educationCount = 0;

    document.getElementById('add-education').addEventListener('click', function() {
        const container = document.getElementById('education-container');
        const row = document.createElement('div');
        row.className = 'row education-row mb-3';
        row.innerHTML = `
            <div class="col-md-3">
                <input type="text" class="form-control" name="education[${educationCount}][level]" placeholder="Tingkat (SD, SMP, SMA, D3, S1)" required>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" name="education[${educationCount}][institution]" placeholder="Institusi" required>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" name="education[${educationCount}][field_of_study]" placeholder="Jurusan" required>
            </div>
            <div class="col-md-2">
                <input type="number" class="form-control" name="education[${educationCount}][graduation_year]" placeholder="Tahun" required>
            </div>
            <div class="col-md-1">
                <button type="button" class="btn btn-sm btn-danger remove-education">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;
        container.appendChild(row);
        educationCount++;

        // Add remove handler
        row.querySelector('.remove-education').addEventListener('click', function() {
            row.remove();
        });
    });

    // Location cascade
    document.getElementById('province_id').addEventListener('change', function() {
        const provinceId = this.value;
        const districtSelect = document.getElementById('district_id');
        const subDistrictSelect = document.getElementById('sub_district_id');

        districtSelect.innerHTML = '<option value="">Pilih Kabupaten</option>';
        subDistrictSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';

        if (provinceId) {
            fetch(`/api/districts?province_id=${provinceId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(district => {
                        const option = document.createElement('option');
                        option.value = district.id;
                        option.text = district.name;
                        districtSelect.appendChild(option);
                    });
                });
        }
    });

    document.getElementById('district_id').addEventListener('change', function() {
        const districtId = this.value;
        const subDistrictSelect = document.getElementById('sub_district_id');

        subDistrictSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';

        if (districtId) {
            fetch(`/api/sub-districts?district_id=${districtId}`)
                .then(response => response.json())
                .then(data => {
                    data.forEach(subDistrict => {
                        const option = document.createElement('option');
                        option.value = subDistrict.id;
                        option.text = subDistrict.name;
                        subDistrictSelect.appendChild(option);
                    });
                });
        }
    });

    // Trigger cascade on page load if editing
    @if (isset($employee) && $employee->province_id)
        document.getElementById('province_id').dispatchEvent(new Event('change'));
        setTimeout(() => {
            document.getElementById('district_id').dispatchEvent(new Event('change'));
        }, 500);
    @endif
</script>

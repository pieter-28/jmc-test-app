@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Detail Pegawai: {{ $employee->name }}</h5>
                    <div>
                        @if (Auth::user()->hasPermission('employee.edit'))
                            <a href="{{ route('employees.edit', $employee) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        @endif
                        <a href="{{ route('employees.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Personal Info -->
                    <h6 class="mb-3">Informasi Pribadi</h6>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>NIP:</strong> {{ $employee->nip ?? '' }}</p>
                            <p><strong>Nama:</strong> {{ $employee->name ?? '' }}</p>
                            <p><strong>Email:</strong> {{ $employee->email ?? '' }}</p>
                            <p><strong>Nomor Telepon:</strong> {{ $employee->phone ?? '' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Tempat Lahir:</strong> {{ $employee->place_of_birth }}</p>
                            <p><strong>Tanggal Lahir:</strong> {{ $employee->date_of_birth->format('d M Y') }}</p>
                            <p><strong>Status Kawin:</strong> {{ $employee->marital_status ?? '' }}</p>
                            <p><strong>Jumlah Anak:</strong> {{ $employee->number_of_children ?? '' }}</p>
                        </div>
                    </div>

                    <!-- Address Info -->
                    <h6 class="mb-3">Alamat</h6>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <p><strong>Provinsi:</strong> {{ $employee->province->name ?? '-' }}</p>
                            <p><strong>Kabupaten:</strong> {{ $employee->district->name ?? '-' }}</p>
                            <p><strong>Kecamatan:</strong> {{ $employee->subDistrict->name ?? '-' }}</p>
                            <p><strong>Alamat Lengkap:</strong></p>
                            <p>{{ $employee->address }}</p>
                        </div>
                    </div>

                    <!-- Employment Info -->
                    <h6 class="mb-3">Informasi Pekerjaan</h6>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Jabatan:</strong> {{ $employee->position->name ?? '' }}</p>
                            <p><strong>Departemen:</strong> {{ $employee->department->name ?? '' }}</p>
                            <p><strong>Tipe Pegawai:</strong> {{ ucfirst($employee->employment_type ?? '') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Tanggal Masuk:</strong> {{ $employee->start_date->format('d M Y') }}</p>
                            <p><strong>Masa Kerja:</strong> {{ $employee->getYearsOfService() }} tahun</p>
                            <p><strong>Status:</strong> <span
                                    class="badge @if ($employee->is_active) bg-success @else bg-danger @endif">
                                    {{ $employee->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                </span></p>
                        </div>
                    </div>

                    <!-- Education History -->
                    @if ($employee->education()->count() > 0)
                        <h6 class="mb-3">Riwayat Pendidikan</h6>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Tingkat</th>
                                    <th>Institusi</th>
                                    <th>Jurusan</th>
                                    <th>Tahun Lulus</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employee->education as $edu)
                                    <tr>
                                        <td>{{ $edu->level ?? '' }}</td>
                                        <td>{{ $edu->institution ?? '' }}</td>
                                        <td>{{ $edu->field_of_study ?? '' }}</td>
                                        <td>{{ $edu->graduation_year ?? '' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Tambah Data Pegawai Barus</h5>
                </div>

                <div class="card-body">
                    {{-- @include('employees._form', [
                        'employee' => null,
                        'positions' => $positions,
                        'departments' => $departments,
                        'provinces' => $provinces,
                    ]) --}}
                    <p class="text-muted">Form untuk menambahkan data pegawai baru akan segera hadir. Mohon bersabar.</p>
                </div>
            </div>
        </div>
    </div>
@endsection

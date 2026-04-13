@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Tambah Data Pegawai Barus</h5>
                </div>

                <form method="POST" action="{{ route('employees.store') }}">
                    @csrf
                    @method('POST')
                    <div class="card-body">
                        @include('employees._form', [
                            'employee' => null,
                            'positions' => $positions,
                            'departments' => $departments,
                            'provinces' => $provinces,
                        ])
                    </div>
                    <div class="card-footer">
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                            <a href="{{ route('employees.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

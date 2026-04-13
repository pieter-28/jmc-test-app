@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Ubah Data Pegawai: {{ $employee->name ?? '' }}</h5>
                </div>

                <form method="POST" action="{{ route('employees.update', $employee) }}">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        @include('employees._form', [
                            'employee' => $employee,
                            'positions' => $positions,
                            'departments' => $departments,
                            'provinces' => $provinces,
                            'mode' => 'edit',
                        ])
                    </div>
                    <div class="card-footer">
                        <div class="mt-4">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-save"></i> Update
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

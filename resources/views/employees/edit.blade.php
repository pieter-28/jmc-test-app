@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Ubah Data Pegawai: {{ $employee->name ?? '' }}</h5>
                </div>

                <div class="card-body">
                    @include('employees._form', ['employee' => $employee, 'mode' => 'edit'])
                </div>
            </div>
        </div>
    </div>
@endsection

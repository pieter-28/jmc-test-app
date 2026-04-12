@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Tambah Data Pegawai Baru</h5>
                </div>

                <div class="card-body">
                    @include('employees._form', ['employee' => null])
                </div>
            </div>
        </div>
    </div>
@endsection

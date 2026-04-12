@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h2>Selamat Datang {{ Auth::user()->name }} - {{ Auth::user()->role->name }}</h2>
                    <p class="text-muted">Anda login sebagai {{ Auth::user()->role->name }}. Gunakan menu di sebelah kiri
                        untuk mengelola data pegawai dan tunjangan transport.</p>
                </div>
            </div>
        </div>
    </div>
@endsection

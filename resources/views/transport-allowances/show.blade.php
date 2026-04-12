@extends('layouts.app')

@section('content')
    <h3>Detail Tunjangan Transport</h3>

    <div class="card">
        <div class="card-body">
            <p><strong>Pegawai:</strong> {{ $allowance->employee->name }}</p>
            <p><strong>Tahun Bulan:</strong> {{ $allowance->month }}/{{ $allowance->year }}</p>
            <p><strong>Jarak:</strong> {{ $allowance->distance }} km</p>
            <p><strong>Hari Kerja:</strong> {{ $allowance->working_days }} hari</p>
            <p><strong>Nominal Tunjangan:</strong> Rp. {{ number_format($allowance->amount, 0, ',', '.') }}</p>
        </div>
    </div>

    <a href="{{ route('transport-allowances.index') }}" class="btn btn-secondary mt-3">Kembali</a>
@endsection

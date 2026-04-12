@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h5>Ubah Tunjangan Transport</h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('transport-allowances.update', $allowance) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Pegawai</label>
                            <p>{{ $allowance->employee->name }}</p>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Periode</label>
                            <p>{{ $allowance->month }}/{{ $allowance->year }}</p>
                        </div>

                        <div class="mb-3">
                            <label for="distance" class="form-label">Jarak (km)</label>
                            <input type="number" step="0.01"
                                class="form-control @error('distance') is-invalid @enderror" name="distance"
                                value="{{ old('distance', $allowance->distance) }}" required>
                            @error('distance')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="working_days" class="form-label">Hari Kerja</label>
                            <input type="number" class="form-control @error('working_days') is-invalid @enderror"
                                name="working_days" value="{{ old('working_days', $allowance->working_days) }}" required>
                            @error('working_days')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <a href="{{ route('transport-allowances.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

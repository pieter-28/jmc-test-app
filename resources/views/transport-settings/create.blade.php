@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h5>Buat Pengaturan Tunjangan Transport Baru</h5>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('transport-settings.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="base_fare" class="form-label">Base Fare (Rp/km)</label>
                            <input type="number" step="0.01"
                                class="form-control @error('base_fare') is-invalid @enderror" name="base_fare" required>
                            @error('base_fare')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="min_distance" class="form-label">Jarak Minimum (km)</label>
                            <input type="number" step="0.01" class="form-control" name="min_distance" value="5"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="max_distance" class="form-label">Jarak Maksimum (km)</label>
                            <input type="number" step="0.01" class="form-control" name="max_distance" value="25"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="min_working_days" class="form-label">Hari Kerja Minimum</label>
                            <input type="number" class="form-control" name="min_working_days" value="19" required>
                        </div>

                        <div class="mb-3">
                            <label for="effective_date" class="form-label">Tanggal Efektif</label>
                            <input type="date" class="form-control @error('effective_date') is-invalid @enderror"
                                name="effective_date" required>
                            @error('effective_date')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('transport-settings.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

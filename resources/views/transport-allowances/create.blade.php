@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h5>{{ isset($allowance) ? 'Ubah Tunjangan Transport' : 'Tambah Tunjangan Transport' }}</h5>
                </div>

                <div class="card-body">
                    <form method="POST"
                        action="{{ isset($allowance) ? route('transport-allowances.update', $allowance) : route('transport-allowances.store') }}">
                        @csrf
                        @if (isset($allowance))
                            @method('PUT')
                        @else
                            <div class="mb-3">
                                <label for="employee_id" class="form-label">Pegawai</label>
                                <select class="form-select @error('employee_id') is-invalid @enderror" name="employee_id"
                                    required>
                                    <option value="">Pilih Pegawai</option>
                                    @foreach ($employees as $emp)
                                        <option value="{{ $emp->id }}" @selected(old('employee_id', $allowance->employee_id ?? '') == $emp->id)>
                                            {{ $emp->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="year" class="form-label">Tahun</label>
                                <select class="form-select" name="year" required>
                                    @foreach ($years as $year)
                                        <option value="{{ $year }}" @selected(old('year', $allowance->year ?? date('Y')) == $year)>{{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="month" class="form-label">Bulan</label>
                                <select class="form-select" name="month" required>
                                    @for ($m = 1; $m <= 12; $m++)
                                        <option value="{{ $m }}" @selected(old('month', $allowance->month ?? '') == $m)>
                                            {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="distance" class="form-label">Jarak (km)</label>
                            <input type="number" step="0.01"
                                class="form-control @error('distance') is-invalid @enderror" name="distance"
                                value="{{ old('distance', $allowance->distance ?? '') }}" required>
                            @error('distance')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="working_days" class="form-label">Hari Kerja</label>
                            <input type="number" class="form-control @error('working_days') is-invalid @enderror"
                                name="working_days" value="{{ old('working_days', $allowance->working_days ?? '') }}"
                                required>
                            @error('working_days')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="{{ route('transport-allowances.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

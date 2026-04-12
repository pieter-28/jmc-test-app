@extends('layouts.app')

@section('content')
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="d-flex justify-content-between">
                <h3>Setting Tunjangan Transport</h3>
                <a href="{{ route('transport-settings.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Pengaturan Baru
                </a>
            </div>
        </div>
    </div>

    @if ($activeSetting)
        <div class="alert alert-info mb-3">
            <strong>Pengaturan Aktif:</strong>
            Base Fare: Rp. {{ number_format($activeSetting->base_fare, 0, ',', '.') }}/km |
            Min Distance: {{ $activeSetting->min_distance }}km |
            Max Distance: {{ $activeSetting->max_distance }}km |
            Min Working Days: {{ $activeSetting->min_working_days }} hari
        </div>
    @endif

    <div class="card">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Base Fare</th>
                        <th>Min Distance</th>
                        <th>Max Distance</th>
                        <th>Min Working Days</th>
                        <th>Tanggal Efektif</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($settings as $setting)
                        <tr>
                            <td>Rp. {{ number_format($setting->base_fare, 0, ',', '.') }}/km</td>
                            <td>{{ $setting->min_distance }} km</td>
                            <td>{{ $setting->max_distance }} km</td>
                            <td>{{ $setting->min_working_days }} hari</td>
                            <td>{{ $setting->effective_date->format('d M Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Tidak ada data pengaturan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            {{ $settings->links() }}
        </div>
    </div>
@endsection

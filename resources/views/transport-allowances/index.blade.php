@extends('layouts.app')

@section('content')
    <h3>Tunjangan Transport</h3>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Pegawai</th>
                        <th>Tahun</th>
                        <th>Bulan</th>
                        <th>Jarak (km)</th>
                        <th>Hari Kerja</th>
                        <th>Nominal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($allowances as $allowance)
                        <tr>
                            <td>{{ $allowance->employee->name ?? '-' }}</td>
                            <td>{{ $allowance->year }}</td>
                            <td>{{ $allowance->month }}</td>
                            <td>{{ $allowance->distance }}</td>
                            <td>{{ $allowance->working_days }}</td>
                            <td>Rp. {{ number_format($allowance->amount, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('transport-allowances.show', $allowance) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            {{ $allowances->links() }}
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="row mb-4">
        <div class="col-md-12">
            <h3>Dashboard {{ Auth::user()->role->name }}</h3>
            <p class="text-muted">Selamat datang {{ Auth::user()->name }}</p>
        </div>
    </div>

    <!-- Widgets -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-left-primary">
                <div class="card-body">
                    <div class="text-primary" style="font-size: 2rem;">{{ $totalEmployees }}</div>
                    <div class="text-muted">Total Pegawai</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-success">
                <div class="card-body">
                    <div class="text-success" style="font-size: 2rem;">{{ $totalPermanentEmployees }}</div>
                    <div class="text-muted">Pegawai Tetap</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-warning">
                <div class="card-body">
                    <div class="text-warning" style="font-size: 2rem;">{{ $totalContractEmployees }}</div>
                    <div class="text-muted">Pegawai Kontrak</div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-left-info">
                <div class="card-body">
                    <div class="text-info" style="font-size: 2rem;">{{ $totalInternships }}</div>
                    <div class="text-muted">Peserta Magang</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Pegawai Kontrak vs Tetap vs Magang</h5>
                </div>
                <div class="card-body">
                    <canvas id="employmentTypeChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Pegawai Pria vs Wanita</h5>
                </div>
                <div class="card-body">
                    <canvas id="genderChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Contract Employees -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">5 Pegawai Kontrak Terbaru</h5>
                </div>
                <div class="card-body">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Tanggal Masuk</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($newestContractEmployees as $employee)
                                <tr>
                                    <td>{{ $employee->nip }}</td>
                                    <td>{{ $employee->name }}</td>
                                    <td>{{ $employee->position->name ?? '-' }}</td>
                                    <td>{{ $employee->start_date->format('d M Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Tidak ada data</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@3/dist/chart.min.js"></script>
    <script>
        // Employment Type Chart
        const employmentTypeCtx = document.getElementById('employmentTypeChart').getContext('2d');
        new Chart(employmentTypeCtx, {
            type: 'doughnut',
            data: {
                labels: ['Pegawai Tetap', 'Pegawai Kontrak', 'Peserta Magang'],
                datasets: [{
                    data: [{{ $totalPermanentEmployees }}, {{ $totalContractEmployees }},
                        {{ $totalInternships }}
                    ],
                    backgroundColor: [
                        '#28a745',
                        '#ffc107',
                        '#17a2b8',
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });

        // Gender Chart
        const genderCtx = document.getElementById('genderChart').getContext('2d');
        new Chart(genderCtx, {
            type: 'doughnut',
            data: {
                labels: ['Pria', 'Wanita'],
                datasets: [{
                    data: [45, 55],
                    backgroundColor: [
                        '#007bff',
                        '#e83e8c',
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });
    </script>

    <style>
        .border-left-primary {
            border-left: 4px solid #007bff;
        }

        .border-left-success {
            border-left: 4px solid #28a745;
        }

        .border-left-warning {
            border-left: 4px solid #ffc107;
        }

        .border-left-info {
            border-left: 4px solid #17a2b8;
        }

        .text-primary {
            color: #007bff;
        }

        .text-success {
            color: #28a745;
        }

        .text-warning {
            color: #ffc107;
        }

        .text-info {
            color: #17a2b8;
        }
    </style>
@endsection

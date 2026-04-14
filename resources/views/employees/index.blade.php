@extends('layouts.app')

@section('content')
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <h3>Data Pegawai</h3>
                @if (Auth::user()->hasPermission('employee.create'))
                <div class="d-flex gap-2">
                    <a href="{{ route('employees.export-excel') }}" class="btn btn-success">
                        <i class="fas fa-file-excel"></i> Export Excel
                    </a>
                    <a href="{{ route('employees.export-pdf') }}" class="btn btn-danger" target="_blank">
                        <i class="fas fa-file-pdf"></i> Export PDF
                    </a>
                    <a href="{{ route('employees.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Tambah Pegawai
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('employees.index') }}" class="form-inline">
                <div class="row w-100">
                    <div class="col-md-3">
                        <input type="text" class="form-control form-control-sm" name="search"
                            placeholder="Cari nama/NIP/jabatan" value="{{ request()->input('search') }}">
                    </div>

                    <div class="col-md-2">
                        <select name="sort_by" class="form-select form-select-sm">
                            <option value="nip" @selected(request()->input('sort_by') === 'nip')>Urutkan: NIP</option>
                            <option value="name" @selected(request()->input('sort_by') === 'name')>Urutkan: Nama</option>
                            <option value="start_date" @selected(request()->input('sort_by') === 'start_date')>Urutkan: Tanggal Masuk</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select name="sort_order" class="form-select form-select-sm">
                            <option value="asc" @selected(request()->input('sort_order') === 'asc')>Ascending</option>
                            <option value="desc" @selected(request()->input('sort_order') === 'desc')>Descending</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <button type="submit" class="btn btn-sm btn-info">
                            <i class="fas fa-search"></i> Cari
                        </button>
                        <a href="{{ route('employees.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-redo"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Employees Table -->
    <div class="card">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
                <thead of="table-light">
                    <tr>
                        <th style="width: 50px;">
                            <input type="checkbox" id="select-all" class="form-check-input">
                        </th>
                        <th>No. Urut</th>
                        <th>NIP</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Tanggal Masuk</th>
                        <th>Masa Kerja</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($employees as $key => $employee)
                        <tr>
                            <td>
                                <input type="checkbox" class="form-check-input employee-checkbox"
                                    value="{{ $employee->id }}">
                            </td>
                            <td>{{ ($employees->currentPage() - 1) * $employees->perPage() + $key + 1 }}</td>
                            <td>{{ $employee->nip }}</td>
                            <td>{{ $employee->name }}</td>
                            <td>{{ $employee->position->name ?? '-' }}</td>
                            <td>{{ $employee->start_date->format('d M Y') }}</td>
                            <td>{{ $employee->getYearsOfService() }} tahun</td>
                            <td>
                                <a href="{{ route('employees.show', $employee) }}" class="btn btn-sm btn-info"
                                    title="Detail">
                                    <i class="fas fa-eye"></i>
                                </a>
                                @if (Auth::user()->hasPermission('employee.edit'))
                                    <a href="{{ route('employees.edit', $employee) }}" class="btn btn-sm btn-warning"
                                        title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endif
                                @if (Auth::user()->hasPermission('employee.delete'))
                                    <form action="{{ route('employees.destroy', $employee) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus"
                                            onclick="return confirm('Apakah Anda yakin?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">Tidak ada data pegawai</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="card-footer">
            {{ $employees->links() }}
        </div>
    </div>

    <script>
        document.getElementById('select-all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.employee-checkbox');
            checkboxes.forEach(cb => cb.checked = this.checked);
        });
    </script>
@endsection

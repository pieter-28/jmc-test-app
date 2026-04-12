@extends('layouts.app')

@section('content')
    <h3>Detail Role: {{ $role->name }}</h3>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Informasi Role</h5>
                </div>
                <div class="card-body">
                    <p><strong>Nama:</strong> {{ $role->name }}</p>
                    <p><strong>Slug:</strong> <code>{{ $role->slug }}</code></p>
                    <p><strong>Deskripsi:</strong> {{ $role->description ?? '-' }}</p>
                    <p><strong>Jumlah User:</strong> <span class="badge bg-info">{{ $role->users()->count() }}</span></p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Permissions</h5>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @forelse($role->permissions as $permission)
                            <div class="list-group-item">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check text-success me-2"></i>
                                    <div>
                                        <strong>{{ $permission->name }}</strong>
                                        <small class="d-block text-muted">{{ $permission->slug }}</small>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted">Tidak ada permission</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a href="{{ route('roles.index') }}" class="btn btn-secondary mt-3">Kembali</a>
@endsection

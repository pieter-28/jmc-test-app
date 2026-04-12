@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Detail User: {{ $user->name }}</h5>
                    <div>
                        @if (Auth::user()->hasPermission('user.edit'))
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        @endif
                        <a href="{{ route('users.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <p><strong>Nama:</strong> {{ $user->name }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Username:</strong> {{ $user->username }}</p>
                    <p><strong>Nomor Telepon:</strong> {{ $user->phone }}</p>
                    <p><strong>Role:</strong> {{ $user->role->name ?? '-' }}</p>
                    <p><strong>Status:</strong> <span
                            class="badge @if ($user->is_active) bg-success @else bg-danger @endif">
                            {{ $user->is_active ? 'Aktif' : 'Tidak Aktif' }}
                        </span></p>
                    <p><strong>Last Login:</strong>
                        {{ $user->last_login_at ? $user->last_login_at->format('d M Y H:i') : 'Belum pernah login' }}</p>
                    <p><strong>Dibuat:</strong> {{ $user->created_at->format('d M Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection

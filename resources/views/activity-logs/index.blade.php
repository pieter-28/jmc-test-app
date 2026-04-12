@extends('layouts.app')

@section('content')
    <h3>Log Aktivitas</h3>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Waktu</th>
                        <th>User</th>
                        <th>Aksi</th>
                        <th>Modul</th>
                        <th>Deskripsi</th>
                        <th>IP Address</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td>{{ $log->created_at->format('d M Y H:i') }}</td>
                            <td>{{ $log->user->name ?? '-' }}</td>
                            <td>
                                <span
                                    class="badge 
                                @if ($log->action === 'login') bg-success
                                @elseif($log->action === 'logout')  bg-warning
                                @elseif($log->action === 'create') bg-info
                                @elseif($log->action === 'update') bg-primary
                                @elseif($log->action === 'delete') bg-danger
                                @else bg-secondary @endif">
                                    {{ $log->action }}
                                </span>
                            </td>
                            <td>{{ $log->module ?? '-' }}</td>
                            <td>{{ $log->description ?? '-' }}</td>
                            <td><small>{{ $log->ip_address }}</small></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            {{ $logs->links() }}
        </div>
    </div>
@endsection

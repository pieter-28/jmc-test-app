<!DOCTYPE html>
<html>

<head>
    <title>Data Pegawai</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h2 {
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>Daftar Data Pegawai</h2>
        <p>Dicetak pada: {{ date('d/m/Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>NIP</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Jabatan</th>
                <th>Departemen</th>
                <th>Tipe</th>
                <th>Tanggal Masuk</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
                <tr>
                    <td>{{ $employee->nip }}</td>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>{{ $employee->position->name ?? '-' }}</td>
                    <td>{{ $employee->department->name ?? '-' }}</td>
                    <td>{{ ucfirst($employee->employment_type) }}</td>
                    <td>{{ $employee->start_date->format('d/m/Y') }}</td>
                    <td>{{ $employee->is_active ? 'Aktif' : 'Tidak Aktif' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>

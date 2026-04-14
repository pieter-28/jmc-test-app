<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EmployeesExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Employee::with(['position', 'department', 'province', 'district', 'subDistrict'])->get();
    }

    public function headings(): array
    {
        return [
            'NIP',
            'Nama',
            'Email',
            'Telepon',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Alamat',
            'Provinsi',
            'Kabupaten/Kota',
            'Kecamatan',
            'Status Pernikahan',
            'Jumlah Anak',
            'Tanggal Masuk',
            'Tipe Pegawai',
            'Jabatan',
            'Departemen',
            'Status'
        ];
    }

    public function map($employee): array
    {
        return [
            $employee->nip,
            $employee->name,
            $employee->email,
            $employee->phone,
            $employee->place_of_birth,
            $employee->date_of_birth->format('d/m/Y'),
            $employee->address,
            $employee->province->name ?? '-',
            $employee->district->name ?? '-',
            $employee->subDistrict->name ?? '-',
            ucfirst($employee->marital_status),
            $employee->number_of_children,
            $employee->start_date->format('d/m/Y'),
            ucfirst($employee->employment_type),
            $employee->position->name ?? '-',
            $employee->department->name ?? '-',
            $employee->is_active ? 'Aktif' : 'Tidak Aktif'
        ];
    }
}

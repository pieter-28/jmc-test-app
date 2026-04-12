<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Position;
use App\Models\Department;
use App\Models\Province;
use App\Models\District;
use App\Models\SubDistrict;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed roles and permissions first
        $this->call([RolePermissionSeeder::class]);

        // Seed Positions
        $this->seedPositions();

        // Seed Departments
        $this->seedDepartments();

        // Seed Locations (Provinces, Districts, Sub-Districts)
        $this->seedLocations();

        // Seed dummy employees
        $this->call([EmployeeSeeder::class]);

        // Create Superadmin user
        User::firstOrCreate(
            ['username' => 'superadmin'],
            [
                'name' => 'Superadmin',
                'email' => 'superadmin@jmc.local',
                'phone' => '+6281234567890',
                'password' => bcrypt('Admin@123'),
                'role_id' => 1, // Superadmin role
                'is_active' => true,
            ],
        );

        // Create Manager HRD user
        User::firstOrCreate(
            ['username' => 'manager_hrd'],
            [
                'name' => 'Manager HRD',
                'email' => 'manager@jmc.local',
                'phone' => '+6281234567891',
                'password' => bcrypt('Manager@123'),
                'role_id' => 2, // Manager HRD role
                'is_active' => true,
            ],
        );

        // Create Admin HRD user
        User::firstOrCreate(
            ['username' => 'admin_hrd'],
            [
                'name' => 'Admin HRD',
                'email' => 'admin@jmc.local',
                'phone' => '+6281234567892',
                'password' => bcrypt('Admin@123'),
                'role_id' => 3, // Admin HRD role
                'is_active' => true,
            ],
        );
    }

    /**
     * Seed Positions
     */
    private function seedPositions(): void
    {
        Position::firstOrCreate(['name' => 'Direktur Utama'], ['description' => 'Direktur Utama Perusahaan']);
        Position::firstOrCreate(['name' => 'Manajer'], ['description' => 'Manajer Departemen']);
        Position::firstOrCreate(['name' => 'Supervisior'], ['description' => 'Supervisor Lapangan']);
        Position::firstOrCreate(['name' => 'Staf Senior'], ['description' => 'Staf Senior']);
        Position::firstOrCreate(['name' => 'Staf Junior'], ['description' => 'Staf Junior']);
        Position::firstOrCreate(['name' => 'Obyek Wisata'], ['description' => 'Operator Obyek Wisata']);
        Position::firstOrCreate(['name' => 'Tour Guide'], ['description' => 'Pemandu Wisata']);
        Position::firstOrCreate(['name' => 'Driver'], ['description' => 'Pengemudi']);
        Position::firstOrCreate(['name' => 'Security'], ['description' => 'Keamanan']);
        Position::firstOrCreate(['name' => 'Cleaning Service'], ['description' => 'Layanan Kebersihan']);
    }

    /**
     * Seed Departments
     */
    private function seedDepartments(): void
    {
        Department::firstOrCreate(['name' => 'Direksi'], ['description' => 'Departemen Direksi']);
        Department::firstOrCreate(['name' => 'HRD'], ['description' => 'Human Resources Development']);
        Department::firstOrCreate(['name' => 'Finance'], ['description' => 'Departemen Keuangan']);
        Department::firstOrCreate(['name' => 'Operations'], ['description' => 'Departemen Operasional']);
        Department::firstOrCreate(['name' => 'Marketing'], ['description' => 'Departemen Marketing']);
        Department::firstOrCreate(['name' => 'IT'], ['description' => 'Departemen Information Technology']);
    }

    /**
     * Seed Locations (Provinces, Districts, Sub-Districts)
     */
    private function seedLocations(): void
    {
        // Jakarta Province
        $jakarta = Province::firstOrCreate(['code' => 'DKI'], ['name' => 'DKI Jakarta']);

        $jakartaPusat = District::firstOrCreate(['code' => 'JP', 'province_id' => $jakarta->id], ['name' => 'Jakarta Pusat']);
        SubDistrict::firstOrCreate(['district_id' => $jakartaPusat->id, 'name' => 'Menteng']);
        SubDistrict::firstOrCreate(['district_id' => $jakartaPusat->id, 'name' => 'Cempaka Putih']);
        SubDistrict::firstOrCreate(['district_id' => $jakartaPusat->id, 'name' => 'Cemp Putih Timur']);

        $jakartaSelatan = District::firstOrCreate(['code' => 'JS', 'province_id' => $jakarta->id], ['name' => 'Jakarta Selatan']);
        SubDistrict::firstOrCreate(['district_id' => $jakartaSelatan->id, 'name' => 'Kebayoran Baru']);
        SubDistrict::firstOrCreate(['district_id' => $jakartaSelatan->id, 'name' => 'Kebayoran Lama']);
        SubDistrict::firstOrCreate(['district_id' => $jakartaSelatan->id, 'name' => 'Cilandak']);

        $jakartaUtara = District::firstOrCreate(['code' => 'JU', 'province_id' => $jakarta->id], ['name' => 'Jakarta Utara']);
        SubDistrict::firstOrCreate(['district_id' => $jakartaUtara->id, 'name' => 'Penjaringan']);
        SubDistrict::firstOrCreate(['district_id' => $jakartaUtara->id, 'name' => 'Ancol']);
        SubDistrict::firstOrCreate(['district_id' => $jakartaUtara->id, 'name' => 'Tanjung Priok']);

        $jakartaTmur = District::firstOrCreate(['code' => 'JT', 'province_id' => $jakarta->id], ['name' => 'Jakarta Timur']);
        SubDistrict::firstOrCreate(['district_id' => $jakartaTmur->id, 'name' => 'Makasar']);
        SubDistrict::firstOrCreate(['district_id' => $jakartaTmur->id, 'name' => 'Cakung']);
        SubDistrict::firstOrCreate(['district_id' => $jakartaTmur->id, 'name' => 'Bekasi Timur']);

        $jakartaBarat = District::firstOrCreate(['code' => 'JB', 'province_id' => $jakarta->id], ['name' => 'Jakarta Barat']);
        SubDistrict::firstOrCreate(['district_id' => $jakartaBarat->id, 'name' => 'Kebon Sirih']);
        SubDistrict::firstOrCreate(['district_id' => $jakartaBarat->id, 'name' => 'Tanah Abang']);
        SubDistrict::firstOrCreate(['district_id' => $jakartaBarat->id, 'name' => 'Tambora']);

        // Jawa Barat Province
        $jabarProv = Province::firstOrCreate(['code' => 'JW'], ['name' => 'Jawa Barat']);

        $bandung = District::firstOrCreate(['code' => 'BD', 'province_id' => $jabarProv->id], ['name' => 'Bandung']);
        SubDistrict::firstOrCreate(['district_id' => $bandung->id, 'name' => 'Cidadap']);
        SubDistrict::firstOrCreate(['district_id' => $bandung->id, 'name' => 'Coblong']);
        SubDistrict::firstOrCreate(['district_id' => $bandung->id, 'name' => 'Sumur Bandung']);

        $bogor = District::firstOrCreate(['code' => 'BG', 'province_id' => $jabarProv->id], ['name' => 'Kota Bogor']);
        SubDistrict::firstOrCreate(['district_id' => $bogor->id, 'name' => 'Bogor Utara']);
        SubDistrict::firstOrCreate(['district_id' => $bogor->id, 'name' => 'Bogor Tengah']);
        SubDistrict::firstOrCreate(['district_id' => $bogor->id, 'name' => 'Bogor Selatan']);

        $depok = District::firstOrCreate(['code' => 'DPK', 'province_id' => $jabarProv->id], ['name' => 'Depok']);
        SubDistrict::firstOrCreate(['district_id' => $depok->id, 'name' => 'Depok Baru']);
        SubDistrict::firstOrCreate(['district_id' => $depok->id, 'name' => 'Sukmajaya']);
        SubDistrict::firstOrCreate(['district_id' => $depok->id, 'name' => 'Beji']);

        // Jawa Tengah Province
        $jatengProv = Province::firstOrCreate(['code' => 'JT'], ['name' => 'Jawa Tengah']);

        $semarang = District::firstOrCreate(['code' => 'SMG', 'province_id' => $jatengProv->id], ['name' => 'Semarang']);
        SubDistrict::firstOrCreate(['district_id' => $semarang->id, 'name' => 'Semarang Pusat']);
        SubDistrict::firstOrCreate(['district_id' => $semarang->id, 'name' => 'Semarang Utara']);
        SubDistrict::firstOrCreate(['district_id' => $semarang->id, 'name' => 'Semarang Barat']);

        $yogyakarta = District::firstOrCreate(['code' => 'YK', 'province_id' => $jatengProv->id], ['name' => 'Yogyakarta']);
        SubDistrict::firstOrCreate(['district_id' => $yogyakarta->id, 'name' => 'Kraton']);
        SubDistrict::firstOrCreate(['district_id' => $yogyakarta->id, 'name' => 'Malioboro']);
        SubDistrict::firstOrCreate(['district_id' => $yogyakarta->id, 'name' => 'Gondomanan']);

        // Jawa Timur Province
        $jatimProv = Province::firstOrCreate(['code' => 'JIM'], ['name' => 'Jawa Timur']);

        $surabaya = District::firstOrCreate(['code' => 'SBY', 'province_id' => $jatimProv->id], ['name' => 'Surabaya']);
        SubDistrict::firstOrCreate(['district_id' => $surabaya->id, 'name' => 'Surabaya Pusat']);
        SubDistrict::firstOrCreate(['district_id' => $surabaya->id, 'name' => 'Surabaya Utara']);
        SubDistrict::firstOrCreate(['district_id' => $surabaya->id, 'name' => 'Surabaya Selatan']);

        $malang = District::firstOrCreate(['code' => 'MLG', 'province_id' => $jatimProv->id], ['name' => 'Malang']);
        SubDistrict::firstOrCreate(['district_id' => $malang->id, 'name' => 'Malang Pusat']);
        SubDistrict::firstOrCreate(['district_id' => $malang->id, 'name' => 'Malang Utara']);
        SubDistrict::firstOrCreate(['district_id' => $malang->id, 'name' => 'Malang Selatan']);

        // Sumatera Utara Province
        $sumatraUtara = Province::firstOrCreate(['code' => 'SU'], ['name' => 'Sumatera Utara']);

        $medan = District::firstOrCreate(['code' => 'MDN', 'province_id' => $sumatraUtara->id], ['name' => 'Medan']);
        SubDistrict::firstOrCreate(['district_id' => $medan->id, 'name' => 'Medan Pusat']);
        SubDistrict::firstOrCreate(['district_id' => $medan->id, 'name' => 'Medan Utara']);
        SubDistrict::firstOrCreate(['district_id' => $medan->id, 'name' => 'Medan Barat']);

        // Bali Province
        $bali = Province::firstOrCreate(['code' => 'BL'], ['name' => 'Bali']);

        $denpasar = District::firstOrCreate(['code' => 'DPS', 'province_id' => $bali->id], ['name' => 'Denpasar']);
        SubDistrict::firstOrCreate(['district_id' => $denpasar->id, 'name' => 'Denpasar Selatan']);
        SubDistrict::firstOrCreate(['district_id' => $denpasar->id, 'name' => 'Denpasar Utara']);
        SubDistrict::firstOrCreate(['district_id' => $denpasar->id, 'name' => 'Denpasar Barat']);

        $badung = District::firstOrCreate(['code' => 'BDG', 'province_id' => $bali->id], ['name' => 'Badung']);
        SubDistrict::firstOrCreate(['district_id' => $badung->id, 'name' => 'Kuta']);
        SubDistrict::firstOrCreate(['district_id' => $badung->id, 'name' => 'Sanur']);
        SubDistrict::firstOrCreate(['district_id' => $badung->id, 'name' => 'Ubud']);
    }
}

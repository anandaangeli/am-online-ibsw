<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. User Karyawan (Sesuai Demo HRIS IBSW)
        User::updateOrCreate(
            ['nik' => '20160163'],
            [
                'name' => 'TIOPAN INDRA WAHYUDI',
                'email' => 'tiopan.wahyudi@ibsmulti.com',
                'password' => Hash::make('password'),
                'role' => 'Supervisor',
                'division' => 'INFORMATION TECHNOLOGY & SAP DIVISION',
                'position' => 'Application Development Supervisor',
                'gender' => 'Male',
                'avatar' => 'https://hris.ibsmulti.com/assets/images/avatar_man.png',
            ]
        );

        // 2. User Admin
        User::updateOrCreate(
            ['nik' => 'admin'],
            [
                'name' => 'Administrator IBSW',
                'email' => 'admin@ibsmulti.com',
                'password' => Hash::make('admin123'),
                'role' => 'Super Admin',
                'division' => 'IT INFRASTRUCTURE & SECURITY',
                'position' => 'System Administrator',
                'gender' => 'Male',
                'avatar' => 'https://hris.ibsmulti.com/assets/images/avatar_man.png',
            ]
        );

        // 3. User Demo Tambahan
        User::updateOrCreate(
            ['nik' => 'demo'],
            [
                'name' => 'Demo User HRIS',
                'email' => 'demo@ibsmulti.com',
                'password' => Hash::make('123456'),
                'role' => 'Staff',
                'division' => 'HUMAN CAPITAL SERVICES',
                'position' => 'HR Staff',
                'gender' => 'Female',
                'avatar' => 'https://hris.ibsmulti.com/assets/images/avatar_man.png',
            ]
        );

        // 4. Akun Cepat Sesuai Template Login Perusahaan (Login.jsx)
        $templateAccounts = [
            [
                'nik' => '20230001',
                'role' => 'Staff',
                'name' => 'Fajar Nugraha',
                'email' => 'test.requester@ibs.test',
                'position' => 'Requester SCM',
                'division' => 'SUPPLY CHAIN MANAGEMENT',
            ],
            [
                'nik' => '20230002',
                'role' => 'Supervisor',
                'name' => 'Dwi Handayani, S.T.',
                'email' => 'test.asisten@ibs.test',
                'position' => 'Asisten Kadiv (L1)',
                'division' => 'SUPPLY CHAIN MANAGEMENT',
            ],
            [
                'nik' => '20230003',
                'role' => 'Supervisor',
                'name' => 'Hendro Prasetyo, S.T.',
                'email' => 'test.kadiv@ibs.test',
                'position' => 'Kadiv SCM (L2)',
                'division' => 'SUPPLY CHAIN MANAGEMENT',
            ],
            [
                'nik' => '20230004',
                'role' => 'Supervisor',
                'name' => 'Bambang Sudarsono, S.E.',
                'email' => 'test.accounting@ibs.test',
                'position' => 'Accounting (L3)',
                'division' => 'FINANCE & ACCOUNTING',
            ],
            [
                'nik' => '20230005',
                'role' => 'Supervisor',
                'name' => 'Citra Anggraini, S.E.',
                'email' => 'test.tax@ibs.test',
                'position' => 'Tax (L4)',
                'division' => 'FINANCE & TAXATION',
            ],
            [
                'nik' => '20230006',
                'role' => 'Supervisor',
                'name' => 'Rizky Pratama, M.Kom.',
                'email' => 'test.sap@ibs.test',
                'position' => 'SAP Team (L5)',
                'division' => 'INFORMATION TECHNOLOGY & SAP',
            ],
            [
                'nik' => '20230007',
                'role' => 'Staff',
                'name' => 'Dimas Anggara',
                'email' => 'test.requester.br@ibs.test',
                'position' => 'Requester (BR)',
                'division' => 'PROJECT MANAGEMENT',
            ],
            [
                'nik' => '20230008',
                'role' => 'Super Admin',
                'name' => 'Admin Testing IBS',
                'email' => 'admin@ibs.test',
                'position' => 'System Administrator',
                'division' => 'IT DIVISION',
            ],
        ];

        foreach ($templateAccounts as $acc) {
            User::updateOrCreate(
                ['email' => $acc['email']],
                [
                    'nik' => $acc['nik'],
                    'name' => $acc['name'],
                    'password' => Hash::make('password'),
                    'role' => $acc['role'],
                    'position' => $acc['position'],
                    'division' => $acc['division'],
                    'gender' => 'Male',
                    'avatar' => 'https://hris.ibsmulti.com/assets/images/avatar_man.png',
                ]
            );
        }
    }
}

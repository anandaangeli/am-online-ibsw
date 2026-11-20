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
        // 1. User Requester Utama (Karyawan Pemohon Demo)
        User::updateOrCreate(
            ['nik' => '20160163'],
            [
                'name' => 'TIOPAN INDRA WAHYUDI',
                'email' => 'tiopan.wahyudi@ibsmulti.com',
                'password' => Hash::make('password'),
                'role' => 'Requester',
                'division' => 'INFORMATION TECHNOLOGY & SAP DIVISION',
                'position' => 'Application Development Staff',
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
                'role' => 'Administrator',
                'division' => 'IT INFRASTRUCTURE & SECURITY',
                'position' => 'System Administrator (Approver)',
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
                'role' => 'Requester',
                'division' => 'HUMAN CAPITAL SERVICES',
                'position' => 'HR Staff (Requester)',
                'gender' => 'Female',
                'avatar' => 'https://hris.ibsmulti.com/assets/images/avatar_man.png',
            ]
        );

        // 4. Akun Hierarki IBS: Requester vs Approver L1, L2, L3, L4
        $templateAccounts = [
            [
                'nik' => '20230001',
                'role' => 'Requester',
                'name' => 'Fajar Nugraha',
                'email' => 'test.requester@ibs.test',
                'position' => 'Requester SCM',
                'division' => 'SUPPLY CHAIN MANAGEMENT',
            ],
            [
                'nik' => '20230002',
                'role' => 'Asisten Kadiv (L1)',
                'name' => 'Dwi Handayani, S.T.',
                'email' => 'test.asisten@ibs.test',
                'position' => 'Asisten Kadiv SCM (L1 Approver)',
                'division' => 'SUPPLY CHAIN MANAGEMENT',
            ],
            [
                'nik' => '20230003',
                'role' => 'Kadiv SCM (L2)',
                'name' => 'Hendro Prasetyo, S.T.',
                'email' => 'test.kadiv@ibs.test',
                'position' => 'Kadiv SCM (L2 Approver)',
                'division' => 'SUPPLY CHAIN MANAGEMENT',
            ],
            [
                'nik' => '20230004',
                'role' => 'Accounting (L3)',
                'name' => 'Bambang Sudarsono, S.E.',
                'email' => 'test.accounting@ibs.test',
                'position' => 'Accounting Section Head (L3 Approver)',
                'division' => 'FINANCE & ACCOUNTING',
            ],
            [
                'nik' => '20230005',
                'role' => 'Tax (L4)',
                'name' => 'Citra Anggraini, S.E.',
                'email' => 'test.tax@ibs.test',
                'position' => 'Tax Specialist (L4 Approver)',
                'division' => 'FINANCE & TAXATION',
            ],
            [
                'nik' => '20230006',
                'role' => 'SAP Team (L5)',
                'name' => 'Rizky Pratama, M.Kom.',
                'email' => 'test.sap@ibs.test',
                'position' => 'SAP Specialist (L5 Approver)',
                'division' => 'INFORMATION TECHNOLOGY & SAP',
            ],
            [
                'nik' => '20230007',
                'role' => 'Requester',
                'name' => 'Dimas Anggara',
                'email' => 'test.requester.br@ibs.test',
                'position' => 'Requester Project',
                'division' => 'PROJECT MANAGEMENT',
            ],
            [
                'nik' => '20230008',
                'role' => 'Administrator',
                'name' => 'Admin Testing IBS',
                'email' => 'admin@ibs.test',
                'position' => 'System Administrator (Approver)',
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

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\BudgetRequest;

class BudgetRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tiopan = User::where('nik', '20160163')->first();

        if ($tiopan) {
            $requests = [
                [
                    'doc_number' => 'AM-2026-0001',
                    'type' => 'AM',
                    'am_reference' => null,
                    'title' => 'Pengadaan Server Cloud AWS & Lisensi Docker Enterprise Q1',
                    'category' => 'IT & Software',
                    'amount' => 24500000.00,
                    'description' => 'Biaya langganan infrastruktur cloud IBSW dan lisensi developer tools tim IT Application.',
                    'status' => 'Approved',
                    'approved_by' => 'GUNAWAN TANUDY (Div Head)',
                    'created_at' => now()->subDays(12),
                ],
                [
                    'doc_number' => 'CA-2026-0002',
                    'type' => 'Cash Advance',
                    'am_reference' => 'AM-2026-0001',
                    'title' => 'Perjalanan Dinas Implementasi HRIS Regional Surabaya',
                    'category' => 'Perjalanan Dinas',
                    'amount' => 6800000.00,
                    'description' => 'Akomodasi tiket pesawat, hotel, dan uang saku harian kunjungan deployment sistem kantor cabang Surabaya.',
                    'status' => 'Approved',
                    'approved_by' => 'GUNAWAN TANUDY (Div Head)',
                    'created_at' => now()->subDays(6),
                ],
                [
                    'doc_number' => 'AM-2026-0003',
                    'type' => 'AM',
                    'am_reference' => null,
                    'title' => 'Upgrade RAM & SSD Laptop Tim IT Development',
                    'category' => 'Operational',
                    'amount' => 12300000.00,
                    'description' => 'Pembelian modul RAM DDR5 32GB dan NVMe SSD 1TB untuk 5 unit laptop kerja tim programmer.',
                    'status' => 'Pending',
                    'approved_by' => null,
                    'created_at' => now()->subDays(2),
                ],
                [
                    'doc_number' => 'CA-2026-0004',
                    'type' => 'Cash Advance',
                    'am_reference' => 'AM-2026-0001',
                    'title' => 'Uang Muka Operasional Maintenance Jaringan Kantor Pusat',
                    'category' => 'Operational',
                    'amount' => 3500000.00,
                    'description' => 'Biaya darurat perbaikan instalasi kabel fiber optic dan switch rack di Gedung A IBSW.',
                    'status' => 'Pending',
                    'approved_by' => null,
                    'created_at' => now()->subHours(8),
                ],
            ];

            foreach ($requests as $item) {
                BudgetRequest::updateOrCreate(
                    ['doc_number' => $item['doc_number']],
                    array_merge($item, ['user_id' => $tiopan->id])
                );
            }
        }
    }
}

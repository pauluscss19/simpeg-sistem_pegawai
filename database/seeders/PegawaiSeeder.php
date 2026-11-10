<?php

namespace Database\Seeders;

use App\Models\Pegawai;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PegawaiSeeder extends Seeder
{
    /**
     * Jalankan seeder database pegawai fiktif.
     * Mencakup kedua jenis kelamin, semua jenjang pendidikan, dan semua kelompok usia.
     * Menggunakan updateOrCreate berbasis NIP agar aman dijalankan berulang kali tanpa duplikasi.
     */
    public function run(): void
    {
        $currentYear = Carbon::now()->year;

        $daftarPegawai = [
            // 1. Usia di bawah 20 (< 20 tahun) - misal 18 & 19 tahun
            [
                'nip' => '098101012024011001', // Contoh NIP dengan awalan 0
                'nama' => 'Aditya Pratama',
                'jenis_kelamin' => 'Laki-laki',
                'pendidikan_terakhir' => 'SMA/SMK',
                'tanggal_lahir' => Carbon::createFromDate($currentYear - 18, 5, 12)->format('Y-m-d'),
            ],
            [
                'nip' => '098101022024022002', // Contoh NIP dengan awalan 0
                'nama' => 'Siti Nurhaliza',
                'jenis_kelamin' => 'Perempuan',
                'pendidikan_terakhir' => 'SMA/SMK',
                'tanggal_lahir' => Carbon::createFromDate($currentYear - 19, 8, 20)->format('Y-m-d'),
            ],

            // 2. Usia 20–29 tahun - misal 23 & 26 tahun
            [
                'nip' => '199803152021011003',
                'nama' => 'Bambang Sudarsono',
                'jenis_kelamin' => 'Laki-laki',
                'pendidikan_terakhir' => 'D3',
                'tanggal_lahir' => Carbon::createFromDate($currentYear - 25, 3, 15)->format('Y-m-d'),
            ],
            [
                'nip' => '200109102023022004',
                'nama' => 'Dewi Lestari',
                'jenis_kelamin' => 'Perempuan',
                'pendidikan_terakhir' => 'S1',
                'tanggal_lahir' => Carbon::createFromDate($currentYear - 23, 9, 10)->format('Y-m-d'),
            ],
            [
                'nip' => '199611252020011005',
                'nama' => 'Rian Hidayat',
                'jenis_kelamin' => 'Laki-laki',
                'pendidikan_terakhir' => 'S1',
                'tanggal_lahir' => Carbon::createFromDate($currentYear - 28, 11, 25)->format('Y-m-d'),
            ],

            // 3. Usia 30–39 tahun - misal 32 & 37 tahun
            [
                'nip' => '199204082015022006',
                'nama' => 'Anisa Rahmawati',
                'jenis_kelamin' => 'Perempuan',
                'pendidikan_terakhir' => 'S2',
                'tanggal_lahir' => Carbon::createFromDate($currentYear - 32, 4, 8)->format('Y-m-d'),
            ],
            [
                'nip' => '198706172012011007',
                'nama' => 'Fajar Nugroho',
                'jenis_kelamin' => 'Laki-laki',
                'pendidikan_terakhir' => 'S1',
                'tanggal_lahir' => Carbon::createFromDate($currentYear - 37, 6, 17)->format('Y-m-d'),
            ],
            [
                'nip' => '199002142014022008',
                'nama' => 'Citra Kirana',
                'jenis_kelamin' => 'Perempuan',
                'pendidikan_terakhir' => 'D3',
                'tanggal_lahir' => Carbon::createFromDate($currentYear - 34, 2, 14)->format('Y-m-d'),
            ],

            // 4. Usia 40–49 tahun - misal 42 & 46 tahun
            [
                'nip' => '198207192008011009',
                'nama' => 'Hendro Wibowo',
                'jenis_kelamin' => 'Laki-laki',
                'pendidikan_terakhir' => 'S2',
                'tanggal_lahir' => Carbon::createFromDate($currentYear - 42, 7, 19)->format('Y-m-d'),
            ],
            [
                'nip' => '197805122005022010',
                'nama' => 'Sri Wahyuni',
                'jenis_kelamin' => 'Perempuan',
                'pendidikan_terakhir' => 'SMP',
                'tanggal_lahir' => Carbon::createFromDate($currentYear - 46, 5, 12)->format('Y-m-d'),
            ],
            [
                'nip' => '198008292006011011',
                'nama' => 'Agus Santoso',
                'jenis_kelamin' => 'Laki-laki',
                'pendidikan_terakhir' => 'SD',
                'tanggal_lahir' => Carbon::createFromDate($currentYear - 44, 8, 29)->format('Y-m-d'),
            ],

            // 5. Usia 50 ke atas (>= 50 tahun) - misal 53 & 58 tahun
            [
                'nip' => '197103041998011012',
                'nama' => 'Prof. Dr. Ir. Gunawan',
                'jenis_kelamin' => 'Laki-laki',
                'pendidikan_terakhir' => 'S3',
                'tanggal_lahir' => Carbon::createFromDate($currentYear - 53, 3, 4)->format('Y-m-d'),
            ],
            [
                'nip' => '196612011992022013',
                'nama' => 'Hj. Endang Kusuma Astuti',
                'jenis_kelamin' => 'Perempuan',
                'pendidikan_terakhir' => 'S2',
                'tanggal_lahir' => Carbon::createFromDate($currentYear - 58, 12, 1)->format('Y-m-d'),
            ],
        ];

        foreach ($daftarPegawai as $data) {
            Pegawai::updateOrCreate(
                ['nip' => $data['nip']],
                $data
            );
        }
    }
}

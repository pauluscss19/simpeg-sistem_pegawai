<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard statistik pegawai dengan tiga grafik Chart.js.
     */
    public function index(): View
    {
        // Ambil seluruh data pegawai terbaru dari database
        $pegawaiList = Pegawai::orderBy('nama', 'asc')->get();
        $totalPegawai = $pegawaiList->count();

        // 1. Array Asosiatif untuk Jumlah Pegawai Berdasarkan Jenis Kelamin
        // Semua kategori default diinisialisasi ke 0 agar kategori nol tetap tampil
        $genderCounts = [
            'Laki-laki' => 0,
            'Perempuan' => 0,
        ];

        // 2. Array Asosiatif untuk Jumlah Pegawai Berdasarkan Pendidikan Terakhir
        $pendidikanCounts = [
            'SD' => 0,
            'SMP' => 0,
            'SMA/SMK' => 0,
            'D3' => 0,
            'S1' => 0,
            'S2' => 0,
            'S3' => 0,
        ];

        // 3. Array Asosiatif untuk Jumlah Pegawai Berdasarkan Kelompok Usia
        // Kategori: di bawah 20, 20–29, 30–39, 40–49, dan 50 ke atas
        $usiaCounts = [
            'Di bawah 20' => 0,
            '20–29' => 0,
            '30–39' => 0,
            '40–49' => 0,
            '50 ke atas' => 0,
        ];

        $totalUsia = 0;

        // Logika pengolahan statistik dari koleksi data
        foreach ($pegawaiList as $pegawai) {
            // Hitung statistik jenis kelamin
            if (array_key_exists($pegawai->jenis_kelamin, $genderCounts)) {
                $genderCounts[$pegawai->jenis_kelamin]++;
            }

            // Hitung statistik jenjang pendidikan
            if (array_key_exists($pegawai->pendidikan_terakhir, $pendidikanCounts)) {
                $pendidikanCounts[$pegawai->pendidikan_terakhir]++;
            }

            // Hitung usia dari tanggal_lahir terhadap tanggal hari ini
            $usia = $pegawai->usia;
            $totalUsia += $usia;

            // Algoritma pengelompokan usia
            if ($usia < 20) {
                $usiaCounts['Di bawah 20']++;
            } elseif ($usia >= 20 && $usia <= 29) {
                $usiaCounts['20–29']++;
            } elseif ($usia >= 30 && $usia <= 39) {
                $usiaCounts['30–39']++;
            } elseif ($usia >= 40 && $usia <= 49) {
                $usiaCounts['40–49']++;
            } else {
                $usiaCounts['50 ke atas']++;
            }
        }

        $rataRataUsia = $totalPegawai > 0 ? round($totalUsia / $totalPegawai, 1) : 0;

        // Serialisasi data grafik ke format JSON yang aman untuk Chart.js
        $chartGender = [
            'labels' => array_keys($genderCounts),
            'data' => array_values($genderCounts),
        ];

        $chartPendidikan = [
            'labels' => array_keys($pendidikanCounts),
            'data' => array_values($pendidikanCounts),
        ];

        $chartUsia = [
            'labels' => array_keys($usiaCounts),
            'data' => array_values($usiaCounts),
        ];

        return view('dashboard', [
            'totalPegawai' => $totalPegawai,
            'totalLakiLaki' => $genderCounts['Laki-laki'],
            'totalPerempuan' => $genderCounts['Perempuan'],
            'rataRataUsia' => $rataRataUsia,
            'genderCounts' => $genderCounts,
            'pendidikanCounts' => $pendidikanCounts,
            'usiaCounts' => $usiaCounts,
            'chartGenderJson' => json_encode($chartGender, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP),
            'chartPendidikanJson' => json_encode($chartPendidikan, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP),
            'chartUsiaJson' => json_encode($chartUsia, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP),
        ]);
    }
}

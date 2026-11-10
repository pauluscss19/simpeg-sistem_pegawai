<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database.
     *
     * @var string
     */
    protected $table = 'pegawai';

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nip',
        'nama',
        'jenis_kelamin',
        'pendidikan_terakhir',
        'tanggal_lahir',
    ];

    /**
     * Atribut yang harus dikonversi tipe datanya.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_lahir' => 'date:Y-m-d',
    ];

    /**
     * Daftar pilihan jenis kelamin yang valid.
     */
    public const PILIHAN_JENIS_KELAMIN = [
        'Laki-laki',
        'Perempuan',
    ];

    /**
     * Daftar pilihan jenjang pendidikan terakhir yang valid.
     */
    public const PILIHAN_PENDIDIKAN = [
        'SD',
        'SMP',
        'SMA/SMK',
        'D3',
        'S1',
        'S2',
        'S3',
    ];

    /**
     * Accessor untuk menghitung usia pegawai saat ini berdasarkan tanggal lahir.
     */
    public function getUsiaAttribute(): int
    {
        if (! $this->tanggal_lahir) {
            return 0;
        }

        return Carbon::parse($this->tanggal_lahir)->age;
    }

    /**
     * Accessor untuk format tanggal lahir dalam Bahasa Indonesia (dd Bulan YYYY).
     */
    public function getTanggalLahirFormattedAttribute(): string
    {
        if (! $this->tanggal_lahir) {
            return '-';
        }

        $bulanIndo = [
            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember',
        ];

        $date = Carbon::parse($this->tanggal_lahir);
        $hari = $date->format('d');
        $bulan = $bulanIndo[(int) $date->format('m')] ?? $date->format('F');
        $tahun = $date->format('Y');

        return "{$hari} {$bulan} {$tahun}";
    }
}


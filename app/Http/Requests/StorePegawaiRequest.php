<?php

namespace App\Http\Requests;

use App\Models\Pegawai;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePegawaiRequest extends FormRequest
{
    /**
     * Tentukan apakah pengguna diotorisasi untuk membuat permintaan ini.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Dapatkan aturan validasi yang berlaku untuk permintaan ini.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nip' => [
                'required',
                'string',
                'regex:/^[0-9]+$/',
                'max:20',
                'unique:pegawai,nip',
            ],
            'nama' => [
                'required',
                'string',
                'min:2',
                'max:255',
            ],
            'jenis_kelamin' => [
                'required',
                Rule::in(Pegawai::PILIHAN_JENIS_KELAMIN),
            ],
            'pendidikan_terakhir' => [
                'required',
                Rule::in(Pegawai::PILIHAN_PENDIDIKAN),
            ],
            'tanggal_lahir' => [
                'required',
                'date',
                'before_or_equal:today',
            ],
        ];
    }

    /**
     * Pesan kustom kesalahan validasi dalam Bahasa Indonesia.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'nip.required' => 'NIP wajib diisi.',
            'nip.regex' => 'NIP hanya boleh berisi deretan angka.',
            'nip.max' => 'NIP maksimal 20 digit angka.',
            'nip.unique' => 'NIP sudah terdaftar di sistem. Gunakan NIP lain.',
            'nama.required' => 'Nama pegawai wajib diisi.',
            'nama.min' => 'Nama minimal terdiri dari 2 karakter.',
            'nama.max' => 'Nama maksimal 255 karakter.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in' => 'Pilihan jenis kelamin tidak valid.',
            'pendidikan_terakhir.required' => 'Pendidikan terakhir wajib dipilih.',
            'pendidikan_terakhir.in' => 'Pilihan pendidikan terakhir tidak valid.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date' => 'Format tanggal lahir tidak valid.',
            'tanggal_lahir.before_or_equal' => 'Tanggal lahir tidak valid atau tidak boleh berada di masa depan.',
        ];
    }
}

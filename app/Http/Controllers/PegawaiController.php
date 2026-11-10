<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePegawaiRequest;
use App\Http\Requests\UpdatePegawaiRequest;
use App\Models\Pegawai;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PegawaiController extends Controller
{
    /**
     * Menampilkan daftar semua data pegawai dengan fitur pencarian dan paginasi.
     */
    public function index(Request $request): View
    {
        $keyword = $request->query('cari');

        $query = Pegawai::query();

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('nama', 'like', "%{$keyword}%")
                    ->orWhere('nip', 'like', "%{$keyword}%")
                    ->orWhere('pendidikan_terakhir', 'like', "%{$keyword}%")
                    ->orWhere('jenis_kelamin', 'like', "%{$keyword}%");
            });
        }

        $pegawai = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('pegawai.index', compact('pegawai', 'keyword'));
    }

    /**
     * Menampilkan formulir untuk menambahkan data pegawai baru.
     */
    public function create(): View
    {
        $pilihanJenisKelamin = Pegawai::PILIHAN_JENIS_KELAMIN;
        $pilihanPendidikan = Pegawai::PILIHAN_PENDIDIKAN;

        return view('pegawai.create', compact('pilihanJenisKelamin', 'pilihanPendidikan'));
    }

    /**
     * Menyimpan data pegawai baru ke dalam database.
     */
    public function store(StorePegawaiRequest $request): RedirectResponse
    {
        Pegawai::create($request->validated());

        return redirect()
            ->route('pegawai.index')
            ->with('sukses', "Data pegawai '{$request->nama}' berhasil ditambahkan ke sistem.");
    }

    /**
     * Menampilkan detail data seorang pegawai.
     */
    public function show(Pegawai $pegawai): View
    {
        return view('pegawai.show', compact('pegawai'));
    }

    /**
     * Menampilkan formulir untuk mengubah data pegawai.
     */
    public function edit(Pegawai $pegawai): View
    {
        $pilihanJenisKelamin = Pegawai::PILIHAN_JENIS_KELAMIN;
        $pilihanPendidikan = Pegawai::PILIHAN_PENDIDIKAN;

        return view('pegawai.edit', compact('pegawai', 'pilihanJenisKelamin', 'pilihanPendidikan'));
    }

    /**
     * Memperbarui data pegawai di dalam database.
     */
    public function update(UpdatePegawaiRequest $request, Pegawai $pegawai): RedirectResponse
    {
        $pegawai->update($request->validated());

        return redirect()
            ->route('pegawai.index')
            ->with('sukses', "Data pegawai '{$pegawai->nama}' berhasil diperbarui.");
    }

    /**
     * Menghapus data pegawai dari database.
     */
    public function destroy(Pegawai $pegawai): RedirectResponse
    {
        $nama = $pegawai->nama;
        $pegawai->delete();

        return redirect()
            ->route('pegawai.index')
            ->with('sukses', "Data pegawai '{$nama}' berhasil dihapus dari sistem.");
    }
}

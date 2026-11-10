@extends('layouts.app')

@section('title', 'Detail Pegawai - ' . $pegawai->nama)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="h3 fw-bold mb-1">Detail Informasi Pegawai</h2>
                <p class="text-muted mb-0">Informasi lengkap biodata dan profil pegawai.</p>
            </div>
            <a href="{{ route('pegawai.index') }}" class="btn btn-outline-secondary d-flex align-items-center gap-1">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                <span>Kembali ke Daftar</span>
            </a>
        </div>

        <div class="card main-card overflow-hidden">
            <div class="card-header bg-primary text-white py-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 50px; height: 50px; font-size: 1.25rem;">
                        {{ strtoupper(substr($pegawai->nama, 0, 1)) }}
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold">{{ $pegawai->nama }}</h4>
                        <span class="opacity-75">NIP: {{ $pegawai->nip }}</span>
                    </div>
                </div>
            </div>

            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="p-3 bg-light rounded border">
                            <span class="text-muted small d-block mb-1">Nomor Induk Pegawai (NIP)</span>
                            <span class="fw-bold fs-5 font-monospace">{{ $pegawai->nip }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 bg-light rounded border">
                            <span class="text-muted small d-block mb-1">Nama Lengkap</span>
                            <span class="fw-bold fs-5">{{ $pegawai->nama }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 bg-light rounded border">
                            <span class="text-muted small d-block mb-1">Jenis Kelamin</span>
                            @if ($pegawai->jenis_kelamin === 'Laki-laki')
                                <span class="badge badge-gender-laki fs-6">{{ $pegawai->jenis_kelamin }}</span>
                            @else
                                <span class="badge badge-gender-perempuan fs-6">{{ $pegawai->jenis_kelamin }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 bg-light rounded border">
                            <span class="text-muted small d-block mb-1">Pendidikan Terakhir</span>
                            <span class="badge badge-pendidikan fs-6">{{ $pegawai->pendidikan_terakhir }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 bg-light rounded border">
                            <span class="text-muted small d-block mb-1">Tanggal Lahir</span>
                            <span class="fw-bold">{{ $pegawai->tanggal_lahir_formatted }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 bg-light rounded border">
                            <span class="text-muted small d-block mb-1">Usia Saat Ini</span>
                            <span class="fw-bold text-primary fs-5">{{ $pegawai->usia }} Tahun</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 bg-light rounded border">
                            <span class="text-muted small d-block mb-1">Dibuat Pada</span>
                            <span class="text-muted">{{ $pegawai->created_at ? $pegawai->created_at->format('d/m/Y H:i') : '-' }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 bg-light rounded border">
                            <span class="text-muted small d-block mb-1">Terakhir Diperbarui</span>
                            <span class="text-muted">{{ $pegawai->updated_at ? $pegawai->updated_at->format('d/m/Y H:i') : '-' }}</span>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('pegawai.index') }}" class="btn btn-secondary px-3">
                        &larr; Kembali
                    </a>
                    <div class="d-flex gap-2">
                        <a href="{{ route('pegawai.edit', $pegawai->id) }}" class="btn btn-primary d-flex align-items-center gap-1">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                            </svg>
                            <span>Ubah Data</span>
                        </a>
                        <button type="button" 
                                class="btn btn-danger d-flex align-items-center gap-1"
                                data-bs-toggle="modal" 
                                data-bs-target="#modalKonfirmasiHapusShow">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            </svg>
                            <span>Hapus Pegawai</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus untuk Halaman Show -->
<div class="modal fade" id="modalKonfirmasiHapusShow" tabindex="-1" aria-labelledby="modalKonfirmasiHapusShowLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="modalKonfirmasiHapusShowLabel">Konfirmasi Hapus Pegawai</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body py-4">
                <p class="mb-2">Apakah Anda yakin ingin menghapus data pegawai ini?</p>
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="fw-bold text-danger fs-6">{{ $pegawai->nama }}</div>
                    <div class="font-monospace text-muted">NIP: {{ $pegawai->nip }}</div>
                </div>
                <div class="alert alert-warning py-2 mb-0 small">
                    Pilihan <strong>Batal</strong> akan membatalkan penghapusan dan data tetap tersimpan.
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form method="POST" action="{{ route('pegawai.destroy', $pegawai->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


@extends('layouts.app')

@section('title', 'Daftar Pegawai')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
    <div>
        <h2 class="h3 fw-bold mb-1">Daftar Pegawai</h2>
        <p class="text-muted mb-0">Kelola informasi pegawai, tambah data baru, ubah, dan hapus data.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('pegawai.create') }}" class="btn btn-primary d-flex align-items-center gap-1 shadow-sm">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <line x1="12" y1="5" x2="12" y2="19"></line>
                <line x1="5" y1="12" x2="19" y2="12"></line>
            </svg>
            <span>Tambah Pegawai Baru</span>
        </a>
    </div>
</div>

<div class="card main-card mb-4">
    <div class="card-body p-3 p-md-4">
        <!-- Pencarian & Filter Data -->
        <form method="GET" action="{{ route('pegawai.index') }}" class="row g-2 mb-4">
            <div class="col-md-6 col-lg-5">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </span>
                    <input type="text" name="cari" class="form-control border-start-0 ps-0" placeholder="Cari nama, NIP, jenis kelamin, atau pendidikan..." value="{{ $keyword ?? '' }}">
                    <button type="submit" class="btn btn-primary px-3">Cari</button>
                    @if (!empty($keyword))
                        <a href="{{ route('pegawai.index') }}" class="btn btn-outline-secondary" title="Reset Pencarian">Reset</a>
                    @endif
                </div>
            </div>
            @if (!empty($keyword))
                <div class="col-12">
                    <small class="text-muted">Menampilkan hasil pencarian untuk: <strong>"{{ $keyword }}"</strong> ({{ $pegawai->total() }} data ditemukan)</small>
                </div>
            @endif
        </form>

        <!-- Tabel Daftar Pegawai -->
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 50px;">No</th>
                        <th>NIP</th>
                        <th>Nama Pegawai</th>
                        <th>Jenis Kelamin</th>
                        <th>Tgl Lahir / Usia</th>
                        <th>Pendidikan</th>
                        <th class="text-center" style="width: 190px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pegawai as $index => $item)
                        <tr>
                            <td class="text-center text-muted fw-semibold">
                                {{ $pegawai->firstItem() + $index }}
                            </td>
                            <td>
                                <code class="fw-bold text-dark fs-6">{{ $item->nip }}</code>
                            </td>
                            <td>
                                <span class="fw-semibold text-dark">{{ $item->nama }}</span>
                            </td>
                            <td>
                                @if ($item->jenis_kelamin === 'Laki-laki')
                                    <span class="badge badge-gender-laki">Laki-laki</span>
                                @else
                                    <span class="badge badge-gender-perempuan">Perempuan</span>
                                @endif
                            </td>
                            <td>
                                <div>{{ $item->tanggal_lahir_formatted }}</div>
                                <small class="text-muted fw-semibold">({{ $item->usia }} tahun)</small>
                            </td>
                            <td>
                                <span class="badge badge-pendidikan">{{ $item->pendidikan_terakhir }}</span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-1">
                                    <!-- Tombol Lihat / Detail -->
                                    <a href="{{ route('pegawai.show', $item->id) }}" class="btn btn-sm btn-outline-info text-dark" title="Lihat Detail">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                            <circle cx="12" cy="12" r="3"></circle>
                                        </svg>
                                    </a>
                                    <!-- Tombol Ubah / Edit -->
                                    <a href="{{ route('pegawai.edit', $item->id) }}" class="btn btn-sm btn-outline-primary" title="Ubah Data">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg>
                                    </a>
                                    <!-- Tombol Hapus (Membuka Modal Pop-up Konfirmasi) -->
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-danger btn-trigger-delete" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalKonfirmasiHapus" 
                                            data-id="{{ $item->id }}" 
                                            data-nama="{{ $item->nama }}" 
                                            data-nip="{{ $item->nip }}"
                                            data-action="{{ route('pegawai.destroy', $item->id) }}"
                                            title="Hapus Data">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                            <line x1="10" y1="11" x2="10" y2="17"></line>
                                            <line x1="14" y1="11" x2="14" y2="17"></line>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <div class="mb-2">
                                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="10"></circle>
                                        <line x1="8" y1="12" x2="16" y2="12"></line>
                                    </svg>
                                </div>
                                @if (!empty($keyword))
                                    <p class="mb-2 fw-semibold">Tidak ditemukan pegawai dengan kata kunci "{{ $keyword }}"</p>
                                    <a href="{{ route('pegawai.index') }}" class="btn btn-sm btn-outline-secondary">Reset Pencarian</a>
                                @else
                                    <p class="mb-2 fw-semibold">Belum ada data pegawai yang terdaftar.</p>
                                    <a href="{{ route('pegawai.create') }}" class="btn btn-sm btn-primary">+ Tambah Pegawai Baru</a>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginasi -->
        @if ($pegawai->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-2">
                <div class="text-muted small">
                    Menampilkan {{ $pegawai->firstItem() }} sampai {{ $pegawai->lastItem() }} dari {{ $pegawai->total() }} data
                </div>
                <div>
                    {{ $pegawai->links() }}
                </div>
            </div>
        @endif
    </div>
</div>

<!-- ============================================================== -->
<!-- POP-UP MODAL KONFIRMASI PENGHAPUSAN PEGAWAI                    -->
<!-- Sesuai Fitur Wajib 2:                                          -->
<!-- Menampilkan nama pegawai dengan pilihan Batal dan Hapus.       -->
<!-- Jika Batal / ditutup, data tetap aman tersimpan.               -->
<!-- Formulir hanya dikirim saat dikonfirmasi dengan CSRF & DELETE  -->
<!-- ============================================================== -->
<div class="modal fade" id="modalKonfirmasiHapus" tabindex="-1" aria-labelledby="modalKonfirmasiHapusLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title d-flex align-items-center gap-2" id="modalKonfirmasiHapusLabel">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                        <line x1="12" y1="9" x2="12" y2="13"></line>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                    <span>Konfirmasi Hapus Pegawai</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body py-4">
                <p class="mb-2">Apakah Anda yakin ingin menghapus data pegawai berikut?</p>
                <div class="p-3 bg-light rounded border mb-3">
                    <div class="row mb-1">
                        <div class="col-4 text-muted small">Nama Pegawai:</div>
                        <div class="col-8 fw-bold text-danger fs-6" id="namaPegawaiHapus">-</div>
                    </div>
                    <div class="row">
                        <div class="col-4 text-muted small">NIP Pegawai:</div>
                        <div class="col-8 font-monospace" id="nipPegawaiHapus">-</div>
                    </div>
                </div>
                <div class="alert alert-warning py-2 mb-0 d-flex align-items-center gap-2 small">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-warning flex-shrink-0">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                    <span>Pilihan <strong>Batal</strong> akan membatalkan penghapusan dan data tetap tersimpan.</span>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <!-- Tombol Batal: Menutup pop-up, data tetap tersimpan -->
                <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal" id="btnBatalHapus">
                    Batal
                </button>

                <!-- Formulir Penghapusan: Hanya dikirim saat admin mengonfirmasi tombol Hapus -->
                <form id="formHapusPegawai" method="POST" action="" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger px-3 d-flex align-items-center gap-1" id="btnKonfirmasiHapus">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        </svg>
                        <span>Hapus</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modalElement = document.getElementById('modalKonfirmasiHapus');
        const formHapus = document.getElementById('formHapusPegawai');
        const labelNama = document.getElementById('namaPegawaiHapus');
        const labelNip = document.getElementById('nipPegawaiHapus');

        // Tangkap event saat tombol hapus pada baris tabel ditekan
        document.querySelectorAll('.btn-trigger-delete').forEach(function (button) {
            button.addEventListener('click', function () {
                const nama = this.getAttribute('data-nama');
                const nip = this.getAttribute('data-nip');
                const actionUrl = this.getAttribute('data-action');

                // Tampilkan nama dan NIP pegawai di dalam modal pop-up konfirmasi
                labelNama.textContent = nama;
                labelNip.textContent = nip;

                // Atur endpoint URL action pada form hapus
                formHapus.setAttribute('action', actionUrl);
            });
        });

        // Reset URL aksi formulir jika modal ditutup atau dibatalkan
        modalElement.addEventListener('hidden.bs.modal', function () {
            formHapus.setAttribute('action', '');
            labelNama.textContent = '-';
            labelNip.textContent = '-';
        });
    });
</script>
@endpush

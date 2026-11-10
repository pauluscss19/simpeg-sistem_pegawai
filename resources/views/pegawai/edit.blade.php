@extends('layouts.app')

@section('title', 'Ubah Data Pegawai - ' . $pegawai->nama)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h2 class="h3 fw-bold mb-1">Ubah Data Pegawai</h2>
                <p class="text-muted mb-0">Perbarui data pegawai <strong>{{ $pegawai->nama }}</strong>.</p>
            </div>
            <a href="{{ route('pegawai.index') }}" class="btn btn-outline-secondary d-flex align-items-center gap-1">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                <span>Kembali ke Daftar</span>
            </a>
        </div>

        <div class="card main-card">
            <div class="card-body p-4">
                <form action="{{ route('pegawai.update', $pegawai->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- 1. Nomor Induk Pegawai (NIP) -->
                    <div class="mb-3">
                        <label for="nip" class="form-label fw-semibold">
                            Nomor Induk Pegawai (NIP) <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               name="nip" 
                               id="nip" 
                               class="form-control font-monospace @error('nip') is-invalid @enderror" 
                               value="{{ old('nip', $pegawai->nip) }}" 
                               maxlength="20"
                               required>
                        <div class="form-text text-muted">
                            Pegawai diperbolehkan mempertahankan NIP miliknya saat diedit. Sistem menolak NIP jika telah dipakai pegawai lain.
                        </div>
                        @error('nip')
                            <div class="invalid-feedback d-block fw-semibold">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- 2. Nama Lengkap Pegawai -->
                    <div class="mb-3">
                        <label for="nama" class="form-label fw-semibold">
                            Nama Lengkap Pegawai <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               name="nama" 
                               id="nama" 
                               class="form-control @error('nama') is-invalid @enderror" 
                               value="{{ old('nama', $pegawai->nama) }}" 
                               required>
                        @error('nama')
                            <div class="invalid-feedback d-block fw-semibold">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <!-- 3. Jenis Kelamin -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold d-block">
                            Jenis Kelamin <span class="text-danger">*</span>
                        </label>
                        <div class="d-flex gap-4">
                            @foreach ($pilihanJenisKelamin as $jk)
                                <div class="form-check">
                                    <input class="form-check-input @error('jenis_kelamin') is-invalid @enderror" 
                                           type="radio" 
                                           name="jenis_kelamin" 
                                           id="jk_{{ $loop->index }}" 
                                           value="{{ $jk }}" 
                                           {{ old('jenis_kelamin', $pegawai->jenis_kelamin) === $jk ? 'checked' : '' }}
                                           required>
                                    <label class="form-check-label" for="jk_{{ $loop->index }}">
                                        {{ $jk }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        @error('jenis_kelamin')
                            <div class="invalid-feedback d-block fw-semibold">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="row">
                        <!-- 4. Pendidikan Terakhir -->
                        <div class="col-md-6 mb-3">
                            <label for="pendidikan_terakhir" class="form-label fw-semibold">
                                Pendidikan Terakhir <span class="text-danger">*</span>
                            </label>
                            <select name="pendidikan_terakhir" 
                                    id="pendidikan_terakhir" 
                                    class="form-select @error('pendidikan_terakhir') is-invalid @enderror" 
                                    required>
                                @foreach ($pilihanPendidikan as $pendidikan)
                                    <option value="{{ $pendidikan }}" {{ old('pendidikan_terakhir', $pegawai->pendidikan_terakhir) === $pendidikan ? 'selected' : '' }}>
                                        {{ $pendidikan }}
                                    </option>
                                @endforeach
                            </select>
                            @error('pendidikan_terakhir')
                                <div class="invalid-feedback d-block fw-semibold">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- 5. Tanggal Lahir -->
                        <div class="col-md-6 mb-3">
                            <label for="tanggal_lahir" class="form-label fw-semibold">
                                Tanggal Lahir <span class="text-danger">*</span>
                            </label>
                            <input type="date" 
                                   name="tanggal_lahir" 
                                   id="tanggal_lahir" 
                                   max="{{ date('Y-m-d') }}" 
                                   class="form-control @error('tanggal_lahir') is-invalid @enderror" 
                                   value="{{ old('tanggal_lahir', optional($pegawai->tanggal_lahir)->format('Y-m-d')) }}" 
                                   required>
                            <div class="form-text text-muted">
                                Usia saat ini: <strong>{{ $pegawai->usia }} tahun</strong> (dihitung otomatis).
                            </div>
                            @error('tanggal_lahir')
                                <div class="invalid-feedback d-block fw-semibold">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Tombol Aksi Simpan dan Batal -->
                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('pegawai.index') }}" class="btn btn-secondary px-4">Batal</a>
                        <button type="submit" class="btn btn-primary px-4 d-flex align-items-center gap-2">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                                <polyline points="17 21 17 13 7 13 7 21"></polyline>
                                <polyline points="7 3 7 8 15 8"></polyline>
                            </svg>
                            <span>Perbarui Pegawai</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


@extends('admin.layouts.app')

@section('content')
    <main class="container py-4">
        <h4>Lain-Lain ></h4>
        <h1 class="mb-4 fw-bold">Buat Surat Perjalanan Dinas Baru</h1>
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <form action="{{ route('subkeg-lain.sppd.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row mb-3">
                <div class="col">
                    <label for="lembar" class="form-label">Lembar Ke</label>
                    <input type="number" class="form-control" id="lembar" name="lembar">
                </div>
                <div class="col">
                    <label for="kode" class="form-label">Kode</label>
                    <input type="number" class="form-control" id="kode" name="kode">
                </div>
                <div class="col">
                    <label for="nomor_surat" class="form-label">Nomor Surat</label>
                    <input type="text" class="form-control" id="nomor_surat" name="nomor_surat">
                </div>
            </div>
            <div class="mb-3">
                <label for="pegawai_pemberi_wewenang" class="form-label">Pegawai yang Memberikan Wewenang<span
                        class="text-danger">*</span></label>
                <select class="form-select" name="pegawai_pemberi_wewenang" id="pegawai_pemberi_wewenang" required>
                    <option value="" selected disabled>-- Pilih Pegawai --</option>
                    @foreach ($pegawai as $p)
                        <option value="{{ $p->id }}">{{ $p->nip }} - {{ $p->nama }} - {{ $p->jabatan_ttd }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="pegawai_pelaksana" class="form-label">Pegawai yang Melaksanakan Perjalanan Dinas<span
                        class="text-danger">*</span></label>
                <select class="form-select" name="pegawai_pelaksana" id="pegawai_pelaksana" required>
                    <option value="" selected disabled>-- Pilih Pegawai --</option>
                    @foreach ($pegawai as $p)
                        <option value="{{ $p->id }}">{{ $p->nip }} - {{ $p->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="tingkat_biaya" class="form-label">Tingkat Biaya<span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="tingkat_biaya" name="tingkat_biaya" required>
            </div>
            <div class="mb-3">
                <label for="maksud" class="form-label">Maksud Perjalanan Dinas<span class="text-danger">*</span></label>
                <textarea class="form-control" id="maksud" name="maksud" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="alat_angkut" class="form-label">Alat Angkut<span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="alat_angkut" name="alat_angkut" required>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="tempat_berangkat" class="form-label">Tempat Berangkat<span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="tempat_berangkat" name="tempat_berangkat" required>
                </div>
                <div class="col">
                    <label for="tempat_kedudukan" class="form-label">Tempat Kedudukan</label>
                    <input type="text" class="form-control" id="tempat_kedudukan" name="tempat_kedudukan">
                </div>
                <div class="col">
                    <label for="tempat_tujuan" class="form-label">Tempat Tujuan<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="tempat_tujuan" name="tempat_tujuan" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="jumlah_hari" class="form-label">Lamanya Perjalanan Dinas (hari)<span
                            class="text-danger">*</span></label>
                    <input type="number" class="form-control" id="jumlah_hari" name="jumlah_hari" required>
                </div>
                <div class="col">
                    <label for="tanggal_berangkat" class="form-label">Tanggal Berangkat<span
                            class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="tanggal_berangkat" name="tanggal_berangkat" required>
                </div>
                <div class="col">
                    <label for="tanggal_kembali" class="form-label">Tanggal Kembali<span
                            class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="tanggal_kembali" name="tanggal_kembali" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="instansi_pembebanan_anggaran" class="form-label">Instansi Pembebanan Anggaran<span
                        class="text-danger">*</span></label>
                <input type="text" class="form-control" id="instansi_pembebanan_anggaran"
                    name="instansi_pembebanan_anggaran" required>
            </div>
            <div class="mb-3">
                <label for="akun_pembebanan_anggaran" class="form-label">Akun Pembebanan Anggaran<span
                        class="text-danger">*</span></label>
                <input type="text" class="form-control" id="akun_pembebanan_anggaran" name="akun_pembebanan_anggaran"
                    required>
            </div>
            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan Lain</label>
                <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <h2>Pengikut (Max. 3 orang)</h2>
            </div>
            <div class="mb-3">
                <label for="pegawai_pengikut_1" class="form-label">Pengikut 1</label>
                <select class="form-select" name="pegawai_pengikut_1" id="pegawai_pengikut_1">
                    <option value="" selected disabled>-- Pilih Pegawai --</option>
                    @foreach ($pegawai as $p)
                        <option value="{{ $p->id }}">{{ $p->nip }} - {{ $p->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="pegawai_pengikut_2" class="form-label">Pengikut 2</label>
                <select class="form-select" name="pegawai_pengikut_2" id="pegawai_pengikut_2">
                    <option value="" selected disabled>-- Pilih Pegawai --</option>
                    @foreach ($pegawai as $p)
                        <option value="{{ $p->id }}">{{ $p->nip }} - {{ $p->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="pegawai_pengikut_3" class="form-label">Pengikut 3</label>
                <select class="form-select" name="pegawai_pengikut_3" id="pegawai_pengikut_3">
                    <option value="" selected disabled>-- Pilih Pegawai --</option>
                    @foreach ($pegawai as $p)
                        <option value="{{ $p->id }}">{{ $p->nip }} - {{ $p->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <h2>Perjalanan</h2>
            </div>
            <div class="mb-3">
                <h5>Pemberangkatan</h5>
            </div>
            <div class="mb-3">
                <label for="pegawai_mengetahui" class="form-label">Pegawai yang Mengetahui (PPTK)</label>
                <select class="form-select" name="pegawai_mengetahui" id="pegawai_mengetahui">
                    <option value="" selected disabled>-- Pilih Pegawai --</option>
                    @foreach ($pegawai as $p)
                        <option value="{{ $p->id }}">{{ $p->nip }} - {{ $p->nama }} -
                            {{ $p->jabatan_ttd }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <h5>Tiba di Tempat dan Kembali</h5>
            </div>
            <div class="mb-3">
                <label for="tanggal_tiba" class="form-label">Tanggal Tiba di Tempat</label>
                <input type="date" class="form-control" id="tanggal_tiba" name="tanggal_tiba">
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="kepala_jabatan_di_tempat" class="form-label">Kepala Bidang/Subbag/Seksi</label>
                    <input type="text" class="form-control" id="kepala_jabatan_di_tempat"
                        name="kepala_jabatan_di_tempat">
                </div>
                <div class="col">
                    <label for="nama_di_tempat" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama_di_tempat" name="nama_di_tempat">
                </div>
                <div class="col">
                    <label for="nip_di_tempat" class="form-label">NIP</label>
                    <input type="text" class="form-control" id="nip_di_tempat" name="nip_di_tempat">
                </div>
            </div>
            <div class="mb-3">
                <p class="text-danger">*wajib diisi</p>
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
            <a href="{{ route('subkeg-lain.sppd.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </main>
@endsection

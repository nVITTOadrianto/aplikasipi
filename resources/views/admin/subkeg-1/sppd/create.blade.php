@extends('admin.layouts.app')

@section('content')
    <main class="container py-4">
        <h4>Koordinasi, Sinkronisasi, dan Pelaksanaan Pemberdayaan Industri dan Peran Serta Masyarakat ></h4>
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
        <form action="{{ route('subkeg-1.sppd.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="text" name="sub_kegiatan"
                value="Koordinasi, Sinkronisasi, dan Pelaksanaan Pemberdayaan Industri dan Peran Serta Masyarakat" hidden>
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
                        <option value="{{ $p->id }}">{{ $p->nip }} - {{ $p->nama }} -
                            {{ $p->jabatan_ttd }}
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
                        <option value="{{ $p->id }}">{{ $p->nip }} - {{ $p->nama }} -
                            {{ $p->golongan }}{{ $p->ruang ? '/' . $p->ruang : '' }}</option>
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
                <label for="tanggal_dibuat_surat" class="form-label">Tanggal Dibuat Surat<span
                        class="text-danger">*</span></label>
                <input type="date" class="form-control" id="tanggal_dibuat_surat" name="tanggal_dibuat_surat"
                    required>
            </div>
            <div class="mb-3">
                <h2>Pengikut (Max. 3 orang)</h2>
            </div>
            <div class="mb-3">
                <label for="pegawai_pengikut_1" class="form-label">Pengikut 1</label>
                <select class="form-select" name="pegawai_pengikut_1" id="pegawai_pengikut_1">
                    <option value="" selected>-- Tidak Ada --</option>
                    @foreach ($pegawai as $p)
                        <option value="{{ $p->id }}">{{ $p->nip }} - {{ $p->nama }} -
                            {{ $p->golongan }}{{ $p->ruang ? '/' . $p->ruang : '' }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="pegawai_pengikut_2" class="form-label">Pengikut 2</label>
                <select class="form-select" name="pegawai_pengikut_2" id="pegawai_pengikut_2">
                    <option value="" selected>-- Tidak Ada --</option>
                    @foreach ($pegawai as $p)
                        <option value="{{ $p->id }}">{{ $p->nip }} - {{ $p->nama }} -
                            {{ $p->golongan }}{{ $p->ruang ? '/' . $p->ruang : '' }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="pegawai_pengikut_3" class="form-label">Pengikut 3</label>
                <select class="form-select" name="pegawai_pengikut_3" id="pegawai_pengikut_3">
                    <option value="" selected>-- Tidak Ada --</option>
                    @foreach ($pegawai as $p)
                        <option value="{{ $p->id }}">{{ $p->nip }} - {{ $p->nama }} -
                            {{ $p->golongan }}{{ $p->ruang ? '/' . $p->ruang : '' }}</option>
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
                <label for="pegawai_mengetahui" class="form-label">Pejabat Pelaksana Teknis Kegiatan</label>
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
                <h2>Rincian Biaya</h2>
            </div>
            <div class="mb-3">
                <h5>Biaya Angkutan Pegawai</h5>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="biaya_pergi" class="form-label">Biaya Pergi</label>
                    <input type="text" class="form-control" id="biaya_pergi" name="biaya_pergi">
                </div>
                <div class="col">
                    <label for="biaya_pulang" class="form-label">Biaya Pulang</label>
                    <input type="text" class="form-control" id="biaya_pulang" name="biaya_pulang">
                </div>
            </div>
            <div class="mb-3">
                <h5>Biaya Harian</h5>
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" value="1" id="menginap" name="menginap" checked>
                <label class="form-check-label" for="menginap">
                    Menginap (jika tidak menginap, biaya penginapan dibayar 30%)
                </label>
            </div>
            <div class="row mb-3">
                <div class="col-2">
                    <label for="jumlah_hari_penginapan" class="form-label">Lama Penginapan (hari)</label>
                    <input type="number" class="form-control" id="jumlah_hari_penginapan" name="jumlah_hari_penginapan">
                </div>
                <div class="col">
                    <label for="biaya_penginapan_4" class="form-label">Biaya Penginapan Golongan IV</label>
                    <input type="text" class="form-control" id="biaya_penginapan_4" name="biaya_penginapan_4">
                </div>
                <div class="col">
                    <label for="biaya_penginapan_3" class="form-label">Biaya Penginapan Golongan III</label>
                    <input type="text" class="form-control" id="biaya_penginapan_3" name="biaya_penginapan_3">
                </div>
                <div class="col">
                    <label for="biaya_penginapan_2" class="form-label">Biaya Penginapan Golongan II</label>
                    <input type="text" class="form-control" id="biaya_penginapan_2" name="biaya_penginapan_2">
                </div>
                <div class="col">
                    <label for="biaya_penginapan_1" class="form-label">Biaya Penginapan Golongan I</label>
                    <input type="text" class="form-control" id="biaya_penginapan_1" name="biaya_penginapan_1">
                </div>
            </div>
            <div class="mb-3">
                <label for="uang_harian" class="form-label">Uang Harian (untuk Semua Golongan)</label>
                <input type="text" class="form-control" id="uang_harian" name="uang_harian">
            </div>
            <div class="mb-3">
                <h5>Biaya Lain</h5>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="biaya_penerbangan" class="form-label">Biaya Penerbangan</label>
                    <input type="text" class="form-control" id="biaya_penerbangan" name="biaya_penerbangan">
                </div>
                <div class="col">
                    <label for="keterangan_penerbangan" class="form-label">Keterangan Biaya Penerbangan</label>
                    <input type="text" class="form-control" id="keterangan_penerbangan"
                        name="keterangan_penerbangan">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="biaya_tol" class="form-label">Biaya Tol</label>
                    <input type="text" class="form-control" id="biaya_tol" name="biaya_tol">
                </div>
                <div class="col">
                    <label for="keterangan_tol" class="form-label">Keterangan Biaya Tol</label>
                    <input type="text" class="form-control" id="keterangan_tol" name="keterangan_tol">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="biaya_lain" class="form-label">Biaya Lain-Lain</label>
                    <input type="text" class="form-control" id="biaya_lain" name="biaya_lain">
                </div>
                <div class="col">
                    <label for="keterangan_lain" class="form-label">Keterangan Biaya Lain-Lain</label>
                    <input type="text" class="form-control" id="keterangan_lain" name="keterangan_lain">
                </div>
            </div>
            <div class="mb-3">
                <label for="pegawai_bendahara" class="form-label">Bendahara Pengeluaran</label>
                <select class="form-select" name="pegawai_bendahara" id="pegawai_bendahara">
                    <option value="" selected disabled>-- Pilih Pegawai --</option>
                    @foreach ($pegawai as $p)
                        <option value="{{ $p->id }}">{{ $p->nip }} - {{ $p->nama }} -
                            {{ $p->jabatan_ttd }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <p class="text-danger">*wajib diisi</p>
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
            <a href="{{ route('subkeg-1.sppd.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </main>
@endsection

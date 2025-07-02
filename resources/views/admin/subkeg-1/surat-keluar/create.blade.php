@extends('admin.layouts.app')

@section('content')
    <main class="container py-4">
        <h4>Koordinasi, Sinkronisasi, dan Pelaksanaan Pemberdayaan Industri dan Peran Serta Masyarakat ></h4>
        <h1 class="mb-4 fw-bold">Tambah Surat Keluar Baru</h1>
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
        <form action="{{ route('subkeg-1.surat-keluar.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="text" name="sub_kegiatan" value="Koordinasi, Sinkronisasi, dan Pelaksanaan Pemberdayaan Industri dan Peran Serta Masyarakat" hidden>
            <div class="mb-3">
                <label for="penerima" class="form-label">Surat Kepada<span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="penerima" name="penerima" required>
            </div>
            <div class="mb-3">
                <label for="nomor_surat" class="form-label">Nomor Surat<span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nomor_surat" name="nomor_surat" required>
            </div>
            <div class="mb-3">
                <label for="tanggal_surat" class="form-label">Tanggal Surat<span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="tanggal_surat" name="tanggal_surat" required>
            </div>
            <div class="mb-3">
                <label for="perihal" class="form-label">Perihal<span class="text-danger">*</span></label>
                <textarea class="form-control" id="perihal" name="perihal" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="sifat" class="form-label">Sifat Surat<span class="text-danger">*</span></label>
                <select class="form-select" id="sifat" name="sifat" required>
                    <option value="Segera">Segera</option>
                    <option value="Biasa">Biasa</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="file_surat" class="form-label">File Surat (opsional)</label>
                <input type="file" class="form-control" id="file_surat" name="file_surat"
                    accept=".pdf,.doc,.docx,.jpg,.png" aria-describedby="fileHelp">
                <div id="fileHelp" class="form-text">File yang didukung: .pdf .doc .docx .jpg .png (Maks. 2 MB)</div>
            </div>
            <div class="mb-3">
                <p class="text-danger">*wajib diisi</p>
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
            <a href="{{ route('subkeg-1.surat-keluar.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </main>
@endsection

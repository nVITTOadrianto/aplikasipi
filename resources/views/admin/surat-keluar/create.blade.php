@extends('admin.layouts.app')

@section('content')
<main class="container py-4">
    <h1 class="mb-4 fw-bold">Tambah Surat Keluar Baru</h1>
    <form action="{{ route('surat-keluar.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="penerima" class="form-label">Surat Kepada*</label>
            <input type="text" class="form-control" id="penerima" name="penerima" required>
        </div>
        <div class="mb-3">
            <label for="nomor_surat" class="form-label">Nomor Surat*</label>
            <input type="text" class="form-control" id="nomor_surat" name="nomor_surat" required>
        </div>
        <div class="mb-3">
            <label for="tanggal_surat" class="form-label">Tanggal Surat*</label>
            <input type="date" class="form-control" id="tanggal_surat" name="tanggal_surat" required>
        </div>
        <div class="mb-3">
            <label for="perihal" class="form-label">Perihal*</label>
            <textarea class="form-control" id="perihal" name="perihal" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="sifat" class="form-label">Sifat Surat*</label>
            <select class="form-select" id="sifat" name="sifat" required>
                <option value="Segera">Segera</option>
                <option value="Rahasia">Rahasia</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="file_surat" class="form-label">File Surat (opsional)</label>
            <input type="file" class="form-control" id="file_surat" name="file_surat" accept=".pdf,.doc,.docx,.jpg,.png">
        </div>
        <div class="mb-3">
            <p>*wajib diisi</p>
        </div>
        <button type="submit" class="btn btn-success">Submit</button>
        <a href="{{ route('surat-keluar.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</main>
@endsection
@extends('admin.layouts.app')

@section('content')
<main class="container py-4">
    <h1 class="mb-4 fw-bold">Edit Surat Keluar</h1>
    <form action="{{ route('surat-keluar.update', $suratKeluar->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="penerima" class="form-label">Surat Kepada*</label>
            <input type="text" class="form-control" id="penerima" name="penerima" value="{{ $suratKeluar->penerima }}" required>
        </div>
        <div class="mb-3">
            <label for="nomor_surat" class="form-label">Nomor Surat*</label>
            <input type="text" class="form-control" id="nomor_surat" name="nomor_surat" value="{{ $suratKeluar->nomor_surat }}" required>
        </div>
        <div class="mb-3">
            <label for="tanggal_surat" class="form-label">Tanggal Surat*</label>
            <input type="date" class="form-control" id="tanggal_surat" name="tanggal_surat" value="{{ $suratKeluar->tanggal_surat }}" required>
        </div>
        <div class="mb-3">
            <label for="perihal" class="form-label">Perihal*</label>
            <textarea class="form-control" id="perihal" name="perihal" rows="3" required>{{ $suratKeluar->perihal }}</textarea>
        </div>
        <div class="mb-3">
            <label for="sifat" class="form-label">Sifat Surat*</label>
            <select class="form-select" id="sifat" name="sifat" required>
                <option value="Segera" {{ $suratKeluar->sifat == 'Segera' ? 'selected' : '' }}>Segera</option>
                <option value="Rahasia" {{ $suratKeluar->sifat == 'Rahasia' ? 'selected' : '' }}>Rahasia</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="file_surat" class="form-label">File Surat (opsional)</label>
            <input type="file" class="form-control" id="file_surat" name="file_surat" accept=".pdf,.doc,.docx,.jpg,.png">
        </div>
        <button type="submit" class="btn btn-success">Submit</button>
        <a href="{{ route('surat-keluar.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</main>
@endsection
@extends('admin.layouts.app')

@section('content')
<main class="container py-4">
    <h1 class="mb-4 fw-bold">Edit Surat Masuk</h1>
    <form action="{{ route('surat-masuk.update', $suratMasuk->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="pengirim" class="form-label">Surat Dari*</label>
            <input type="text" class="form-control" id="pengirim" name="pengirim" value="{{ $suratMasuk->pengirim }}" required>
        </div>
        <div class="mb-3">
            <label for="nomor_surat" class="form-label">Nomor Surat*</label>
            <input type="text" class="form-control" id="nomor_surat" name="nomor_surat" value="{{ $suratMasuk->nomor_surat }}" required>
        </div>
        <div class="mb-3">
            <label for="tanggal_surat" class="form-label">Tanggal Surat*</label>
            <input type="date" class="form-control" id="tanggal_surat" name="tanggal_surat" value="{{ $suratMasuk->tanggal_surat }}" required>
        </div>
        <div class="mb-3">
            <label for="tanggal_diterima" class="form-label">Tanggal Diterima</label>
            <input type="date" class="form-control" id="tanggal_diterima" name="tanggal_diterima" value="{{ $suratMasuk->tanggal_diterima }}" required>
        </div>
        <div class="mb-3">
            <label for="nomor_agenda" class="form-label">Nomor Agenda*</label>
            <input type="number" class="form-control" id="nomor_agenda" name="nomor_agenda" value="{{ $suratMasuk->nomor_agenda }}" required>
        </div>
        <div class="mb-3">
            <label for="sifat" class="form-label">Sifat Surat*</label>
            <select class="form-select" id="sifat" name="sifat" required>
                <option value="Segera" {{ $suratMasuk->sifat == 'Segera' ? 'selected' : '' }}>Segera</option>
                <option value="Rahasia" {{ $suratMasuk->sifat == 'Rahasia' ? 'selected' : '' }}>Rahasia</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="perihal" class="form-label">Perihal*</label>
            <textarea class="form-control" id="perihal" name="perihal" rows="3" required>{{ $suratMasuk->perihal }}</textarea>
        </div>
        <div class="mb-3">
            <label for="file_surat" class="form-label">File Surat (opsional)</label>
            <input type="file" class="form-control" id="file_surat" name="file_surat" accept=".pdf,.doc,.docx,.jpg,.png">
        </div>
        <div class="mb-3">
            <p>*wajib diisi</p>
        </div>
        <button type="submit" class="btn btn-success">Submit</button>
        <a href="{{ route('surat-masuk.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</main>
@endsection
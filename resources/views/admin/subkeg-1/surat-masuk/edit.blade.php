@extends('admin.layouts.app')

@section('content')
    <main class="container py-4">
        <h4>Koordinasi, Sinkronisasi, dan Pelaksanaan Pemberdayaan Industri dan Peran Serta Masyarakat ></h4>
        <h1 class="mb-4 fw-bold">Edit Surat Masuk</h1>
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
        <form action="{{ route('subkeg-1.surat-masuk.update', $suratMasuk->id) }}" method="post"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="text" name="sub_kegiatan"
                value="Koordinasi, Sinkronisasi, dan Pelaksanaan Pemberdayaan Industri dan Peran Serta Masyarakat" hidden>
            <div class="mb-3">
                <label for="pengirim" class="form-label">Surat Dari<span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="pengirim" name="pengirim"
                    value="{{ $suratMasuk->pengirim }}" required>
            </div>
            <div class="mb-3">
                <label for="nomor_surat" class="form-label">Nomor Surat<span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="nomor_surat" name="nomor_surat"
                    value="{{ $suratMasuk->nomor_surat }}" required>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="tanggal_surat" class="form-label">Tanggal Surat<span class="text-danger">*</span></label>
                    <input type="date" class="form-control" id="tanggal_surat" name="tanggal_surat"
                        value="{{ $suratMasuk->tanggal_surat->format('Y-m-d') }}" required>
                </div>
                <div class="col">
                    <label for="tanggal_diterima" class="form-label">Tanggal Diterima</label>
                    <input type="date" class="form-control" id="tanggal_diterima" name="tanggal_diterima"
                        value="{{ $suratMasuk->tanggal_diterima->format('Y-m-d') }}" required>
                </div>
            </div>
            <div class="mb-3">
                <label for="nomor_agenda" class="form-label">Nomor Agenda<span class="text-danger">*</span></label>
                <input type="number" class="form-control" id="nomor_agenda" name="nomor_agenda"
                    value="{{ $suratMasuk->nomor_agenda }}" required>
            </div>
            <div class="mb-3">
                <label for="sifat" class="form-label">Sifat Surat<span class="text-danger">*</span></label>
                <select class="form-select" id="sifat" name="sifat" required>
                    <option value="Segera" {{ $suratMasuk->sifat == 'Segera' ? 'selected' : '' }}>Segera</option>
                    <option value="Biasa" {{ $suratMasuk->sifat == 'Biasa' ? 'selected' : '' }}>Biasa</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="perihal" class="form-label">Perihal<span class="text-danger">*</span></label>
                <textarea class="form-control" id="perihal" name="perihal" rows="3" required>{{ $suratMasuk->perihal }}</textarea>
            </div>
            <div class="mb-3">
                <label for="file_surat" class="form-label">File Surat (kosongkan jika tidak ingin mengganti surat)</label>
                <input type="file" class="form-control" id="file_surat" name="file_surat"
                    accept=".pdf,.doc,.docx,.jpg,.png" aria-describedby="fileHelp">
                <div id="fileHelp" class="form-text">File yang didukung: .pdf .doc .docx .jpg .png (Maks. 5 MB)</div>
            </div>
            <div class="mb-3">
                <p class="text-danger">*wajib diisi</p>
            </div>
            <button type="submit" class="btn btn-success">Submit</button>
            <a href="{{ route('subkeg-1.surat-masuk.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </main>
@endsection

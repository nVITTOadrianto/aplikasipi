@extends('admin.layouts.app')

@section('content')
    <main class="container py-4">
        <h4>Lain-Lain ></h4>
        <h1 class="mb-4 fw-bold">Detail Surat Masuk</h1>
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title mb-3">Surat Dari: {{ $suratMasuk->pengirim }}</h5>
                <p class="card-text"><strong>Nomor Surat:</strong> {{ $suratMasuk->nomor_surat }}</p>
                <p class="card-text"><strong>Tanggal Surat:</strong> {{ $suratMasuk->tanggal_surat->isoFormat('D MMMM YYYY') }}</p>
                <p class="card-text"><strong>Tanggal Diterima:</strong>
                    {{ $suratMasuk->tanggal_diterima ? $suratMasuk->tanggal_diterima->isoFormat('D MMMM YYYY') : 'Belum Diterima' }}</p>
                <p class="card-text"><strong>Nomor Agenda:</strong> {{ $suratMasuk->nomor_agenda }}</p>
                <p class="card-text"><strong>Sifat Surat:</strong> {{ $suratMasuk->sifat }}</p>
                <p class="card-text"><strong>Perihal:</strong> {{ $suratMasuk->perihal }}</p>
                @if ($suratMasuk->file_surat)
                    <p class="card-text"><strong>File Surat:</strong> <a
                            href="{{ asset('storage/uploads/surat_masuk/' . $suratMasuk->file_surat) }}"
                            target="_blank" class="btn btn-primary"><i class="bi bi-eye me-2"></i>Lihat File</a></p>
                @endif
            </div>
            <div class="card-footer">
                <a href="{{ route('subkeg-lain.surat-masuk.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </main>
@endsection

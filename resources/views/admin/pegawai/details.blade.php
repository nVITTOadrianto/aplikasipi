@extends('admin.layouts.app')

@section('content')
    <main class="container py-4">
        <h1 class="mb-4 fw-bold">Detail Data Pegawai</h1>
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title fw-bold">{{ $pegawai->nama }}</h5>
                @if ($pegawai->nip)
                    <h6 class="card-subtitle mb-3">NIP. {{ $pegawai->nip }}</h6>
                @endif
                <p class="card-text"><strong></strong> </p>
                <p class="card-text"><strong>Tempat, Tanggal Lahir:</strong>
                    {{ $pegawai->tempat_lahir . ', ' . $pegawai->tanggal_lahir->isoFormat('D MMMM YYYY') }}
                </p>
                @if ($pegawai->golongan && $pegawai->ruang && $pegawai->pangkat)
                    <p class="card-text"><strong>Golongan:</strong> {{ $pegawai->golongan }}/{{ $pegawai->ruang }}</p>
                    <p class="card-text"><strong>Pangkat:</strong> {{ $pegawai->pangkat }}</p>
                @endif
                <p class="card-text"><strong>Jabatan:</strong> {{ $pegawai->jabatan }}</p>
            </div>
            <div class="card-footer">
                <a href="{{ route('pegawai.index') }}" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </main>
@endsection

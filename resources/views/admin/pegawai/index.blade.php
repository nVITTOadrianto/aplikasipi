@extends('admin.layouts.app')

@section('content')
    <main class="container py-4">
        <h1 class="mb-4 fw-bold">Pegawai</h1>
        @session('success')
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endsession
        <div class="mb-3">
            <a href="{{ route('pegawai.create') }}" class="btn btn-success me-2">
                <i class="bi bi-plus-circle"></i> Tambah Data Pegawai
            </a>
            <a href="{{ route('pegawai.export') }}" class="btn btn-primary">
                <i class="bi bi-file-spreadsheet"></i> Ekspor Data Pegawai sebagai Excel
            </a>
        </div>
        <div class="card mb-4">
            <div class="card-body">
                <form action="{{ route('pegawai.index') }}" method="GET">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="search" class="form-label">Cari (Nama/Jabatan)</label>
                                <input type="text" class="form-control" id="search" name="search" value="{{ $search ?? '' }}">
                            </div>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="{{ route('pegawai.index') }}" class="btn btn-secondary">Reset</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <table class="table table-striped mt-3">
            <thead>
                <tr scope="col">
                    <th>No</th>
                    <th>Nama/NIP</th>
                    <th>Pangkat/Golongan</th>
                    <th>Jabatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pegawaiPegawai as $pegawai)
                    <tr>
                        <td scope="col">{{ $loop->iteration }}</td>
                        <td>
                            {{ $pegawai->nama }}
                            @if($pegawai->nip)
                                <br>NIP. {{ $pegawai->nip }}
                            @endif
                        </td>
                        <td>@if($pegawai->pangkat || $pegawai->golongan || $pegawai->ruang)
                                {{$pegawai->pangkat}}<br>{{$pegawai->golongan}}/{{$pegawai->ruang}}
                            @else
                                {{'-'}}
                            @endif
                        </td>
                        <td>{{$pegawai->jabatan}}</td>
                        <td class="align-middle">
                            <div class="d-flex gap-1">
                                <a href="{{ route('pegawai.show', $pegawai->id) }}" class="btn btn-info btn-sm">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('pegawai.edit', $pegawai->id) }}" class="btn btn-warning btn-sm">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('pegawai.destroy', $pegawai->id) }}" method="POST"
                                    class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus data pegawai ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $pegawaiPegawai->appends(request()->query())->links() }}
        </div>
    </main>
@endsection

@extends('layouts.app')

@section('content')
<div class="card" style="width: 30rem; margin: 150px auto; padding: 20px;">
    <div class="card-body">
        <a href="{{ route('home') }}">< Kembali</a>
        <img src="{{ asset('logo_pi.png') }}" alt="Logo Pemberdayaan Industri" class="img-fluid mx-auto d-block mb-4" style="width: 100px; height: auto;">
        <h1 class="card-title text-center fw-semibold">Login</h1>
        @error('loginError')
        <div class="alert alert-danger" role="alert">
            {{ $message }}
        </div>
        @enderror

        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" id="email"
                    name="email" required autofocus>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password"
                    name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>
</div>
@endsection

@extends('admin.layouts.app')

@section('content')
    <main class="container py-4">
        <h1 class="mb-4 fw-bold">Ubah Password</h1>
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
        <form action="{{ route('change-password.update') }}" method="post">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="current_password" class="form-label">Password Lama<span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="password" class="form-control" id="current_password" name="current_password" required>
                    <button class="btn btn-outline-secondary" type="button" id="toggleCurrentPassword" tabindex="-1">
                        <i class="bi bi-eye" id="toggleCurrentPasswordIcon"></i>
                    </button>
                </div>
            </div>
            <div class="mb-3">
                <label for="new_password" class="form-label">Password Baru<span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="password" class="form-control" id="new_password" name="new_password" required>
                    <button class="btn btn-outline-secondary" type="button" id="toggleNewPassword" tabindex="-1">
                        <i class="bi bi-eye" id="toggleNewPasswordIcon"></i>
                    </button>
                </div>
                <div class="form-text">Password baru wajib minimal 6 karakter</div>
            </div>
            <div class="mb-3">
                <label for="confirm_new_password" class="form-label">Konfirmasi Password Baru<span
                        class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="password" class="form-control" id="confirm_new_password" name="confirm_new_password"
                        required>
                    <button class="btn btn-outline-secondary" type="button" id="toggleConfirmNewPassword" tabindex="-1">
                        <i class="bi bi-eye" id="toggleConfirmNewPasswordIcon"></i>
                    </button>
                </div>
            </div>
            <div class="mb-3">
                <p class="text-danger">*wajib diisi</p>
            </div>
            <button type="submit" class="btn btn-success">Ubah Password</button>
            <a href="{{ route('profile') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </main>
    <script>
        document.getElementById('toggleCurrentPassword').addEventListener('click', function() {
            const currentPasswordInput = document.getElementById('current_password');
            const currentPasswordIcon = document.getElementById('toggleCurrentPasswordIcon');

            if (currentPasswordInput.type === 'password') {
                currentPasswordInput.type = 'text';
                currentPasswordIcon.classList.remove('bi-eye');
                currentPasswordIcon.classList.add('bi-eye-slash');
            } else {
                currentPasswordInput.type = 'password';
                currentPasswordIcon.classList.remove('bi-eye-slash');
                currentPasswordIcon.classList.add('bi-eye');
            }
        });

        document.getElementById('toggleNewPassword').addEventListener('click', function() {
            const newPasswordInput = document.getElementById('new_password');
            const newPasswordIcon = document.getElementById('toggleNewPasswordIcon');

            if (newPasswordInput.type === 'password') {
                newPasswordInput.type = 'text';
                newPasswordIcon.classList.remove('bi-eye');
                newPasswordIcon.classList.add('bi-eye-slash');
            } else {
                newPasswordInput.type = 'password';
                newPasswordIcon.classList.remove('bi-eye-slash');
                newPasswordIcon.classList.add('bi-eye');
            }
        });

        document.getElementById('toggleConfirmNewPassword').addEventListener('click', function() {
            const confirmNewPasswordInput = document.getElementById('confirm_new_password');
            const confirmNewPasswordIcon = document.getElementById('toggleConfirmNewPasswordIcon');

            if (confirmNewPasswordInput.type === 'password') {
                confirmNewPasswordInput.type = 'text';
                confirmNewPasswordIcon.classList.remove('bi-eye');
                confirmNewPasswordIcon.classList.add('bi-eye-slash');
            } else {
                confirmNewPasswordInput.type = 'password';
                confirmNewPasswordIcon.classList.remove('bi-eye-slash');
                confirmNewPasswordIcon.classList.add('bi-eye');
            }
        });
    </script>
@endsection

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SuratKeluar;
use App\Models\SuratMasuk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $suratMasukCount = SuratMasuk::count();
        $suratKeluarCount = SuratKeluar::count();
        return view('admin.dashboard', compact('suratMasukCount', 'suratKeluarCount'));
    }

    public function indexProfile() {
        $user = auth()->user();
        return view('admin.profile', compact('user'));
    }

    public function updateProfile() {
        $user = User::find(auth()->user()->id);

        // Validasi input
        request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'required',
            'password_baru' => 'nullable|min:6|confirmed',
        ]);

        // Cek password lama
        if (!Hash::check(request('password'), $user->password)) {
            return back()->withErrors(['password' => 'Password lama salah']);
        }

        $data = [
            'name' => request('name'),
            'email' => request('email'),
        ];

        // Jika password baru diisi, update password
        if (request('new_password')) {
            $data['password'] = Hash::make(request('new_password'));
        }

        if (request('new_password') != request('confirm_new_password')) {
            return back()->withErrors(['password' => 'Password baru dan konfirmasi password baru tidak sama']);
        }

        $user->update($data);
        return redirect()->route('profile')->with('success', "Profil berhasil diperbarui");
    }
}
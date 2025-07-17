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
        $suratMasuk1Count = SuratMasuk::where('tanggal_diterima', date('Y-m-d'))->where('sub_kegiatan', 'Koordinasi, Sinkronisasi, dan Pelaksanaan Pemberdayaan Industri dan Peran Serta Masyarakat')->count();
        $suratKeluar1Count = SuratKeluar::where('tanggal_surat', date('Y-m-d'))->where('sub_kegiatan', 'Koordinasi, Sinkronisasi, dan Pelaksanaan Pemberdayaan Industri dan Peran Serta Masyarakat')->count();
        $suratMasukLainCount = SuratMasuk::where('tanggal_diterima', date('Y-m-d'))->where('sub_kegiatan', 'Lain-Lain')->count();
        $suratKeluarLainCount = SuratKeluar::where('tanggal_surat', date('Y-m-d'))->where('sub_kegiatan', 'Lain-Lain')->count();
        $suratMasukTotal = $suratMasuk1Count + $suratMasukLainCount;
        $suratKeluarTotal = $suratKeluar1Count + $suratKeluarLainCount;
        return view('admin.dashboard', compact('suratMasuk1Count', 'suratKeluar1Count', 'suratMasukLainCount', 'suratKeluarLainCount', 'suratMasukTotal', 'suratKeluarTotal'));
    }

    public function indexProfile() {
        $user = auth()->user();
        return view('admin.profile', compact('user'));
    }

    public function updateProfile(Request $request) {
        $user = User::find(auth()->user()->id);

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => request('name'),
            'email' => request('email'),
        ]);
        return redirect()->route('profile')->with('success', "Profil berhasil diperbarui");
    }

    public function indexPassword() {
        return view('admin.change-password');
    }

    public function updatePassword(Request $request) {
        $user = User::find(auth()->user()->id);

        // Cek password lama
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password.same' => 'Password lama salah']);
        }

        // Validasi input
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_new_password' => 'required|same:new_password',
        ], [
            'current_password.required' => 'Password lama harus diisi',
            'new_password.required' => 'Password baru harus diisi',
            'new_password.min' => 'Password baru harus terdiri dari minimal 6 karakter',
            'confirm_new_password.required' => 'Konfirmasi password baru harus diisi',
            'confirm_new_password.same' => 'Konfirmasi password baru tidak sama dengan password baru',
        ]);

        // Update password baru
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('profile')->with('success', 'Password berhasil diperbarui');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    //
    public function index() {
        return view('login');
    }

    public function authenticate(Request $request) {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'loginError' => 'Username atau password salah. Sialakan coba lagi.',
        ]);
    }

    public function logout() {
        auth()->logout();
        return redirect()->route('home');
    }
}

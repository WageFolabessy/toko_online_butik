<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        return view('user.auth.login');
    }

    public function store(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            throw ValidationException::withMessages(['email' => 'Email atau password yang Anda masukkan salah.']);
        }

        if (Auth::user()->role !== 'customer') {
            Auth::logout();
            throw ValidationException::withMessages(['email' => 'Akun ini tidak memiliki akses sebagai pelanggan.']);
        }

        $request->session()->regenerate();
        return redirect()->intended(route('home'));
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}

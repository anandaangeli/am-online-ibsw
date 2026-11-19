<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        if (!$request->has('username') && $request->has('email')) {
            $request->merge(['username' => $request->input('email')]);
        }

        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'NIK atau Email wajib diisi',
            'password.required' => 'Password wajib diisi',
        ]);

        $input = trim($request->input('username'));
        $password = $request->input('password');

        $user = User::where('nik', $input)
                    ->orWhere('email', $input)
                    ->first();

        if ($user && Hash::check($password, $user->password)) {
            Auth::login($user, $request->has('remember'));
            $request->session()->regenerate();

            return redirect()->intended(route('dashboard'))
                             ->with('success', 'Selamat datang kembali, ' . $user->name);
        }

        return back()->withErrors([
            'login_error' => 'NIK / Email atau Password salah. Silakan periksa kembali.',
        ])->withInput($request->only('username'));
    }

    public function apiLogin(Request $request)
    {
        if (!$request->has('username') && $request->has('email')) {
            $request->merge(['username' => $request->input('email')]);
        }

        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $input = trim($request->input('username'));
        $password = $request->input('password');

        $user = User::where('nik', $input)
                    ->orWhere('email', $input)
                    ->first();

        if ($user && Hash::check($password, $user->password)) {
            return response()->json([
                'status' => true,
                'message' => 'Login berhasil',
                'data' => [
                    'nik' => $user->nik,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'division' => $user->division,
                    'position' => $user->position,
                ]
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'NIK / Email atau Password tidak valid'
        ], 401);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('info', 'Anda telah keluar dari sistem.');
    }
}

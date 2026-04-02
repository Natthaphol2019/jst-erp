<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];

        \Log::info('=== Login Attempt ===');
        \Log::info('Username: ' . $request->username);

        // Check if user exists
        $user = \App\Models\User::where('username', $request->username)->first();
        \Log::info('User found: ' . ($user ? 'Yes' : 'No'));

        if ($user) {
            \Log::info('Password check: ' . (password_verify($request->password, $user->password) ? 'true' : 'false'));
        }

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            \Log::info('Auth attempt: SUCCESS');
            $request->session()->regenerate();

            $user = Auth::user();
            \Log::info('User role: ' . $user->role);

            // 🌟 Redirect วิ่งไปตาม Role ที่ตั้งไว้ใน routes/web.php
            return match ($user->role) {
                'admin' => redirect()->route('admin.dashboard'),
                'manager' => redirect()->route('manager.dashboard'),
                'employee' => redirect()->route('employee.dashboard'),
                'hr' => redirect()->route('hr.dashboard'), // 👈 ชี้มาที่ Dashboard ของ HR
                'inventory' => redirect()->route('inventory.dashboard'), // 👈 ชี้มาที่ Dashboard ของคลัง
                default => redirect('/'),
            };
        }

        \Log::info('Auth attempt: FAILED');
        return back()->withErrors([
            'username' => 'ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
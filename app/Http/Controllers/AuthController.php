<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            // dd(Auth::user()->name); // Hiển thị thông tin chi tiết tài khoản đăng nhập
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['email' => 'Thông tin đăng nhập không chính xác']);
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed'
        ]);

        // dd($data);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => User::ROLE_USER
        ]);

        if ($user) {
            // use App\Mail\WelcomeMail;
            // use Illuminate\Support\Facades\Mail;
            // Mail::to($user->email)->send(new WelcomeMail($user));

            // Nếu sử sử dụng queue ta cần chạy song song 2 câu lệnh
            // php artisan ser và php artisan queue:work
            Mail::to($user->email)->queue(new WelcomeMail($user));
        }

        Auth::login($user);

        return redirect()->route('admin.dashboard');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('showLogin');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            return redirect()->route('cabinet');
        }

        return back()->withErrors(['email' => 'Неверные учетные данные']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}


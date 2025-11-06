<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // tu vista
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/admin');
        }

        return back()->withErrors([
            'username' => 'Credenciales incorrectas',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/login');
    }
}

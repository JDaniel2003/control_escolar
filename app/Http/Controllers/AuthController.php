<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Mostrar formulario de login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Procesar login
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            
            // Redirigir según el nivel
            return $this->redirectBasedOnLevel($user);
        }

        return back()->withErrors([
            'username' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('username');
    }

    // Redirección basada en nivel
    protected function redirectBasedOnLevel($user)
    {
        if (!$user->rol) {
            return redirect()->route('dashboard')->with('warning', 'No tienes un rol asignado');
        }

        $nivel = $user->getNivel();

        // Redirigir según el nivel jerárquico
        if ($nivel >= 5) {
            return redirect()->route('superadmin.dashboard');
        } elseif ($nivel >= 4) {
            return redirect()->route('admin.dashboard');
        } elseif ($nivel >= 3) {
            return redirect()->route('coordinador.dashboard');
        } elseif ($nivel >= 2) {
            return redirect()->route('docente.dashboard');
        } else {
            return redirect()->route('estudiante.dashboard');
        }
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
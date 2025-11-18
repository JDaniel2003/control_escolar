<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;

class AdminController extends Controller
{
    // Dashboard para SuperAdmin
    public function superDashboard()
    {
        return view('admin.super-dashboard');
    }

    // Dashboard para Admin
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    // Gestión de usuarios
    public function usuarios()
    {
        // Solo puede ver usuarios de nivel inferior
        $usuarios = Usuario::with('rol')
            ->whereHas('rol', function($q) {
                $q->where('nivel', '<', auth()->user()->getNivel());
            })
            ->get();

        return view('admin.usuarios', compact('usuarios'));
    }

    // Reportes
    public function reportes()
    {
        return view('admin.reportes');
    }

    // Configuración
    public function configuracion()
    {
        return view('admin.configuracion');
    }

    // Sistema (solo SuperAdmin)
    public function sistema()
    {
        return view('admin.sistema');
    }

    // Gestión de roles
    public function roles()
    {
        return view('admin.roles');
    }
}
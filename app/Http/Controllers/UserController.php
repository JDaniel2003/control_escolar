<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::with('rol')->get();
        $roles = Rol::all();
        
        return view('usuario.index', compact('usuarios', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:50|unique:usuarios,username',
            'password' => 'required|string|min:8|confirmed',
            'id_rol' => 'required|exists:roles,id_rol'
        ]);

        try {
            Usuario::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'id_rol' => $request->id_rol,
            ]);

            return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al crear el usuario: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        // Cambio de contraseña
        if ($request->has('change_password')) {
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);

            $usuario->update([
                'password' => Hash::make($request->password),
            ]);

            return redirect()->route('usuarios.index')->with('success', 'Contraseña actualizada exitosamente.');
        }

        // Actualización normal (sin email)
        $request->validate([
            'username' => 'required|string|max:50|unique:usuarios,username,' . $id . ',id_usuario',
            'id_rol' => 'required|exists:roles,id_rol',
        ]);

        try {
            $usuario->update([
                'username' => $request->username,
                'id_rol' => $request->id_rol,
            ]);

            return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar el usuario: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $usuario = Usuario::findOrFail($id);

            // Verificar si está asociado a un docente
            if ($usuario->docente) {
                return redirect()->route('usuarios.index')->with('error', 'No se puede eliminar el usuario porque está asociado a un docente.');
            }

            $usuario->delete();

            return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado exitosamente.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar el usuario: ' . $e->getMessage());
        }
    }
}
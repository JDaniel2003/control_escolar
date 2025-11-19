<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rol;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

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
        $validated = $request->validate([
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'id_rol' => 'required|exists:rols,id_rol',
            'activo' => 'required|boolean'
        ]);

        try {
            Usuario::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'id_rol' => $request->id_rol,
                'activo' => $request->activo
            ]);

            return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al crear el usuario: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        // Si es cambio de contraseña
        if ($request->has('change_password')) {
            $validated = $request->validate([
                'password' => 'required|min:8|confirmed'
            ]);

            $user->update([
                'password' => Hash::make($request->password)
            ]);

            return redirect()->route('usuarios.index')->with('success', 'Contraseña actualizada exitosamente');
        }

        // Si es actualización normal
        $validated = $request->validate([
            'username' => 'required|unique:users,username,' . $id . ',id_usuario',
            'email' => 'required|email|unique:users,email,' . $id . ',id_usuario',
            'id_rol' => 'required|exists:rols,id_rol',
            'activo' => 'required|boolean'
        ]);

        try {
            $user->update($validated);
            return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al actualizar el usuario: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            
            // Verificar si el usuario está asociado a algún docente
            if ($user->docente) {
                return redirect()->route('usuarios.index')->with('error', 'No se puede eliminar el usuario porque está asociado a un docente');
            }
            
            $user->delete();
            return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al eliminar el usuario: ' . $e->getMessage());
        }
    }
}
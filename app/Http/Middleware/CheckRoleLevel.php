<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRoleLevel
{
    // Definir jerarquía de niveles
    protected $roleLevels = [
        'SuperAdmin' => 5,
        'Administrador' => 4,
        'Coordinador' => 3,
        'Docente' => 2,
        'Estudiante' => 1,
    ];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $minLevel): Response
    {
        // Verificar si el usuario está autenticado
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Verificar si el usuario tiene un rol asignado
        if (!$user->rol) {
            abort(403, 'No tienes un rol asignado.');
        }

        // Obtener el nivel del usuario
        $userLevel = $this->roleLevels[$user->rol->nombre] ?? 0;
        $requiredLevel = (int) $minLevel;

        // Verificar si el nivel del usuario es suficiente
        if ($userLevel >= $requiredLevel) {
            return $next($request);
        }

        // Si no tiene el nivel requerido, mostrar error 403
        abort(403, 'No tienes el nivel de acceso requerido para esta sección.');
    }

    /**
     * Obtener el nivel del rol actual (método estático útil)
     */
    public static function getUserLevel()
    {
        $levels = [
            'SuperAdmin' => 5,
            'Administrador' => 4,
            'Coordinador' => 3,
            'Docente' => 2,
            'Estudiante' => 1,
        ];

        $user = auth()->user();
        return $user && $user->rol ? ($levels[$user->rol->nombre] ?? 0) : 0;
    }
}
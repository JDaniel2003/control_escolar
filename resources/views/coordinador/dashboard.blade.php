<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Coordinador</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-600 text-white p-4">
        <div class="container mx-auto flex justify-between">
            <h1 class="text-xl font-bold">Panel de Coordinador</h1>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="bg-red-500 px-4 py-2 rounded">Cerrar Sesión</button>
            </form>
        </div>
    </nav>
    <div class="container mx-auto mt-8 p-4">
        <h2 class="text-2xl mb-4">Bienvenido Coordinador</h2>
        <p>Usuario: {{ auth()->user()->username }}</p>
        <p>Nivel: {{ auth()->user()->getNivel() }}</p>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Locadora</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
</head>

<body class="flex h-screen bg-gray-900 text-gray-100">
    <aside class="w-64 bg-gray-800 p-6 flex flex-col gap-6 shadow-lg">
        <h2 class="text-2xl font-bold text-white">Locadora</h2>
        <nav class="flex flex-col gap-3">
            <a href="{{ route('equipments.index') }}" class="text-gray-300 hover:text-white transition">Equipamentos</a>
            <a href="{{ route('rentals.index') }}" class="text-gray-300 hover:text-white transition">Pedidos</a>
        </nav>
    </aside>
    <main class="flex-1 p-8 overflow-y-auto">
        @yield('content')
    </main>

    @yield('scripts')
</body>

</html>

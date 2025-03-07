<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AquariumPartPicker</title>

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    @livewireStyles
</head>
<body class="antialiased">
    <header class="bg-blue-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">AquariumPartPicker</h1>
            <nav>
                <ul class="flex space-x-4">
                    <li><a href="/" class="hover:underline">Home</a></li>
                    <li><a href="/browse" class="hover:underline">Browse Parts</a></li>
                    <li><a href="/builds" class="hover:underline">Saved Builds</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container mx-auto p-4">
        {{ $slot }}
    </main>

    <footer class="bg-gray-800 text-white p-4 mt-8">
        <div class="container mx-auto">
            <p>&copy; {{ date('Y') }} AquariumPartPicker</p>
        </div>
    </footer>

    @livewireScripts
</body>
</html>

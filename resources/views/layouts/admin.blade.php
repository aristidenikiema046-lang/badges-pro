<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - YA Consulting</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 antialiased min-h-screen flex flex-col">

    <main class="flex-grow w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    <footer class="text-center p-6 text-[10px] text-gray-400 uppercase font-bold tracking-widest">
        YA Consulting - Administration &copy; {{ date('Y') }}
    </footer>

</body>
</html>
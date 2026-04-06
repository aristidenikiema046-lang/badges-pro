<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - YA Consulting</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .bg-waves {
            background-image: url('https://www.transparenttextures.com/patterns/cubes.png');
            background-color: #f3f4f6;
        }
    </style>
</head>
<body class="bg-waves min-h-screen flex flex-col justify-between font-sans text-center">

    <main class="flex-grow flex flex-col items-center justify-center px-4">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-12 uppercase">
            Bienvenue sur la plateforme d'enregistrement de <span class="text-emerald-600">YA CONSULTING</span>
        </h1>

        <div class="flex flex-col md:flex-row gap-6">
            <a href="{{ route('companies.create') }}" 
               class="flex items-center justify-center bg-orange-500 hover:bg-orange-600 text-white font-bold py-4 px-8 rounded-lg shadow-lg transition min-w-[320px] transform hover:scale-105">
                <span class="mr-2 text-xl">👤+</span> ENREGISTRER LES INFOS ENTREPRISE
            </a>

            <a href="{{ route('companies.index') }}" 
               class="flex items-center justify-center bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-4 px-8 rounded-lg shadow-lg transition min-w-[320px] transform hover:scale-105">
                <span class="mr-2 text-xl">⚙️</span> GÉRER LES ENTREPRISES
            </a>
        </div>
    </main>

    <footer class="bg-slate-900 text-white py-6 text-sm">
        <p>&copy; 2026 <span class="text-emerald-500 font-bold uppercase">YA Consulting</span>. Tous droits réservés.</p>
    </footer>
</body>
</html>
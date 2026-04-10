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

    <main class="flex-grow flex flex-col items-center justify-center px-4 py-10">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-12 uppercase">
            Plateforme d'enregistrement <span class="text-emerald-600">YA CONSULTING</span>
        </h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-5xl w-full">
            
            <div class="bg-white p-8 rounded-2xl shadow-xl border-t-4 border-orange-500">
                <h2 class="text-xl font-bold text-gray-700 mb-6 uppercase">Espace Entreprises</h2>
                <div class="flex flex-col gap-4">
                    @auth
                        @if(!auth()->user()->isAdmin())
                            <a href="{{ route('company.employees', ['slug' => auth()->user()->company->slug]) }}" 
                               class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-4 px-6 rounded-lg transition transform hover:scale-105 shadow-md">
                                📊 ACCÉDER À MON DASHBOARD
                            </a>
                        @else
                            <p class="text-sm text-gray-500 italic">Connecté en tant qu'Administrateur</p>
                        @endif
                    @else
                        <a href="{{ route('companies.create') }}" 
                           class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-4 px-6 rounded-lg transition transform hover:scale-105 shadow-md">
                            👤+ ENREGISTRER MON ENTREPRISE
                        </a>
                        <a href="{{ route('login') }}" 
                           class="border-2 border-orange-500 text-orange-600 hover:bg-orange-50 font-bold py-4 px-6 rounded-lg transition shadow-sm">
                            🔑 CONNEXION ENTREPRISE
                        </a>
                    @endauth
                </div>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow-xl border-t-4 border-emerald-500">
                <h2 class="text-xl font-bold text-gray-700 mb-6 uppercase">Administration centrale</h2>
                <div class="flex flex-col gap-4">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('companies.index') }}" 
                               class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-4 px-6 rounded-lg transition transform hover:scale-105 shadow-md">
                                ⚙️ GÉRER LA PLATEFORME
                            </a>
                        @else
                            <p class="text-sm text-gray-500 italic">Connecté en tant qu'Entreprise</p>
                        @endif
                    @else
                        <a href="{{ route('login') }}" 
                           class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-4 px-6 rounded-lg transition transform hover:scale-105 shadow-md">
                            🛡️ CONNEXION SUPER ADMIN
                        </a>
                        <p class="text-xs text-gray-400 mt-2">Accès réservé au personnel de YA Consulting</p>
                    @endauth
                </div>
            </div>

        </div>

        @auth
            <div class="mt-10">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-red-500 hover:underline font-medium">
                        Déconnexion
                    </button>
                </form>
            </div>
        @endauth
    </main>

    <footer class="bg-slate-900 text-white py-6 text-sm">
        <p>&copy; 2026 <span class="text-emerald-500 font-bold uppercase">YA Consulting</span>. Tous droits réservés.</p>
    </footer>
</body>
</html>
<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - YA Consulting</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .bg-waves {
            background-image: url('https://www.transparenttextures.com/patterns/cubes.png');
            background-color: #f8fafc;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="bg-waves min-h-screen flex flex-col font-sans text-center">

    <main class="flex-grow flex flex-col items-center justify-center px-4 py-12 md:py-16 w-full max-w-7xl mx-auto">
        <header class="mb-12 md:mb-16">
            <h1 class="text-3xl md:text-5xl font-black text-slate-800 mb-4 tracking-tighter uppercase italic">
                Plateforme <span class="text-emerald-600">YA CONSULTING</span>
            </h1>
            <div class="h-1 w-20 md:w-32 bg-emerald-500 mx-auto rounded-full"></div>
            <p class="mt-4 text-slate-500 font-medium uppercase tracking-widest text-[10px] md:text-xs">
                Gestion & Enregistrement des Badges Professionnels
            </p>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-10 w-full max-w-5xl">
            
            {{-- Section Entreprises --}}
            <div class="glass-card p-6 md:p-10 rounded-3xl shadow-2xl border-b-8 border-orange-500 transition-all hover:-translate-y-1">
                <div class="w-14 h-14 md:w-16 md:h-16 bg-orange-100 text-orange-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-inner">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 md:h-8 md:w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-10V4m-5 10v4" />
                    </svg>
                </div>
                <h2 class="text-xl md:text-2xl font-black text-slate-800 mb-6 md:mb-8 uppercase italic tracking-tight">Espace Entreprises</h2>
                
                <div class="flex flex-col gap-3 md:gap-4">
                    @auth
                        @if(auth()->user()->company)
                            <a href="{{ route('company.employees', ['slug' => auth()->user()->company->slug]) }}" 
                               class="w-full inline-flex items-center justify-center bg-gradient-to-br from-orange-500 to-orange-600 text-white font-black py-4 md:py-5 px-6 rounded-2xl transition-all hover:shadow-lg active:scale-95">
                                📊 ACCÉDER AU DASHBOARD
                            </a>
                        @else
                            <div class="p-4 bg-slate-100 rounded-xl border border-slate-200">
                                <p class="text-xs text-slate-500 font-bold uppercase italic">Connecté : Administrateur</p>
                            </div>
                        @endif
                    @else
                        <a href="{{ route('companies.create') }}" 
                           class="w-full bg-slate-900 hover:bg-black text-white font-black py-4 md:py-5 px-6 rounded-2xl transition-all shadow-lg active:scale-95 text-sm md:text-base">
                           👤+ ENREGISTRER MON ENTREPRISE
                        </a>
                        <a href="{{ route('login') }}" 
                           class="w-full border-2 border-orange-500 text-orange-600 hover:bg-orange-500 hover:text-white font-black py-4 md:py-5 px-6 rounded-2xl transition-all active:scale-95 uppercase tracking-widest text-xs md:text-sm">
                           🔑 Connexion Partenaire
                        </a>
                    @endauth
                </div>
            </div>

            {{-- Administration Centrale --}}
            <div class="glass-card p-6 md:p-10 rounded-3xl shadow-2xl border-b-8 border-emerald-500 transition-all hover:-translate-y-1">
                <div class="w-14 h-14 md:w-16 md:h-16 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-inner">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 md:h-8 md:w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <h2 class="text-xl md:text-2xl font-black text-slate-800 mb-6 md:mb-8 uppercase italic tracking-tight">Admin Centrale</h2>
                
                <div class="flex flex-col gap-3 md:gap-4">
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('companies.index') }}" 
                               class="w-full bg-gradient-to-br from-emerald-600 to-teal-700 text-white font-black py-4 md:py-5 px-6 rounded-2xl transition-all hover:shadow-lg active:scale-95 flex items-center justify-center gap-2">
                                ⚙️ GÉRER LA PLATEFORME
                            </a>
                        @else
                            <div class="p-4 bg-slate-100 rounded-xl border border-slate-200">
                                <p class="text-xs text-slate-500 font-bold uppercase italic">Connecté : Entreprise</p>
                            </div>
                        @endif
                    @else
                        <a href="{{ route('login') }}" 
                           class="w-full bg-gradient-to-br from-emerald-600 to-teal-700 text-white font-black py-4 md:py-5 px-6 rounded-2xl transition-all hover:shadow-lg active:scale-95 text-sm md:text-base">
                           🛡️ CONNEXION SUPER ADMIN
                        </a>
                        <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest mt-2">Accès restreint au personnel habilité</p>
                    @endauth
                </div>
            </div>
        </div>

        @auth
            <div class="mt-12">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-2 text-slate-400 hover:text-red-500 transition-colors font-bold uppercase text-[10px] tracking-widest">
                        Se déconnecter de la session
                    </button>
                </form>
            </div>
        @endauth
    </main>

    <footer class="bg-slate-900 text-white py-8 text-[10px] md:text-sm border-t-4 border-emerald-500">
        <div class="max-w-5xl mx-auto px-4 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="font-medium opacity-80">&copy; {{ date('Y') }} <span class="text-emerald-500 font-black uppercase italic">YA Consulting</span>.</p>
            <div class="flex gap-4 md:gap-6 font-black uppercase tracking-widest opacity-50">
                <a href="#" class="hover:text-emerald-400 transition-colors">Confidentialité</a>
                <a href="#" class="hover:text-emerald-400 transition-colors">Support</a>
            </div>
        </div>
    </footer>
</body>
</html>
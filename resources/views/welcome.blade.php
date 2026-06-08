<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - Badges Pro Platform</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .bg-dark-waves {
            background-image: url('https://www.transparenttextures.com/patterns/cubes.png');
            background-color: #0f172a; /* Slate 900 */
        }
        .glass-card {
            background: rgba(30, 41, 59, 0.45); /* Slate 800/45 */
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }
    </style>
</head>
<body class="bg-dark-waves min-h-screen flex flex-col font-sans text-slate-200 antialiased relative overflow-x-hidden">

    <div class="absolute top-[-10%] left-[-10%] w-[50vw] h-[50vw] bg-emerald-500/10 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-[10%] right-[-10%] w-[45vw] h-[45vw] bg-orange-500/10 rounded-full blur-[120px] pointer-events-none"></div>

    <nav class="w-full max-w-7xl mx-auto px-6 py-6 flex justify-between items-center relative z-20">
        <div class="text-xs font-black tracking-widest uppercase italic text-slate-400">
            YA CONSULTING
        </div>
        
        <div class="flex items-center gap-4">
            @auth
                <a href="{{ auth()->user()->role === 'admin' ? route('companies.index') : (auth()->user()->company ? route('company.employees', ['slug' => auth()->user()->company->slug]) : '#') }}" 
                   class="px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white font-black text-xs uppercase tracking-wider rounded-xl transition-all active:scale-95 shadow-lg shadow-emerald-500/20">
                    📊 Mon Espace
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="px-3 py-2 text-slate-400 hover:text-red-400 font-bold text-xs uppercase tracking-wider transition-colors">
                        Déconnexion
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="px-4 py-2 text-slate-300 hover:text-white font-black text-xs uppercase tracking-wider transition-colors">
                    🔑 Connexion
                </a>
                <a href="{{ route('companies.create') }}" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-white border border-slate-700 font-black text-xs uppercase tracking-wider rounded-xl transition-all active:scale-95">
                    👤 S'enregistrer
                </a>
            @endauth
        </div>
    </nav>

    <main class="flex-grow flex flex-col items-center justify-center px-6 py-8 w-full max-w-4xl mx-auto relative z-10 text-center my-auto">
        
        <header class="mb-10 max-w-2xl">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-[10px] font-bold tracking-widest uppercase mb-4 shadow-sm">
                ⚡ Badges Pro Platform v1.0
            </div>
            <h1 class="text-4xl md:text-6xl font-black text-white mb-4 tracking-tighter uppercase italic leading-none">
                PLATEFORME <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-emerald-400">BADGES PRO</span>
            </h1>
            <div class="h-1 w-24 bg-gradient-to-r from-orange-500 to-emerald-500 mx-auto rounded-full mb-4"></div>
            <p class="text-slate-400 font-medium uppercase tracking-widest text-[10px] md:text-xs max-w-md mx-auto leading-relaxed">
                Système centralisé de gestion, de configuration et d'enregistrement des accès professionnels.
            </p>
        </header>

        <div class="w-full max-w-xl">
            <div class="glass-card p-8 md:p-10 rounded-[2.5rem] border border-slate-700/40 shadow-2xl transition-all duration-300 hover:border-emerald-500/30 group">
                <div class="w-14 h-14 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-inner">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-10V4m-5 10v4" />
                    </svg>
                </div>
                
                <h2 class="text-xl md:text-2xl font-black text-white mb-3 uppercase italic tracking-tight">Accès au Portail</h2>
                <p class="text-slate-400 text-xs md:text-sm mb-8 max-w-xs mx-auto leading-relaxed">
                    Pilotez vos effectifs, configurez vos visuels de badges et gérez vos autorisations sur une interface unique.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    @auth
                        <a href="{{ auth()->user()->role === 'admin' ? route('companies.index') : (auth()->user()->company ? route('company.employees', ['slug' => auth()->user()->company->slug]) : '#') }}" 
                           class="w-full inline-flex items-center justify-center bg-gradient-to-r from-orange-500 to-emerald-500 hover:from-orange-600 hover:to-emerald-600 text-white font-black py-4 px-6 rounded-2xl transition-all shadow-lg active:scale-[0.98] uppercase tracking-widest text-xs border border-white/10">
                            📊 Accéder à mon Tableau de bord
                        </a>
                    @else
                        <a href="{{ route('login') }}" 
                           class="w-full bg-gradient-to-r from-orange-500 to-emerald-500 hover:from-orange-600 hover:to-emerald-600 text-white font-black py-4 px-6 rounded-2xl transition-all shadow-lg shadow-emerald-500/5 active:scale-[0.98] text-center uppercase tracking-widest text-xs border border-white/10">
                            🔑 Entrer sur la plateforme
                        </a>
                    @endauth
                </div>
            </div>
        </div>

    </main>

    <footer class="bg-slate-950/60 border-t border-slate-800 text-slate-500 py-6 text-xs relative z-10 mt-auto">
        <div class="max-w-5xl mx-auto px-6 flex flex-col sm:flex-row justify-between items-center gap-4">
            <p class="font-medium">&copy; {{ date('Y') }} <span class="text-slate-300 font-bold uppercase tracking-wider">YA Consulting</span>. Tous droits réservés.</p>
            <div class="flex gap-6 font-bold uppercase tracking-widest text-[10px]">
                <a href="#" class="text-slate-400 hover:text-emerald-400 transition-colors">Confidentialité</a>
                <a href="#" class="text-slate-400 hover:text-emerald-400 transition-colors">Support Technique</a>
            </div>
        </div>
    </footer>
</body>
</html>
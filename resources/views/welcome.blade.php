<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil - YA Consulting Badges</title>
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

    <main class="flex-grow flex flex-col items-center justify-center px-6 py-16 md:py-24 w-full max-w-7xl mx-auto relative z-10">
        
        <header class="text-center mb-16 md:mb-24 max-w-2xl">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-[10px] font-bold tracking-widest uppercase mb-6 shadow-sm">
                ⚡ Badges Pro Platform v1.0
            </div>
            <h1 class="text-4xl md:text-6xl font-black text-white mb-6 tracking-tighter uppercase italic leading-none">
                PLATEFORME <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-emerald-400">YA CONSULTING</span>
            </h1>
            <div class="h-1 w-24 bg-gradient-to-r from-orange-500 to-emerald-500 mx-auto rounded-full mb-6"></div>
            <p class="text-slate-400 font-medium uppercase tracking-widest text-xs md:text-sm max-w-md mx-auto leading-relaxed">
                Système centralisé de gestion, de configuration et d'enregistrement des badges professionnels.
            </p>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-12 w-full max-w-5xl">
            
            <div class="glass-card p-8 md:p-12 rounded-[2.5rem] border border-slate-700/40 shadow-2xl transition-all duration-300 hover:border-orange-500/40 hover:shadow-orange-500/5 group">
                <div class="w-16 h-16 bg-orange-500/10 border border-orange-500/20 text-orange-400 rounded-2xl flex items-center justify-center mx-auto mb-8 shadow-inner transition-transform group-hover:scale-110">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-10V4m-5 10v4" />
                    </svg>
                </div>
                <h2 class="text-2xl font-black text-white mb-4 uppercase italic tracking-tight text-center">Espace Entreprises</h2>
                <p class="text-slate-400 text-sm text-center mb-8 max-w-xs mx-auto leading-relaxed">
                    Enregistrez votre structure, configurez vos designs de badges et pilotez vos effectifs en temps réel.
                </p>
                
                <div class="flex flex-col gap-4">
                    @auth
                        @if(auth()->user()->company)
                            <a href="{{ route('company.employees', ['slug' => auth()->user()->company->slug]) }}" 
                               class="w-full inline-flex items-center justify-center bg-gradient-to-r from-orange-500 to-amber-500 hover:from-orange-600 hover:to-amber-600 text-white font-black py-4.5 px-6 rounded-2xl transition-all shadow-lg shadow-orange-500/10 active:scale-[0.98] uppercase tracking-widest text-xs border border-orange-400/20">
                                📊 Accéder au Dashboard
                            </a>
                        @else
                            <div class="p-4 bg-slate-800/80 border border-slate-700/60 rounded-2xl text-center">
                                <p class="text-xs text-slate-400 font-bold uppercase italic">Connecté : Administrateur Central</p>
                            </div>
                        @endif
                    @else
                        <a href="{{ route('companies.create') }}" 
                           class="w-full bg-slate-100 hover:bg-white text-slate-950 font-black py-4.5 px-6 rounded-2xl transition-all shadow-md active:scale-[0.98] text-center uppercase tracking-widest text-xs">
                            👤+ Enregistrer mon entreprise
                        </a>
                        <a href="{{ route('login') }}" 
                           class="w-full border border-orange-500/40 hover:border-orange-500 bg-orange-500/5 hover:bg-orange-500 text-orange-400 hover:text-white font-black py-4.5 px-6 rounded-2xl transition-all active:scale-[0.98] text-center uppercase tracking-widest text-xs">
                            🔑 Connexion Partenaire
                        </a>
                    @endauth
                </div>
            </div>

            <div class="glass-card p-8 md:p-12 rounded-[2.5rem] border border-slate-700/40 shadow-2xl transition-all duration-300 hover:border-emerald-500/40 hover:shadow-emerald-500/5 group">
                <div class="w-16 h-16 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-2xl flex items-center justify-center mx-auto mb-8 shadow-inner transition-transform group-hover:scale-110">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-black text-white mb-4 uppercase italic tracking-tight text-center">Admin Centrale</h2>
                <p class="text-slate-400 text-sm text-center mb-8 max-w-xs mx-auto leading-relaxed">
                    Outils de supervision générale, validation des comptes partenaires et audit de sécurité du système.
                </p>
                
                <div class="flex flex-col gap-4">
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('companies.index') }}" 
                               class="w-full bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-black py-4.5 px-6 rounded-2xl transition-all shadow-lg shadow-emerald-500/10 active:scale-[0.98] flex items-center justify-center gap-2 uppercase tracking-widest text-xs border border-emerald-500/20">
                                ⚙️ Gérer la plateforme
                            </a>
                        @else
                            <div class="p-4 bg-slate-800/80 border border-slate-700/60 rounded-2xl text-center">
                                <p class="text-xs text-slate-400 font-bold uppercase italic">Connecté : Espace Entreprise</p>
                            </div>
                        @endif
                    @else
                        <a href="{{ route('login') }}" 
                           class="w-full bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-black py-4.5 px-6 rounded-2xl transition-all shadow-lg shadow-emerald-500/10 active:scale-[0.98] text-center uppercase tracking-widest text-xs border border-emerald-500/20">
                            🛡️ Connexion Super Admin
                        </a>
                        <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest text-center mt-2">
                            🔒 Accès strictement restreint
                        </p>
                    @endauth
                </div>
            </div>
        </div>

        @auth
            <div class="mt-16 text-center">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-slate-800/40 hover:bg-red-500/10 text-slate-400 hover:text-red-400 border border-slate-700/40 hover:border-red-500/20 transition-all font-black uppercase text-[10px] tracking-widest active:scale-95">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Se déconnecter de la session
                    </button>
                </form>
            </div>
        @endauth
    </main>

    <footer class="bg-slate-950/60 border-t border-slate-800 text-slate-500 py-8 text-xs relative z-10">
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
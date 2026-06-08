<x-guest-layout>
    <div class="min-h-screen flex flex-col md:flex-row bg-slate-50 font-sans">
        
        <div class="hidden md:flex md:w-1/2 bg-gradient-to-br from-slate-900 via-slate-800 to-emerald-950 text-white p-12 flex-col justify-between relative overflow-hidden">
            <div class="absolute inset-0 opacity-10 mix-blend-overlay pointer-events-none" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');"></div>
            
            <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -left-10 top-1/3 w-48 h-48 bg-orange-500/10 rounded-full blur-2xl pointer-events-none"></div>

            <div class="relative z-10">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-500/15 border border-emerald-500/30 text-emerald-400 text-[10px] font-bold tracking-widest uppercase mb-6">
                    🛡️ Espace Sécurisé
                </div>
                <h1 class="text-3xl font-black tracking-tighter uppercase italic">
                    YA CONSULTING <span class="text-emerald-500 text-sm not-italic font-medium block tracking-widest mt-1 text-slate-400">BADGES PRO PLATFORM</span>
                </h1>
            </div>

            <div class="my-auto relative z-10 max-w-md">
                <div class="w-16 h-1 bg-gradient-to-r from-orange-500 to-emerald-500 rounded-full mb-6"></div>
                <h2 class="text-3xl md:text-4xl font-black tracking-tight leading-none uppercase italic mb-4">
                    Gérez vos <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-emerald-400">badges professionnels</span> en quelques clics.
                </h2>
                <p class="text-slate-400 font-medium text-sm leading-relaxed">
                    Accédez à votre tableau de bord centralisé pour piloter les autorisations, configurer les visuels et suivre l'enregistrement de vos effectifs.
                </p>
            </div>

            <div class="relative z-10 text-xs text-slate-500 font-medium uppercase tracking-wider">
                &copy; {{ date('Y') }} YA Consulting. Tous droits réservés.
            </div>
        </div>

        <div class="w-full md:w-1/2 flex items-center justify-center p-6 sm:p-12 md:p-16 bg-white relative">
            
            <div class="absolute top-0 inset-x-0 h-2 bg-gradient-to-r from-orange-500 via-emerald-500 to-teal-600 md:hidden"></div>

            <div class="w-full max-w-md">
                <div class="mb-8">
                    <h2 class="text-2xl font-black text-slate-800 tracking-tight uppercase italic md:text-3xl">
                        Connexion <span class="text-emerald-600">Partenaire</span>
                    </h2>
                    <p class="text-slate-500 text-sm font-medium mt-1">
                        Renseignez vos identifiants pour accéder à votre espace de gestion.
                    </p>
                </div>

                <x-auth-session-status class="mb-4 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-semibold" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="block text-xs font-black uppercase tracking-wider text-slate-700 mb-2">
                            Adresse Email Professionnelle
                        </label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                </svg>
                            </span>
                            <input id="email" 
                                   type="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autofocus 
                                   autocomplete="username"
                                   placeholder="partenaire@ya-consulting.com"
                                   class="block w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-slate-800 font-medium placeholder-slate-400 transition-all focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 outline-none text-sm" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-xs font-bold text-red-600 uppercase italic tracking-wide" />
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label for="password" class="block text-xs font-black uppercase tracking-wider text-slate-700">
                                Mot de Passe
                            </label>
                            @if (Route::has('password.request'))
                                <a class="text-xs font-bold text-orange-600 hover:text-orange-700 uppercase tracking-wide transition-colors" href="{{ route('password.request') }}">
                                    Oublié ?
                                </a>
                            @endif
                        </div>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400 pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </span>
                            <input id="password" 
                                   type="password" 
                                   name="password" 
                                   required 
                                   autocomplete="current-password"
                                   placeholder="••••••••••••"
                                   class="block w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-slate-800 font-medium placeholder-slate-400 transition-all focus:bg-white focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 outline-none text-sm" />
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-xs font-bold text-red-600 uppercase italic tracking-wide" />
                    </div>

                    <div class="flex items-center justify-between pt-1">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer select-none">
                            <input id="remember_me" 
                                   type="checkbox" 
                                   name="remember"
                                   class="w-4 h-4 rounded border-slate-300 text-emerald-600 bg-slate-50 focus:ring-emerald-500/20 cursor-pointer transition-all">
                            <span class="ms-2 text-xs font-bold text-slate-500 uppercase tracking-wide">{{ __('Se souvenir de moi') }}</span>
                        </label>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full inline-flex items-center justify-center bg-gradient-to-r from-slate-900 to-slate-800 hover:from-black hover:to-slate-900 text-white font-black py-4 px-6 rounded-2xl transition-all shadow-xl hover:shadow-slate-900/10 active:scale-[0.98] uppercase tracking-widest text-sm border border-slate-800">
                            🔑 S'authentifier
                        </button>
                    </div>
                </form>

                <div class="mt-8 text-center">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-xs font-black text-slate-400 hover:text-slate-600 uppercase tracking-widest transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Retour à la vitrine
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-guest-layout>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande de Badge - {{ $company->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Effet de focus dynamique basé sur la couleur de l'entreprise */
        .focus-dynamic:focus {
            --tw-ring-color: {{ $company->badge_color }} !important;
            border-color: {{ $company->badge_color }} !important;
        }
    </style>
</head>
<body class="bg-slate-100 min-h-screen py-10 px-4">

    <div class="max-w-xl mx-auto bg-white rounded-[2rem] shadow-2xl overflow-hidden border border-slate-200">
        <div class="p-8 text-center" style="background-color: {{ $company->badge_color }}">
            @if($company->logo)
                <div class="bg-white/20 backdrop-blur-md p-3 rounded-2xl inline-block mb-4">
                    <img src="{{ asset('storage/' . $company->logo) }}" alt="Logo" class="h-16 w-16 object-contain">
                </div>
            @endif
            <h1 class="text-white text-2xl font-black uppercase tracking-widest leading-tight">Demande de Badge</h1>
            <p class="text-white/80 font-medium tracking-wide uppercase text-sm mt-1">{{ $company->name }}</p>
        </div>

        <form action="{{ route('employee.store') }}" method="POST" class="p-8 space-y-6">
            @csrf
            <input type="hidden" name="company_id" value="{{ $company->id }}">

            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-xl text-sm shadow-sm">
                    <p class="font-bold">Oups ! Il y a quelques erreurs :</p>
                    <ul class="list-disc ml-5 mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 ml-1">Nom *</label>
                    <input type="text" name="last_name" required 
                           class="w-full bg-slate-50 border-slate-200 rounded-2xl p-4 border focus:bg-white transition-all outline-none focus:ring-2 focus-dynamic">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 ml-1">Prénom *</label>
                    <input type="text" name="first_name" required 
                           class="w-full bg-slate-50 border-slate-200 rounded-2xl p-4 border focus:bg-white transition-all outline-none focus:ring-2 focus-dynamic">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 ml-1">Email Professionnel *</label>
                <input type="email" name="email" required 
                       class="w-full bg-slate-50 border-slate-200 rounded-2xl p-4 border focus:bg-white transition-all outline-none focus:ring-2 focus-dynamic">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 ml-1">Matricule Interne *</label>
                <input type="text" name="matricule" required 
                       class="w-full bg-slate-50 border-slate-200 rounded-2xl p-4 border focus:bg-white transition-all outline-none focus:ring-2 focus-dynamic font-mono">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2 ml-1">Fonction / Poste *</label>
                <input type="text" name="function" required 
                       class="w-full bg-slate-50 border-slate-200 rounded-2xl p-4 border focus:bg-white transition-all outline-none focus:ring-2 focus-dynamic">
            </div>

            <button type="submit" 
                    class="w-full text-white font-black py-4 rounded-2xl shadow-lg hover:shadow-xl hover:scale-[1.02] active:scale-[0.98] transition-all uppercase tracking-widest text-lg" 
                    style="background-color: {{ $company->badge_color }}">
                Générer mon badge
            </button>
        </form>
    </div>
</body>
</html>
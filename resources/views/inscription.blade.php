<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interface Badge - {{ $company->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .glass {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .glow { box-shadow: 0 0 20px -5px {{ $company->badge_color }}; }
    </style>
</head>
<body class="bg-[#0a0a0a] min-h-screen flex items-center justify-center p-4 font-sans text-slate-200">

    <div class="max-w-xl w-full glass rounded-[2.5rem] shadow-[0_0_50px_rgba(0,0,0,0.5)] overflow-hidden relative">
        <div class="h-2 w-full" style="background-color: {{ $company->badge_color }}"></div>

        <div class="p-8 text-center">
            @if($company->logo)
                <img src="{{ asset('storage/' . $company->logo) }}" alt="Logo" class="h-20 w-20 mx-auto mb-6 rounded-2xl border border-slate-700 bg-white p-2">
            @endif
            <h1 class="text-3xl font-black uppercase tracking-[0.2em] text-white">System Access</h1>
            <p class="text-xs tracking-[0.3em] uppercase mt-2 opacity-60">{{ $company->name }}</p>
        </div>

        <form action="{{ route('employee.store') }}" method="POST" class="px-8 pb-10 space-y-5">
            @csrf
            <input type="hidden" name="company_id" value="{{ $company->id }}">

            @if ($errors->any())
                <div class="bg-red-900/20 border border-red-500/50 text-red-400 p-4 rounded-xl text-sm">
                    <ul>@foreach ($errors->all() as $error) <li>• {{ $error }}</li> @endforeach</ul>
                </div>
            @endif

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-[10px] uppercase tracking-widest text-slate-500 ml-2">Nom</label>
                    <input type="text" name="last_name" required class="w-full bg-black/40 border border-slate-800 rounded-xl p-3 mt-1 focus:border-[{{ $company->badge_color }}] outline-none transition-colors">
                </div>
                <div>
                    <label class="text-[10px] uppercase tracking-widest text-slate-500 ml-2">Prénom</label>
                    <input type="text" name="first_name" required class="w-full bg-black/40 border border-slate-800 rounded-xl p-3 mt-1 focus:border-[{{ $company->badge_color }}] outline-none transition-colors">
                </div>
            </div>

            <div>
                <label class="text-[10px] uppercase tracking-widest text-slate-500 ml-2">Email</label>
                <input type="email" name="email" required class="w-full bg-black/40 border border-slate-800 rounded-xl p-3 mt-1 focus:border-[{{ $company->badge_color }}] outline-none transition-colors">
            </div>

            <div>
                <label class="text-[10px] uppercase tracking-widest text-slate-500 ml-2">Matricule</label>
                <input type="text" name="matricule" required class="w-full bg-black/40 border border-slate-800 rounded-xl p-3 mt-1 focus:border-[{{ $company->badge_color }}] outline-none transition-colors font-mono uppercase tracking-widest">
            </div>

            <div>
                <label class="text-[10px] uppercase tracking-widest text-slate-500 ml-2">Fonction</label>
                <input type="text" name="function" required class="w-full bg-black/40 border border-slate-800 rounded-xl p-3 mt-1 focus:border-[{{ $company->badge_color }}] outline-none transition-colors">
            </div>

            <button type="submit" 
                    class="w-full text-black font-black py-4 rounded-xl mt-4 glow hover:opacity-90 transition-all uppercase tracking-[0.2em] text-sm" 
                    style="background-color: {{ $company->badge_color }}">
                Initialiser Badge
            </button>
        </form>
    </div>
</body>
</html>
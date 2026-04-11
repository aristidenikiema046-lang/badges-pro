<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accès Système - {{ $company->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;700&display=swap');
        body { font-family: 'Space+Grotesk', sans-serif; }
        .glass-panel {
            background: rgba(17, 24, 39, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .glow-effect { box-shadow: 0 0 30px -10px {{ $company->badge_color }}; }
    </style>
</head>
<body class="bg-[#050505] min-h-screen flex items-center justify-center p-4">

    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-[20%] -left-[10%] w-[50%] h-[50%] rounded-full opacity-20 blur-[120px]" style="background: {{ $company->badge_color }}"></div>
    </div>

    <div class="w-full max-w-lg glass-panel rounded-[2rem] shadow-2xl overflow-hidden border border-slate-800 relative z-10">
        
        <div class="p-8 text-center relative border-b border-white/5">
            @if($company->logo)
                <div class="mx-auto w-20 h-20 bg-white/5 rounded-2xl flex items-center justify-center mb-6 border border-white/10 backdrop-blur-sm">
                    <img src="{{ asset('storage/' . $company->logo) }}" class="h-12 w-12 object-contain">
                </div>
            @endif
            <h2 class="text-white text-2xl font-bold uppercase tracking-[0.2em]">IDENTIFICATION</h2>
            <p class="text-slate-400 text-[10px] uppercase tracking-[0.3em] mt-2">{{ $company->name }}</p>
        </div>

        <form action="{{ route('employee.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-5">
            @csrf
            <input type="hidden" name="company_id" value="{{ $company->id }}">

            @if ($errors->any())
                <div class="bg-red-900/30 border border-red-500/30 text-red-400 p-4 rounded-xl text-xs">
                    <ul class="list-none space-y-1">@foreach ($errors->all() as $error) <li>⚠ {{ $error }}</li> @endforeach</ul>
                </div>
            @endif

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-[9px] font-bold uppercase text-slate-500 tracking-widest ml-2 mb-1">Prénom</label>
                    <input type="text" name="first_name" required class="w-full bg-black/50 border border-slate-800 p-3 rounded-xl focus:border-[{{ $company->badge_color }}] outline-none transition text-white text-sm">
                </div>
                <div>
                    <label class="text-[9px] font-bold uppercase text-slate-500 tracking-widest ml-2 mb-1">Nom</label>
                    <input type="text" name="last_name" required class="w-full bg-black/50 border border-slate-800 p-3 rounded-xl focus:border-[{{ $company->badge_color }}] outline-none transition text-white text-sm">
                </div>
            </div>

            <div>
                <label class="text-[9px] font-bold uppercase text-slate-500 tracking-widest ml-2 mb-1">Email Professionnel</label>
                <input type="email" name="email" required class="w-full bg-black/50 border border-slate-800 p-3 rounded-xl focus:border-[{{ $company->badge_color }}] outline-none transition text-white text-sm">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-[9px] font-bold uppercase text-slate-500 tracking-widest ml-2 mb-1">Poste</label>
                    <input type="text" name="function" required class="w-full bg-black/50 border border-slate-800 p-3 rounded-xl focus:border-[{{ $company->badge_color }}] outline-none transition text-white text-sm">
                </div>
                <div>
                    <label class="text-[9px] font-bold uppercase text-slate-500 tracking-widest ml-2 mb-1">Matricule</label>
                    <input type="text" name="matricule" required class="w-full bg-black/50 border border-slate-800 p-3 rounded-xl focus:border-[{{ $company->badge_color }}] outline-none transition text-white text-sm font-mono uppercase">
                </div>
            </div>

            <div class="mt-2">
                <label class="text-[9px] font-bold uppercase text-slate-500 tracking-widest ml-2 mb-1">Uploader Identité</label>
                <input type="file" name="photo" required class="w-full text-slate-400 text-xs file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-white/5 file:text-white hover:file:bg-white/10 cursor-pointer">
            </div>

            <button type="submit" class="w-full font-black py-4 rounded-xl shadow-lg glow-effect hover:opacity-90 transition-all uppercase tracking-[0.2em] text-sm mt-6 text-black" style="background-color: {{ $company->badge_color }}">
                Générer accès
            </button>
        </form>

        <div class="px-8 pb-8 text-center">
            <p class="text-[8px] text-slate-600 uppercase tracking-[0.2em] font-bold">
                Secure Data Protocol • {{ date('Y') }}
            </p>
        </div>
    </div>
</body>
</html>
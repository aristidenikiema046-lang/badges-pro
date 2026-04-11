<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande Badge - {{ $company->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .glass-light {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-xl glass-light rounded-[2rem] shadow-[0_20px_50px_rgba(0,0,0,0.05)] overflow-hidden border border-white">
        
        <div class="p-8 text-center border-b border-black/5">
            @if($company->logo)
                <div class="h-20 w-20 mx-auto mb-6 flex items-center justify-center bg-white rounded-3xl shadow-inner border border-slate-100">
                    <img src="{{ asset('storage/' . $company->logo) }}" class="h-12 w-12 object-contain">
                </div>
            @endif
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Nouvelle Demande</h1>
            <p class="text-slate-400 text-xs font-medium uppercase tracking-[0.2em] mt-1">{{ $company->name }}</p>
        </div>

        <form action="{{ route('employee.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
            @csrf
            <input type="hidden" name="company_id" value="{{ $company->id }}">

            @if ($errors->any())
                <div class="bg-red-50 text-red-600 p-4 rounded-2xl text-xs font-medium">
                    @foreach ($errors->all() as $error) • {{ $error }}<br> @endforeach
                </div>
            @endif

            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Prénom</label>
                    <input type="text" name="first_name" required class="w-full bg-slate-100/50 border-none rounded-2xl p-4 text-slate-800 text-sm focus:ring-2 focus:ring-offset-2 outline-none transition-all" style="--tw-ring-color: {{ $company->badge_color }}">
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Nom</label>
                    <input type="text" name="last_name" required class="w-full bg-slate-100/50 border-none rounded-2xl p-4 text-slate-800 text-sm focus:ring-2 focus:ring-offset-2 outline-none transition-all" style="--tw-ring-color: {{ $company->badge_color }}">
                </div>
            </div>

            <div class="space-y-1">
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Email</label>
                <input type="email" name="email" required class="w-full bg-slate-100/50 border-none rounded-2xl p-4 text-slate-800 text-sm focus:ring-2 focus:ring-offset-2 outline-none transition-all" style="--tw-ring-color: {{ $company->badge_color }}">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Poste</label>
                    <input type="text" name="function" required class="w-full bg-slate-100/50 border-none rounded-2xl p-4 text-slate-800 text-sm focus:ring-2 focus:ring-offset-2 outline-none transition-all" style="--tw-ring-color: {{ $company->badge_color }}">
                </div>
                <div class="space-y-1">
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Matricule</label>
                    <input type="text" name="matricule" required class="w-full bg-slate-100/50 border-none rounded-2xl p-4 text-slate-800 text-sm font-mono focus:ring-2 focus:ring-offset-2 outline-none transition-all" style="--tw-ring-color: {{ $company->badge_color }}">
                </div>
            </div>

            <div class="space-y-1">
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest ml-1">Photo d'identité</label>
                <input type="file" name="photo" required class="w-full text-slate-500 text-xs file:mr-4 file:py-2.5 file:px-6 file:rounded-xl file:border-0 file:text-white file:text-xs file:font-bold cursor-pointer" style="file:background-color: {{ $company->badge_color }}">
            </div>

            <button type="submit" class="w-full text-white font-bold py-4 rounded-2xl shadow-lg transition-all transform hover:scale-[1.01] active:scale-[0.99] uppercase tracking-widest text-sm mt-4" style="background-color: {{ $company->badge_color }}">
                Générer mon accès
            </button>
        </form>

        <div class="p-6 bg-slate-50/50 text-center border-t border-black/5">
            <p class="text-[9px] font-bold text-slate-300 uppercase tracking-[0.2em]">Système {{ date('Y') }} • Sécurisé</p>
        </div>
    </div>
</body>
</html>
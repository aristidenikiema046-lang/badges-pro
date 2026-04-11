<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accès Système - {{ $company->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;700;900&display=swap');
        body { font-family: 'Inter', sans-serif; background: #f0f4f8; }
        .split-card { display: grid; grid-template-columns: 1fr 1fr; border: 1px solid #e2e8f0; }
        .blue-side { background: #2563eb; color: white; }
    </style>
</head>
<body class="min-h-screen flex flex-col items-center justify-center p-4">

    <div class="w-full max-w-4xl bg-white rounded-3xl shadow-2xl overflow-hidden split-card">
        
        <div class="blue-side p-12 flex flex-col justify-between">
            <div>
                @if($company->logo)
                    <img src="{{ asset('storage/' . $company->logo) }}" alt="Logo" class="h-20 w-20 bg-white p-2 rounded-2xl mb-8 object-contain">
                @endif
                <h1 class="text-4xl font-black uppercase tracking-tighter">Badges<br>Pro</h1>
                <div class="w-16 h-1 bg-blue-400 mt-6"></div>
                <p class="mt-8 text-blue-100 text-sm leading-relaxed opacity-80 font-light">
                    Plateforme sécurisée pour l'enregistrement et la gestion des badges professionnels {{ $company->name }}.
                </p>
            </div>
            <div class="text-[10px] uppercase tracking-[0.2em] opacity-50">Protocole sécurisé v2026</div>
        </div>

        <div class="p-12 bg-white">
            <form action="{{ route('employee.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                <input type="hidden" name="company_id" value="{{ $company->id }}">

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest ml-1">Prénom</label>
                        <input type="text" name="first_name" required class="w-full bg-slate-50 border-b-2 border-slate-200 p-2 focus:border-blue-600 outline-none transition-all">
                    </div>
                    <div>
                        <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest ml-1">Nom</label>
                        <input type="text" name="last_name" required class="w-full bg-slate-50 border-b-2 border-slate-200 p-2 focus:border-blue-600 outline-none transition-all">
                    </div>
                </div>

                <div>
                    <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest ml-1">Email</label>
                    <input type="email" name="email" required class="w-full bg-slate-50 border-b-2 border-slate-200 p-2 focus:border-blue-600 outline-none transition-all">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest ml-1">Poste</label>
                        <input type="text" name="function" required class="w-full bg-slate-50 border-b-2 border-slate-200 p-2 focus:border-blue-600 outline-none transition-all">
                    </div>
                    <div>
                        <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest ml-1">Matricule</label>
                        <input type="text" name="matricule" required class="w-full bg-slate-50 border-b-2 border-slate-200 p-2 focus:border-blue-600 outline-none transition-all">
                    </div>
                </div>

                <div>
                    <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest ml-1">Photo</label>
                    <input type="file" name="photo" required class="w-full mt-2 text-[10px] text-slate-400 file:bg-blue-600 file:text-white file:border-0 file:px-4 file:py-2 file:rounded-full">
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white font-black py-4 rounded-xl mt-4 hover:bg-blue-700 transition-all uppercase tracking-[0.2em] text-xs">
                    Generer mon badge
                </button>
            </form>
        </div>
    </div>

    <div class="mt-8 text-[10px] text-slate-400 uppercase tracking-widest">
        © {{ date('Y') }} YaConsulting. Tous droits réservés.
    </div>

</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accès Système - {{ $company->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700&display=swap');
        
        body {
            font-family: 'JetBrains Mono', monospace;
            background-color: #f8fafc;
            background-image: 
                linear-gradient(rgba(59, 130, 246, 0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(59, 130, 246, 0.05) 1px, transparent 1px);
            background-size: 40px 40px;
        }

        .tech-card {
            background: #ffffff;
            border: 2px solid #e2e8f0;
            clip-path: polygon(15px 0%, calc(100% - 15px) 0%, 100% 15px, 100% calc(100% - 15px), calc(100% - 15px) 100%, 15px 100%, 0% calc(100% - 15px), 0% 15px);
        }

        .input-blue {
            background: #f1f5f9;
            border: 1px solid #cbd5e1;
            transition: all 0.3s;
        }
        
        .input-blue:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
            outline: none;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-lg tech-card shadow-2xl p-1 z-10">
        <div class="bg-white p-2">
            
            <div class="p-6 border-b-2 border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    @if($company->logo)
                        <div class="p-2 bg-blue-50 rounded-lg border border-blue-100">
                            <img src="{{ asset('storage/' . $company->logo) }}" class="h-10 w-10 object-contain">
                        </div>
                    @endif
                    <div>
                        <h1 class="text-blue-900 text-base font-extrabold uppercase tracking-widest">{{ $company->name }}</h1>
                        <p class="text-[9px] text-blue-500 uppercase tracking-[0.2em] font-bold mt-0.5">BLUE_PROTOCOL // ACTIVE</p>
                    </div>
                </div>
                <div class="w-3 h-3 rounded-full bg-blue-500 animate-pulse"></div>
            </div>

            <form action="{{ route('employee.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-5">
                @csrf
                <input type="hidden" name="company_id" value="{{ $company->id }}">

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-600 p-4 rounded-lg text-[10px] uppercase font-bold">
                        <ul class="space-y-1">@foreach ($errors->all() as $error) <li>• {{ $error }}</li> @endforeach</ul>
                    </div>
                @endif

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest ml-1">Prénom</label>
                        <input type="text" name="first_name" value="{{ old('first_name') }}" required class="w-full input-blue p-3 rounded-md text-sm text-blue-900">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest ml-1">Nom</label>
                        <input type="text" name="last_name" value="{{ old('last_name') }}" required class="w-full input-blue p-3 rounded-md text-sm text-blue-900">
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest ml-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="w-full input-blue p-3 rounded-md text-sm text-blue-900">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1">
                        <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest ml-1">Poste</label>
                        <input type="text" name="function" value="{{ old('function') }}" required class="w-full input-blue p-3 rounded-md text-sm text-blue-900">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest ml-1">Matricule</label>
                        <input type="text" name="matricule" value="{{ old('matricule') }}" required class="w-full input-blue p-3 rounded-md text-sm text-blue-900 uppercase">
                    </div>
                </div>

                <div class="space-y-1">
                    <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest ml-1">Photo d'identité</label>
                    <input type="file" name="photo" required class="w-full text-slate-500 text-xs file:bg-blue-600 file:text-white file:border-0 file:px-4 file:py-2 file:rounded file:cursor-pointer hover:file:bg-blue-700">
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white font-bold py-4 rounded-md shadow-lg shadow-blue-200 transition-all hover:bg-blue-700 uppercase tracking-[0.2em] text-xs mt-2">
                    Générer l'accès
                </button>
            </form>

            <div class="p-4 bg-slate-50 text-center border-t border-slate-100">
                <p class="text-[8px] font-bold text-slate-400 uppercase tracking-[0.3em]">YA_CONSULTING_SYSTEM_v2026</p>
            </div>
        </div>
    </div>

</body>
</html>
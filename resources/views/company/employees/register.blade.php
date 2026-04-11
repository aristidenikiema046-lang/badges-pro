<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande Accès - {{ $company->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Police technique monospace */
        @import url('https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;700;800&display=swap');
        
        body {
            font-family: 'JetBrains Mono', monospace;
            /* Fond style "carte de circuit" (PCB) */
            background-color: #030712; /* slate-950 */
            background-image: 
                linear-gradient(rgba(255, 255, 255, 0.02) 1px, transparent 1px),
                linear-gradient(90px, rgba(255, 255, 255, 0.02) 1px, transparent 1px),
                linear-gradient(rgba(255, 255, 255, 0.01) 1px, transparent 1px),
                linear-gradient(90px, rgba(255, 255, 255, 0.01) 1px, transparent 1px);
            background-size: 100px 100px, 100px 100px, 20px 20px, 20px 20px;
            background-position: -1px -1px, -1px -1px, -1px -1px, -1px -1px;
        }

        /* Coins biseautés "Tech" */
        .tech-corners {
            clip-path: polygon(
                20px 0%, calc(100% - 20px) 0%, 100% 20px, 
                100% calc(100% - 20px), calc(100% - 20px) 100%, 
                20px 100%, 0% calc(100% - 20px), 0% 20px
            );
        }

        /* Effet "piste de circuit" lumineuse autour du formulaire */
        .circuit-border {
            position: relative;
            background: rgba(15, 23, 42, 0.8); /* slate-900 */
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .circuit-border::after {
            content: "";
            position: absolute;
            inset: -4px;
            background: linear-gradient(90px, transparent 50%, {{ $company->badge_color }} 50%),
                        linear-gradient(transparent 50%, {{ $company->badge_color }} 50%);
            background-size: 20px 20px;
            border-radius: 20px;
            opacity: 0.1;
            z-index: -1;
        }

        /* Input style console sombre */
        .input-console {
            background-color: rgba(0, 0, 0, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.05);
            color: #f1f5f9; /* slate-100 */
            transition: all 0.2s;
        }
        
        .input-console:focus {
            border-color: {{ $company->badge_color }};
            box-shadow: 0 0 10px -2px {{ $company->badge_color }};
            outline: none;
        }

        /* Effet glow sur le bouton */
        .glow-tech {
            box-shadow: 0 0 20px -3px {{ $company->badge_color }};
        }
        
        .glow-tech:hover {
            box-shadow: 0 0 30px -3px {{ $company->badge_color }};
            transform: translateY(-1px);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-lg circuit-border p-1 z-10">
        <div class="tech-corners bg-slate-900/90 overflow-hidden">
            
            <div class="p-6 border-b border-white/5 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    @if($company->logo)
                        <div class="p-2 bg-white/5 rounded-lg border border-white/10">
                            <img src="{{ asset('storage/' . $company->logo) }}" class="h-10 w-10 object-contain">
                        </div>
                    @endif
                    <div>
                        <h1 class="text-white text-base font-extrabold uppercase tracking-widest">{{ $company->name }}</h1>
                        <p class="text-[9px] text-slate-500 uppercase tracking-[0.3em] font-medium mt-0.5">AUTH_PROTOCOL_ACTIVE // SECURE_LINE</p>
                    </div>
                </div>
                <div class="w-3 h-3 rounded-full animate-pulse" style="background-color: {{ $company->badge_color }}"></div>
            </div>

            <form action="{{ route('employee.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
                @csrf
                <input type="hidden" name="company_id" value="{{ $company->id }}">

                @if ($errors->any())
                    <div class="bg-red-950/40 border border-red-800 text-red-400 p-4 rounded-lg text-[10px] uppercase font-bold">
                        <ul class="space-y-1">@foreach ($errors->all() as $error) <li>• {{ $error }}</li> @endforeach</ul>
                    </div>
                @endif

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1.5 relative">
                        <label class="text-[9px] font-bold text-slate-500 uppercase tracking-[0.2em] ml-2">Prénom</label>
                        <input type="text" name="first_name" required class="w-full input-console p-4 rounded-lg text-sm">
                    </div>
                    <div class="space-y-1.5 relative">
                        <label class="text-[9px] font-bold text-slate-500 uppercase tracking-[0.2em] ml-2">Nom</label>
                        <input type="text" name="last_name" required class="w-full input-console p-4 rounded-lg text-sm">
                    </div>
                </div>

                <div class="space-y-1.5 relative">
                    <label class="text-[9px] font-bold text-slate-500 uppercase tracking-[0.2em] ml-2">Corporate Email</label>
                    <input type="email" name="email" required class="w-full input-console p-4 rounded-lg text-sm">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1.5 relative">
                        <label class="text-[9px] font-bold text-slate-500 uppercase tracking-[0.2em] ml-2">Function</label>
                        <input type="text" name="function" required class="w-full input-console p-4 rounded-lg text-sm">
                    </div>
                    <div class="space-y-1.5 relative">
                        <label class="text-[9px] font-bold text-slate-500 uppercase tracking-[0.2em] ml-2">Serial ID</label>
                        <input type="text" name="matricule" required class="w-full input-console p-4 rounded-lg text-sm uppercase">
                    </div>
                </div>

                <div class="space-y-2 relative pt-2">
                    <label class="text-[9px] font-bold text-slate-500 uppercase tracking-[0.2em] ml-2">Upload Biometric Photo</label>
                    <input type="file" name="photo" required class="w-full text-slate-400 text-xs file:bg-white/5 file:text-white file:border file:border-white/10 file:px-4 file:py-2 file:rounded-full file:cursor-pointer hover:file:bg-white/10">
                </div>

                <button type="submit" class="w-full text-black font-extrabold py-4 rounded-lg transition-all glow-tech uppercase tracking-[0.3em] text-xs mt-4" style="background-color: {{ $company->badge_color }}">
                    Générer mon accès
                </button>
            </form>

            <div class="p-4 bg-slate-950 text-center border-t border-white/5">
                <p class="text-[8px] font-bold text-slate-600 uppercase tracking-[0.4em]">SYSTEM_VERSION // {{ date('Y') }} // Secure_Grant_Protocol</p>
            </div>
        </div>
    </div>

</body>
</html>
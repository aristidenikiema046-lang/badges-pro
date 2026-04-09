@php 
    // Sécurité : couleur principale ou vert émeraude par défaut
    $mainColor = $employee->company->badge_color ?? '#059669'; 
    
    // Préparation des données pour le QR Code
    $qrData = "NOM: {$employee->last_name}\n"
            . "PRENOM: {$employee->first_name}\n"
            . "POSTE: {$employee->function}\n"
            . "ID: {$employee->matricule}\n"
            . "ENTREPRISE: " . ($employee->company->name ?? 'YA CONSULTING');
@endphp

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .badge-vertical {
            width: 350px;
            height: 550px;
            font-family: 'sans-serif';
        }
        @media print {
            .no-print { display: none; }
            body { background: white; padding: 0; }
            .badge-vertical { shadow: none; border: 1px solid #eee; margin: 0; }
        }
    </style>
</head>
<body class="bg-gray-100 flex flex-col items-center justify-center min-h-screen gap-4">

    <div class="no-print">
        <button onclick="window.print()" class="flex items-center gap-2 bg-slate-800 text-white px-8 py-3 rounded-full hover:bg-black transition shadow-xl font-bold uppercase text-sm tracking-widest">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 00-2 2h2m2 4h10a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            Imprimer ce Badge
        </button>
    </div>

    <div class="badge-vertical relative bg-white flex flex-col items-center overflow-hidden shadow-2xl rounded-3xl border border-gray-100">
        
        {{-- Grille technique décorative SF --}}
        <div class="absolute inset-0 opacity-[0.1] pointer-events-none">
            <svg width="100%" height="100%" viewBox="0 0 100 120" fill="none" stroke="{{ $mainColor }}" stroke-width="0.3">
                <path d="M0 20 L100 20 M0 40 L100 40 M0 60 L100 60 M0 80 L100 80 M0 100 L100 100 M20 0 L20 120 M40 0 L40 120 M60 0 L60 120 M80 0 L80 120" stroke-dasharray="1 1" />
            </svg>
        </div>

        <div class="absolute -top-6 -left-6 w-20 h-20 rounded-full bg-slate-900 opacity-90 z-0"></div>
        <div class="absolute -top-10 -right-10 w-24 h-24 rounded-full opacity-60 z-0" style="background-color: {{ $mainColor }}"></div>

        <div class="w-full pt-10 flex-none flex justify-center z-10 px-6">
            @if($employee->company && $employee->company->logo)
                <img src="{{ asset('storage/' . $employee->company->logo) }}" class="h-8 w-auto object-contain">
            @else
                 <div class="font-black text-xs uppercase text-white/90 tracking-widest">
                    {{ $employee->company->name ?? 'YA CONSULTING' }}
                </div>
            @endif
        </div>

        <div class="relative mt-8 z-10">
            {{-- Cadre photo carré avec coins angulaires coupés --}}
            <div class="w-40 h-40 border-4 shadow-2xl overflow-hidden bg-gray-100 rounded-2xl" 
                 style="border-color: {{ $mainColor }}; clip-path: polygon(10% 0, 100% 0, 100% 100%, 0 100%, 0 10%);">
                @if($employee->photo)
                    <img src="{{ asset('storage/' . $employee->photo) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                        <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                    </div>
                @endif
            </div>
            
            {{-- Décoration géométrique sous la photo --}}
            <div class="h-1.5 w-20 bg-slate-900 mx-auto mt-4 rounded-full"></div>
        </div>

        <div class="flex-grow flex flex-col items-center justify-center w-full px-8 text-center z-10 mt-6">
            
            <div class="mb-4">
                {{-- Nom : Forcé en Noir pour lisibilité --}}
                <h1 class="text-3xl font-black uppercase tracking-tight text-slate-950 leading-none">
                    {{ $employee->last_name }}
                </h1>
                {{-- Prénom : Couleur d'accentuation --}}
                <h2 class="text-xl font-bold uppercase mt-1" style="color: {{ $mainColor }}">
                    {{ $employee->first_name }}
                </h2>
            </div>
            
            {{-- Fonction / Poste --}}
            <p class="text-[11px] font-black text-slate-500 uppercase tracking-widest mb-3">
                {{ $employee->function ?? 'Collaborateur' }}
            </p>

            <div class="bg-slate-900 text-white px-5 py-1.5 rounded-full text-sm font-mono font-bold shadow-lg border-2 border-white mb-8">
                ID: {{ $employee->matricule }}
            </div>

            <div class="bg-white p-2 rounded-2xl shadow-md border border-gray-100">
                {!! QrCode::size(80)->margin(1)->generate($qrData) !!}
            </div>
        </div>

        <div class="w-full h-12 flex-none relative z-10 mt-6">
            <div class="absolute inset-0 opacity-95" style="background-color: {{ $mainColor }}; clip-path: polygon(0 100%, 100% 100%, 100% 0);"></div>
            <div class="absolute inset-0 flex items-center justify-center pr-12">
                 <span class="text-[9px] text-white font-bold uppercase tracking-[0.5em]">Authentifié</span>
            </div>
        </div>
    </div>

</body>
</html>
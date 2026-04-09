@php 
    // Récupération de la couleur ou vert émeraude par défaut
    $mainColor = $employee->company->badge_color ?? '#059669'; 

    // Préparation des données complètes pour le QR Code
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
        /* Format vertical standard pour badge */
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
<body class="bg-gray-100 flex flex-col items-center justify-center min-h-screen gap-4 p-4">

    <div class="no-print">
        <button onclick="window.print()" class="flex items-center gap-2 bg-emerald-700 text-white px-6 py-2 rounded-full hover:bg-emerald-800 transition shadow-lg font-bold">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 00-2 2h2m2 4h10a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            IMPRIMER CE BADGE
        </button>
    </div>

    <div class="badge-vertical relative bg-white flex flex-col items-center overflow-hidden shadow-2xl rounded-[2rem] border border-gray-100">
        
        {{-- Grille technique décorative --}}
        <div class="absolute inset-0 opacity-[0.1] pointer-events-none">
            <svg width="100%" height="100%" viewBox="0 0 100 120" fill="none" stroke="{{ $mainColor }}" stroke-width="0.3">
                <path d="M0 20 L100 20 M0 40 L100 40 M0 60 L100 60 M0 80 L100 80 M0 100 L100 100 M20 0 L20 120 M40 0 L40 120 M60 0 L60 120 M80 0 L80 120" stroke-dasharray="1 1" />
            </svg>
        </div>

        <div class="w-full pt-10 flex-none flex justify-center z-10 px-6">
            @if($employee->company && $employee->company->logo)
                <div class="bg-white px-6 py-2 rounded-full shadow-sm border border-gray-100">
                    <img src="{{ asset('storage/' . $employee->company->logo) }}" class="h-8 w-auto object-contain">
                </div>
            @else
                 <div class="bg-white px-6 py-2 rounded-full shadow-sm border border-gray-100 font-black text-xs" style="color: {{ $mainColor }}">
                    {{ $employee->company->name ?? 'YA CONSULTING' }}
                </div>
            @endif
        </div>

        <div class="flex-grow flex flex-col items-center justify-center w-full px-6 text-center z-10">
            <div class="bg-slate-900 p-6 rounded-[2.5rem] shadow-2xl mb-8 transform -rotate-2 border-4" style="border-color: {{ $mainColor }}">
                <div class="bg-white p-3 rounded-[1.8rem]">
                    {!! QrCode::size(140)->margin(1)->generate($qrData) !!}
                </div>
            </div>

            <div class="mb-4 w-full">
                <h1 class="text-3xl font-black uppercase tracking-tighter text-slate-900 truncate px-2">
                    {{ $employee->last_name }}
                </h1>
                <div class="h-1.5 w-12 bg-slate-900 mx-auto my-3 rounded-full"></div>
                <h2 class="text-xl font-bold uppercase truncate px-2" style="color: {{ $mainColor }}">
                    {{ $employee->first_name }}
                </h2>
            </div>
            
            <div class="bg-gray-50 px-4 py-1.5 rounded-full border border-gray-100">
                <p class="text-[10px] font-black text-gray-500 uppercase tracking-[0.2em]">
                    {{ $employee->function ?? 'Collaborateur' }}
                </p>
            </div>
        </div>

        <div class="w-full h-20 flex-none flex items-end justify-center relative z-10">
            <div class="absolute inset-0" style="background-color: {{ $mainColor }}; clip-path: polygon(0 100%, 100% 100%, 100% 0);"></div>
            <div class="relative pb-6 flex flex-col items-center">
                <span class="text-white font-mono font-black tracking-[0.3em] text-sm uppercase">
                    #{{ $employee->matricule }}
                </span>
            </div>
        </div>
    </div>

</body>
</html>
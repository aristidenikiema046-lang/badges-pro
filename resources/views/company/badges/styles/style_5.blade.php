@php 
    $mainColor = $employee->company->badge_color ?? '#059669'; 
    
    // QR Code enrichi
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
        .badge-vertical { width: 350px; height: 550px; font-family: 'sans-serif'; }
        @media print { .no-print { display: none; } body { background: white; } }
        /* Pour garantir la lisibilité si la couleur est trop claire */
        .text-accent { color: {{ $mainColor }}; filter: brightness(0.8); }
        .border-accent { border-color: {{ $mainColor }}; }
        .bg-accent { background-color: {{ $mainColor }}; }
    </style>
</head>
<body class="bg-gray-100 flex flex-col items-center justify-center min-h-screen gap-4 p-4">

    <div class="no-print">
        <button onclick="window.print()" class="bg-slate-800 text-white px-8 py-3 rounded-full hover:bg-black transition shadow-xl font-bold uppercase text-sm tracking-widest">
            Imprimer le Badge
        </button>
    </div>

    <div class="badge-vertical relative bg-white flex flex-col items-center overflow-hidden shadow-2xl rounded-[2.5rem] border border-gray-200">
        
        {{-- Grille technique --}}
        <div class="absolute inset-0 opacity-[0.15] pointer-events-none">
            <svg width="100%" height="100%" viewBox="0 0 100 120" fill="none" stroke="{{ $mainColor }}" stroke-width="0.5">
                <path d="M0 20 L100 20 M0 40 L100 40 M0 60 L100 60 M0 80 L100 80 M0 100 L100 100 M20 0 L20 120 M40 0 L40 120 M60 0 L60 120 M80 0 L80 120" stroke-dasharray="1 1" />
            </svg>
        </div>

        <div class="w-full pt-10 flex-none flex justify-center z-10">
            <div class="bg-white px-6 py-2 rounded-full shadow-md border border-gray-100 min-w-[150px] text-center">
                @if($employee->company && $employee->company->logo)
                    <img src="{{ asset('storage/' . $employee->company->logo) }}" class="h-8 mx-auto object-contain">
                @else
                    <span class="font-black text-sm uppercase tracking-tighter text-slate-900">
                        {{ $employee->company->name ?? 'YA CONSULTING' }}
                    </span>
                @endif
            </div>
        </div>

        <div class="flex-grow flex flex-col items-center justify-center w-full px-8 text-center z-10">
            <div class="bg-slate-900 p-5 rounded-[2.5rem] shadow-2xl mb-8 transform -rotate-1 border-4 border-accent">
                <div class="bg-white p-2 rounded-[1.8rem]">
                    {!! QrCode::size(130)->margin(1)->generate($qrData) !!}
                </div>
            </div>

            <div class="mb-4 w-full">
                <p class="text-gray-500 text-[10px] font-black uppercase tracking-[0.3em] mb-1">Collaborateur</p>
                <h1 class="text-4xl font-black uppercase tracking-tighter text-slate-900 leading-none">
                    {{ $employee->last_name }}
                </h1>
                <div class="h-1.5 w-16 bg-accent mx-auto my-3 rounded-full"></div>
                <h2 class="text-2xl font-extrabold uppercase text-accent">
                    {{ $employee->first_name }}
                </h2>
            </div>
            
            <div class="bg-slate-100 px-5 py-2 rounded-xl border border-slate-200">
                <p class="text-[11px] font-black text-slate-700 uppercase tracking-widest">
                    {{ $employee->function ?? 'Développeur' }}
                </p>
            </div>
        </div>

        <div class="w-full h-20 flex-none flex items-end justify-center relative z-10">
            <div class="absolute inset-0 bg-accent" style="clip-path: polygon(0 100%, 100% 100%, 100% 0);"></div>
            <div class="relative pb-6 flex flex-col items-center">
                <span class="text-white font-mono font-black tracking-[0.4em] text-sm shadow-sm">
                    {{ $employee->matricule }}
                </span>
            </div>
        </div>
    </div>

</body>
</html>
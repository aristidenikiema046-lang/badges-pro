@php 
    $mainColor = $employee->company->badge_color ?? '#059669'; 
    $qrData = "NOM: {$employee->last_name}\n"
            . "PRENOM: {$employee->first_name}\n"
            . "POSTE: {$employee->function}\n"
            . "ID: {$employee->matricule}";
@endphp

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .badge-vertical { width: 350px; height: 550px; font-family: 'sans-serif'; }
        @media print { .no-print { display: none; } body { background: white; } }
        
        /* Bandes latérales colorées */
        .side-bar {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 12px;
            background-color: {{ $mainColor }};
        }
        .text-accent { color: {{ $mainColor }}; filter: brightness(0.7); }
    </style>
</head>
<body class="bg-gray-100 flex flex-col items-center justify-center min-h-screen gap-4">

    <div class="no-print">
        <button onclick="window.print()" class="bg-slate-800 text-white px-8 py-3 rounded-full hover:bg-black transition shadow-xl font-bold uppercase text-sm">
            Imprimer ce Badge
        </button>
    </div>

    <div class="badge-vertical relative bg-white flex flex-col items-center overflow-hidden shadow-2xl rounded-[2.5rem] border border-gray-200">
        
        <div class="side-bar left-0"></div>
        <div class="side-bar right-0"></div>

        <div class="w-full pt-8 flex-none flex justify-center z-10">
            @if($employee->company && $employee->company->logo)
                <img src="{{ asset('storage/' . $employee->company->logo) }}" class="h-10 object-contain">
            @endif
        </div>

        <div class="relative mt-6 z-10">
            <div class="w-44 h-44 rounded-full shadow-2xl overflow-hidden bg-gray-100 border-4 border-white ring-4" style="--tw-ring-color: {{ $mainColor }}22">
                @if($employee->photo)
                    <img src="{{ asset('storage/' . $employee->photo) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                        <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                    </div>
                @endif
            </div>
        </div>

        <div class="absolute right-4 top-1/2 -translate-y-1/2 flex items-center justify-center z-20">
            <span class="rotate-90 origin-center whitespace-nowrap font-mono font-black text-slate-300 text-lg tracking-[0.5em] uppercase">
                {{ $employee->matricule }}
            </span>
        </div>

        <div class="flex-grow flex flex-col items-center justify-center w-full px-12 text-center z-10">
            
            <div class="mb-4">
                <h1 class="text-3xl font-black uppercase tracking-tighter text-slate-900 leading-none">
                    {{ $employee->last_name }}
                </h1>
                <h2 class="text-xl font-bold uppercase text-accent mt-1">
                    {{ $employee->first_name }}
                </h2>
            </div>
            
            <div class="inline-block px-4 py-1 rounded-full mb-6" style="background-color: {{ $mainColor }}15">
                <p class="text-[10px] font-black text-slate-600 uppercase tracking-widest">
                    {{ $employee->function ?? 'Collaborateur' }}
                </p>
            </div>

            <div class="bg-white p-2 rounded-xl shadow-md border border-gray-100">
                {!! QrCode::size(90)->margin(1)->generate($qrData) !!}
            </div>
        </div>

        <div class="w-full h-10 flex-none z-10 flex items-center justify-center" style="background-color: {{ $mainColor }}">
             <div class="h-1 w-20 bg-white/30 rounded-full"></div>
        </div>
    </div>

</body>
</html>
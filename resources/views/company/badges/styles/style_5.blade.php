@php 
    $mainColor = $employee->company->badge_color ?? '#059669'; 
    
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
        .text-accent { color: {{ $mainColor }}; filter: brightness(0.7); }
        .bg-accent { background-color: {{ $mainColor }}; }
    </style>
</head>
<body class="bg-gray-100 flex flex-col items-center justify-center min-h-screen gap-4 p-4">

    <div class="no-print">
        <button onclick="window.print()" class="bg-slate-800 text-white px-8 py-3 rounded-full hover:bg-black transition shadow-xl font-bold uppercase text-sm">
            Imprimer le Badge
        </button>
    </div>

    <div class="badge-vertical relative bg-white flex flex-col items-center overflow-hidden shadow-2xl rounded-[2.5rem] border border-gray-200">
        
        {{-- Header : Logo --}}
        <div class="w-full pt-6 flex-none flex justify-center z-10">
            @if($employee->company && $employee->company->logo)
                <img src="{{ asset('storage/' . $employee->company->logo) }}" class="h-8 object-contain">
            @else
                <span class="font-black text-xs uppercase tracking-widest text-slate-400">
                    {{ $employee->company->name ?? 'YA CONSULTING' }}
                </span>
            @endif
        </div>

        <div class="relative mt-4 z-10">
            <div class="w-44 h-44 rounded-full border-4 shadow-xl overflow-hidden bg-gray-100" style="border-color: {{ $mainColor }}">
                @if($employee->photo)
                    <img src="{{ asset('storage/' . $employee->photo) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                        <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                    </div>
                @endif
            </div>
            <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 bg-slate-900 text-white px-4 py-1 rounded-full text-xs font-mono font-bold shadow-lg border-2 border-white">
                ID: {{ $employee->matricule }}
            </div>
        </div>

        <div class="flex-grow flex flex-col items-center justify-center w-full px-8 text-center z-10">
            
            <div class="mb-4">
                <h1 class="text-3xl font-black uppercase tracking-tighter text-slate-900 leading-none mb-1">
                    {{ $employee->last_name }}
                </h1>
                <h2 class="text-xl font-bold uppercase text-accent">
                    {{ $employee->first_name }}
                </h2>
                <div class="h-1 w-12 bg-slate-200 mx-auto mt-3 rounded-full"></div>
            </div>
            
            <p class="text-[11px] font-black text-slate-500 uppercase tracking-widest mb-6">
                {{ $employee->function ?? 'Collaborateur' }}
            </p>

            <div class="bg-white p-2 rounded-2xl shadow-md border border-gray-100">
                {!! QrCode::size(80)->margin(1)->generate($qrData) !!}
            </div>
        </div>

        <div class="w-full h-12 flex-none relative z-10">
            <div class="absolute inset-0 bg-accent opacity-90" style="clip-path: polygon(0 100%, 100% 100%, 100% 0);"></div>
            <div class="absolute inset-0 flex items-center justify-center">
                 <span class="text-[10px] text-white font-bold uppercase tracking-[0.5em] pl-4">Authentifié</span>
            </div>
        </div>
    </div>

</body>
</html>
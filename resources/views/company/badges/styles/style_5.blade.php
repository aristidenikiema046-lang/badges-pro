@php 
    // Couleur principale dynamique ou un bleu nuit élégant par défaut
    $mainColor = $employee->company->badge_color ?? '#1e293b'; 
    
    // Données QR Code complètes
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
            Imprimer le Badge
        </button>
    </div>

    <div class="badge-vertical relative bg-white flex flex-col items-center overflow-hidden shadow-2xl rounded-[2.5rem] border-2" style="border-color: {{ $mainColor }}22">
        
        <div class="w-full pt-8 flex-none flex items-center justify-center gap-3 z-10 px-6">
            @if($employee->company && $employee->company->logo)
                <img src="{{ asset('storage/' . $employee->company->logo) }}" class="h-10 w-auto object-contain">
            @endif
            <span class="font-black text-lg uppercase tracking-tight" style="color: {{ $mainColor }}">
                {{ $employee->company->name ?? 'ENTREPRISE' }}
            </span>
        </div>

        <div class="relative mt-6 z-10">
            <div class="w-40 h-40 border-4 shadow-xl overflow-hidden bg-gray-100 rounded-3xl" 
                 style="border-color: {{ $mainColor }};">
                @if($employee->photo)
                    <img src="{{ asset('storage/' . $employee->photo) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                        <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                    </div>
                @endif
            </div>
        </div>

        <div class="mt-6 text-center z-10">
            <h1 class="text-3xl font-black uppercase tracking-tight text-slate-900 leading-none">
                {{ $employee->last_name }}
            </h1>
            <h2 class="text-xl font-bold uppercase mt-1" style="color: {{ $mainColor }}">
                {{ $employee->first_name }}
            </h2>
            <p class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mt-2">
                {{ $employee->function ?? 'Collaborateur' }}
            </p>
        </div>

        <div class="mt-4 mb-4 z-10">
            <div class="bg-white p-2 rounded-2xl shadow-lg border border-gray-100">
                {!! QrCode::size(100)->margin(1)->generate($qrData) !!}
            </div>
        </div>

        <div class="w-full flex-grow flex items-end justify-center relative z-10 pb-6">
            <div class="bg-slate-900 text-white px-8 py-2 rounded-full text-sm font-mono font-bold shadow-lg border-2 border-white">
                MATRICULE : {{ $employee->matricule }}
            </div>
        </div>

        <div class="absolute bottom-0 w-full h-32 opacity-10" style="background-color: {{ $mainColor }}; clip-path: polygon(0 100%, 100% 100%, 100% 0);"></div>
    </div>

</body>
</html>
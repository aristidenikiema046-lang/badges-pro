@php 
    $mainColor = $mainColor ?? ($employee->company->badge_color ?? '#1e293b'); 
    
    $qrData = "NOM: {$employee->last_name}\n"
            . "PRENOM: {$employee->first_name}\n"
            . "POSTE: {$employee->function}\n"
            . "ID: {$employee->matricule}\n"
            . "ENTREPRISE: " . ($employee->company->name ?? 'YA CONSULTING');
@endphp

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .badge-vertical {
            width: 100%;
            max-width: 400px;
            aspect-ratio: 4/6.5;
            font-family: sans-serif;
        }
        @media print {
            .no-print { display: none; }
            body { background: white; padding: 0; }
            .badge-vertical { shadow: none; border: 1px solid #eee; margin: 0; }
        }
    </style>
</head>
<body class="bg-gray-200 flex flex-col items-center justify-center min-h-screen gap-4 p-4">

    <div class="no-print">
        <button onclick="window.print()" class="bg-slate-900 text-white px-8 py-3 rounded-full hover:bg-black transition shadow-2xl font-black uppercase text-xs tracking-widest">
            Imprimer le Badge
        </button>
    </div>

    <div class="badge-vertical relative flex flex-col items-center overflow-hidden shadow-2xl rounded-[2.5rem] border-2 bg-[#f8fafc]" style="border-color: {{ $mainColor }}33">
        
        {{-- Header --}}
        <div class="w-full pt-8 flex flex-col items-center gap-2 z-10 px-6 text-center">
            @if($employee->company && $employee->company->logo)
                <img src="{{ asset('storage/' . $employee->company->logo) }}" class="h-8 w-auto object-contain">
            @endif
            @if(!isset($hideCompanyName) || !$hideCompanyName)
                <h3 class="font-black text-sm uppercase tracking-widest leading-tight" style="color: {{ $mainColor }}">
                    {{ $employee->company->name ?? 'YA CONSULTING' }}
                </h3>
            @endif
        </div>

        {{-- Photo --}}
        <div class="relative mt-4 z-10 w-full flex justify-center">
            <div class="w-32 h-32 sm:w-44 sm:h-44 shadow-2xl overflow-hidden bg-white rounded-3xl border-2 border-white ring-8 ring-slate-100">
                @if($employee->photo)
                    <img src="{{ asset('storage/' . $employee->photo) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-slate-200">
                        <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path></svg>
                    </div>
                @endif
            </div>
        </div>

        {{-- Infos --}}
        <div class="mt-4 text-center z-10 w-full px-6">
            <h1 class="text-2xl sm:text-3xl font-black uppercase tracking-tighter text-slate-900 leading-none">
                {{ $employee->last_name }}
            </h1>
            <h2 class="text-lg sm:text-xl font-bold uppercase mt-1" style="color: {{ $mainColor }}">
                {{ $employee->first_name }}
            </h2>
            <div class="mt-3 inline-block bg-slate-200/50 px-4 py-1 rounded-md">
                <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest">
                    {{ $employee->function ?? 'COLLABORATEUR' }}
                </p>
            </div>
        </div>

        {{-- Matricule --}}
        <div class="mt-4 z-10">
            <div class="bg-slate-950 text-white px-6 py-2 rounded-2xl text-base sm:text-lg font-mono font-black shadow-xl border-b-4 border-slate-700">
                {{ $employee->matricule }}
            </div>
        </div>

        {{-- QR Code --}}
        <div class="mt-4 mb-12 z-10">
            <div class="bg-white p-2 rounded-2xl shadow-lg border border-slate-100">
                {!! QrCode::size(70)->margin(1)->generate($qrData) !!}
            </div>
        </div>

        {{-- Décoration pied de page --}}
        <div class="absolute bottom-0 w-full h-12 z-0" style="background-color: {{ $mainColor }}; clip-path: polygon(0 100%, 100% 100%, 100% 0);"></div>
    </div>

</body>
</html>
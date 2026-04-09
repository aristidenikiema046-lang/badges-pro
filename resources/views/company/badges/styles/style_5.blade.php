@php 
    // Couleur principale dynamique (YA-CONSULTING ou Entreprise)
    $mainColor = $employee->company->badge_color ?? '#1e293b'; 
    
    // Données QR Code
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
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Dimensions agrandies (400px) pour éviter les coupures de texte */
        .badge-vertical {
            width: 400px; 
            height: 650px;
            font-family: 'sans-serif';
        }
        @media print {
            .no-print { display: none; }
            body { background: white; padding: 0; }
            .badge-vertical { shadow: none; border: 1px solid #eee; margin: 0; }
        }
        /* Teinte de fond Slate-50 pour le contraste */
        .bg-custom-slate { background-color: #f8fafc; }
    </style>
</head>
<body class="bg-gray-200 flex flex-col items-center justify-center min-h-screen gap-4 p-6">

    <div class="no-print">
        <button onclick="window.print()" class="bg-slate-900 text-white px-10 py-4 rounded-full hover:bg-black transition shadow-2xl font-black uppercase text-sm tracking-widest">
            Imprimer le Badge Format Large
        </button>
    </div>

    <div class="badge-vertical relative flex flex-col items-center overflow-hidden shadow-2xl rounded-[3.5rem] border-2 bg-custom-slate" style="border-color: {{ $mainColor }}33">
        
        <div class="w-full pt-10 flex flex-col items-center gap-2 z-10 px-10 text-center">
            @if($employee->company && $employee->company->logo)
                <img src="{{ asset('storage/' . $employee->company->logo) }}" class="h-12 w-auto object-contain">
            @endif
            <h3 class="font-black text-lg uppercase tracking-widest leading-tight" style="color: {{ $mainColor }}">
                {{ $employee->company->name ?? 'YA CONSULTING' }}
            </h3>
        </div>

        <div class="relative mt-6 z-10">
            <div class="w-48 h-48 shadow-2xl overflow-hidden bg-white rounded-3xl border-2 border-white ring-8 ring-slate-100">
                @if($employee->photo)
                    <img src="{{ asset('storage/' . $employee->photo) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-slate-200">
                        <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                    </div>
                @endif
            </div>
        </div>

        <div class="mt-8 text-center z-10 w-full px-6">
            <h1 class="text-4xl font-black uppercase tracking-tighter text-slate-900 leading-none">
                {{ $employee->last_name }}
            </h1>
            <h2 class="text-2xl font-bold uppercase mt-2" style="color: {{ $mainColor }}">
                {{ $employee->first_name }}
            </h2>
            <div class="mt-3 inline-block bg-slate-200/50 px-4 py-1 rounded-md">
                <p class="text-[12px] font-black text-slate-500 uppercase tracking-widest">
                    {{ $employee->function ?? 'COLLABORATEUR' }}
                </p>
            </div>
        </div>

        <div class="mt-6 z-10">
            <div class="bg-slate-950 text-white px-10 py-3 rounded-2xl text-xl font-mono font-black shadow-xl tracking-tighter border-b-4 border-slate-700">
                {{ $employee->matricule }}
            </div>
        </div>

        <div class="mt-6 mb-10 z-10">
            <div class="bg-white p-3 rounded-2xl shadow-lg border border-slate-100">
                {!! QrCode::size(95)->margin(1)->generate($qrData) !!}
            </div>
        </div>

        <div class="absolute bottom-0 w-full h-16 z-0" style="background-color: {{ $mainColor }}; clip-path: polygon(0 100%, 100% 100%, 100% 0);"></div>
    </div>

</body>
</html>
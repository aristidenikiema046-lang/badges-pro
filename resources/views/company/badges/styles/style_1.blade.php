@php 
    // Bleu Paymetrust par défaut (#1e3a8a), ou couleur personnalisée de l'entreprise
    $mainColor = $employee->company->badge_color ?? '#1e3a8a'; 
    
    // Données complètes pour le QR Code (Nom, Prénom, ID)
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
        /* Dimensions fixes pour carte standard CR80 (Format Carte Bancaire) */
        .badge-horizontal {
            width: 85.6mm;
            height: 54mm;
            font-family: 'sans-serif';
        }

        /* Reproduction exacte du motif de circuits (Zone entourée en vert) */
        .circuit-bg {
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 100%; /* Couvre tout le badge */
            pointer-events: none;
            z-index: 0;
            opacity: 0.2; /* Très léger, comme sur le modèle */
            
            /* SVG direct pour une précision maximale et compatibilité d'impression */
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%"><g fill="none" stroke="{{ urlencode($mainColor) }}" stroke-width="1.5"><path d="M0 20H40L60 40H80M0 60H30L50 80H110M20 0V30L40 50M100 0V150" stroke-linecap="round"/><circle cx="40" cy="50" r="3" fill="{{ urlencode($mainColor) }}"/></g></svg>');
            background-repeat: no-repeat;
            background-position: left top;
            background-size: contain;
        }

        @media print {
            .no-print { display: none; }
            body { background: white; padding: 0; }
            .badge-horizontal { shadow: none; border: 1px solid #eee; margin: 0; overflow: visible !important; }
        }
    </style>
</head>
<body class="bg-gray-100 flex flex-col items-center justify-center min-h-screen gap-6 p-10">

    <div class="no-print">
        <button onclick="window.print()" class="flex items-center gap-2 bg-slate-800 text-white px-6 py-2 rounded-full hover:bg-black transition shadow-lg font-bold">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 00-2 2h2m2 4h10a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            IMPRIMER LE BADGE
        </button>
    </div>

    <div class="badge-horizontal bg-white shadow-2xl overflow-hidden flex relative rounded-2xl border border-gray-100 mx-auto">
        
        <div class="circuit-bg"></div>

        <div class="w-[42%] relative flex items-center justify-center p-6 z-10">
            {{-- Photo rectangulaire aux coins très arrondis, comme Fatou Sow --}}
            <div class="w-full h-full rounded-[2rem] overflow-hidden shadow-2xl border-4 border-white bg-white">
                @if($employee->photo)
                    <img src="{{ asset('storage/' . $employee->photo) }}" class="w-full h-full object-cover">
                @else
                    {{-- Placeholder épuré si pas de photo --}}
                    <div class="w-full h-full flex items-center justify-center bg-gray-50 text-gray-300">
                        <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path></svg>
                    </div>
                @endif
            </div>
        </div>

        <div class="w-[58%] flex flex-col p-6 justify-between text-right z-10 bg-white/60 backdrop-blur-sm rounded-r-2xl">
            
            <div class="flex items-center justify-end gap-3 mb-2 border-b border-gray-100 pb-3">
                <span class="font-bold text-lg text-slate-700 tracking-tight">
                    {{ $employee->company->name ?? 'YA CONSULTING' }}
                </span>
                @if($employee->company && $employee->company->logo)
                    <img src="{{ asset('storage/' . $employee->company->logo) }}" class="h-10 w-auto object-contain">
                @endif
            </div>

            <div class="flex-grow flex flex-col justify-center">
                {{-- Nom et Prénom en gros caractère noir et gras --}}
                <h1 class="text-2xl font-black uppercase text-slate-950 tracking-tighter leading-none mb-1">
                    {{ $employee->last_name }} {{ $employee->first_name }}
                </h1>
                
                {{-- Poste en bleu principale --}}
                <p class="text-md font-bold mt-1" style="color: {{ $mainColor }}">
                    {{ $employee->function ?? 'Collaborateur' }}
                </p>
                
                {{-- Matricule en petit --}}
                <p class="text-[10px] font-mono font-bold text-slate-500 mt-2">
                    Matricule : <span class="text-slate-700">{{ $employee->matricule }}</span>
                </p>
            </div>

            <div class="flex justify-between items-end mt-2 pt-2 border-t border-gray-100">
                {{-- Département (à gauche du bas) --}}
                <div class="text-left">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest leading-none">Identité Digitale</p>
                    <p class="text-[10px] font-bold text-slate-600 italic leading-none">{{ $employee->department ?? 'Standard' }}</p>
                </div>

                {{-- QR Code (Design épuré, en bas à droite) --}}
                <div class="p-1.5 bg-white border border-gray-100 rounded-xl shadow-sm flex items-center justify-center">
                    {!! QrCode::size(70)->margin(0)->generate($qrData) !!}
                </div>
            </div>
        </div>
    </div>

</body>
</html>
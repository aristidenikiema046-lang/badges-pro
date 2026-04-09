@php 
    // Couleur principale dynamique (Bleu Paymetrust par défaut)
    $mainColor = $employee->company->badge_color ?? '#1e3a8a'; 
    
    // Données pour le QR code
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
        /* Format standard Carte de Visite (Horizontal) */
        .badge-horizontal {
            width: 85mm;
            height: 55mm;
            font-family: 'sans-serif';
        }

        /* Motif de circuits technologiques précis (Zone entourée en vert) */
        .circuit-bg {
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 100%; /* Couvre tout le fond */
            pointer-events: none;
            z-index: 0;
            opacity: 0.15; /* Très léger pour un rendu professionnel */
            background-image: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%"><g fill="none" stroke="{{ urlencode($mainColor) }}" stroke-width="1.5"><path d="M0 20 L40 20 L60 40 M0 60 L30 60 L50 80 M20 0 V30 L40 50 M100 0 V200 M80 350 L120 310" stroke-linecap="round"/><circle cx="40" cy="50" r="3" fill="{{ urlencode($mainColor) }}"/></g></svg>');
        }

        @media print {
            .no-print { display: none; }
            body { background: white; padding: 0; }
            .badge-horizontal { shadow: none; border: 1px solid #eee; margin: 0; overflow: visible !important; }
        }
    </style>
</head>
<body class="bg-gray-100 flex flex-col items-center justify-center min-h-screen gap-6 p-10">

    <div class="no-print text-center">
        <button onclick="window.print()" class="bg-slate-800 text-white px-6 py-2 rounded-full font-bold shadow-lg hover:bg-black transition">
            Imprimer le Badge Format Carte
        </button>
    </div>

    <div class="badge-horizontal bg-white shadow-2xl overflow-hidden flex relative rounded-[2rem] border border-gray-100">
        
        <div class="circuit-bg"></div>

        <div class="w-[42%] relative flex items-center justify-center p-6 z-10">
            {{-- Photo rectangulaire aux coins très arrondis --}}
            <div class="w-full h-full rounded-[2rem] overflow-hidden shadow-2xl bg-white border-2 border-white">
                @if($employee->photo)
                    <img src="{{ asset('storage/' . $employee->photo) }}" class="w-full h-full object-cover">
                @else
                    {{-- Placeholder si pas de photo --}}
                    <div class="w-full h-full flex items-center justify-center text-gray-300 bg-gray-50">
                        <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                    </div>
                @endif
            </div>
        </div>

        <div class="w-[58%] flex flex-col p-6 justify-between text-right z-10">
            
            <div class="flex items-center justify-end gap-3 mb-2">
                @if($employee->company && $employee->company->logo)
                    <img src="{{ asset('storage/' . $employee->company->logo) }}" class="h-10 w-auto object-contain">
                @endif
                <span class="font-bold text-xl text-slate-700 tracking-tight">
                    {{ $employee->company->name ?? 'YA CONSULTING' }}
                </span>
            </div>

            <div class="flex-grow flex flex-col justify-center">
                {{-- Nom et Prénom en gros caractère noir et gras --}}
                <h1 class="text-3xl font-black uppercase text-slate-950 tracking-tighter leading-none mb-1">
                    {{ $employee->last_name }} {{ $employee->first_name }}
                </h1>
                
                {{-- Poste en couleur principale --}}
                <p class="text-lg font-bold" style="color: {{ $mainColor }}">
                    {{ $employee->function ?? 'Poste non défini' }}
                </p>
                
                {{-- Matricule en petit --}}
                <p class="text-xs font-mono font-bold text-slate-500 mt-2">
                    Matricule : {{ $employee->matricule }}
                </p>
            </div>

            <div class="flex justify-between items-end mt-2 pt-2 border-t border-gray-100">
                {{-- Département (à gauche du bas) --}}
                <div class="text-left">
                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Identité Digitale</p>
                    <p class="text-[10px] font-bold text-slate-600 italic">{{ $employee->department ?? 'Standard' }}</p>
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
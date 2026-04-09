@php 
    // Couleur principale dynamique pour les sous-titres (Bleu Paymetrust par défaut)
    $mainColor = $employee->company->badge_color ?? '#1e3a8a'; 
    
    // Données QR Code complètes (Nom, Poste, ID)
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
        /* Format standard Carte Bancaire (Horizontal) */
        .badge-horizontal {
            width: 85.6mm;
            height: 54mm;
            font-family: 'sans-serif';
        }
        @media print {
            .no-print { display: none; }
            body { background: white; padding: 0; }
            .badge-horizontal { shadow: none; border: 1px solid #eee; margin: 0; }
        }
    </style>
</head>
<body class="bg-gray-100 flex flex-col items-center justify-center min-h-screen gap-6 p-10">

    <div class="no-print text-center">
        <button onclick="window.print()" class="bg-slate-800 text-white px-6 py-2 rounded-full font-bold shadow-lg hover:bg-black transition">
            Imprimer le Badge Format Carte
        </button>
    </div>

    <div class="badge-horizontal bg-white shadow-2xl overflow-hidden flex relative rounded-2xl border border-gray-100">
        
        <div class="w-[40%] relative flex items-center justify-center p-4">
            {{-- Photo rectangulaire aux coins arrondis --}}
            <div class="w-full h-full rounded-2xl overflow-hidden shadow-lg bg-gray-50 border border-gray-100">
                @if($employee->photo)
                    <img src="{{ asset('storage/' . $employee->photo) }}" class="w-full h-full object-cover">
                @else
                    {{-- Placeholder si pas de photo --}}
                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                        <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                    </div>
                @endif
            </div>
        </div>

        <div class="w-[60%] flex flex-col p-6 justify-between text-right">
            
            <div class="flex items-center justify-end gap-2 mb-2">
                @if($employee->company && $employee->company->logo)
                    <img src="{{ asset('storage/' . $employee->company->logo) }}" class="h-8 w-auto object-contain">
                @endif
                <span class="font-bold text-lg text-slate-700 tracking-tight">
                    {{ $employee->company->name ?? 'YA CONSULTING' }}
                </span>
            </div>

            <div class="flex-grow flex flex-col justify-center">
                {{-- Nom et Prénom en gras et noir --}}
                <h1 class="text-2xl font-extrabold uppercase text-slate-900 tracking-tighter leading-tight">
                    {{ $employee->first_name }} {{ $employee->last_name }}
                </h1>
                
                {{-- Poste en couleur principale --}}
                <p class="text-md font-bold mt-1" style="color: {{ $mainColor }}">
                    {{ $employee->function ?? 'Collaborateur' }}
                </p>
                
                {{-- Matricule en petit --}}
                <p class="text-xs font-mono font-bold text-slate-500 mt-2">
                    Matricule : {{ $employee->matricule }}
                </p>
            </div>

            <div class="flex justify-between items-end mt-2">
                {{-- Département (à gauche du bas) --}}
                <div class="text-left">
                    <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Digital ID</p>
                    <p class="text-[9px] font-bold text-slate-500 italic">{{ $employee->department ?? 'Standard' }}</p>
                </div>

                {{-- QR Code (Design épuré, en bas à droite) --}}
                <div class="p-1.5 bg-white border rounded-xl shadow-sm flex items-center justify-center">
                    {!! QrCode::size(65)->margin(0)->generate($qrData) !!}
                </div>
            </div>
        </div>
    </div>

</body>
</html>
@php 
    // Sécurité : récupération de la couleur principale de l'entreprise ou vert émeraude par défaut
    $mainColor = $employee->company->badge_color ?? '#059669'; 
    
    // Préparation des données pour le QR Code (Nom, Poste, Matricule, Entreprise)
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
        /* Format vertical standard pour badge porté avec un lanyard */
        .badge-vertical {
            width: 350px;
            height: 550px;
            font-family: 'sans-serif';
        }
        /* Style pour masquer le bouton d'impression lors de l'impression physique/PDF */
        @media print {
            .no-print { display: none; }
            body { background: white; padding: 0; }
            .badge-vertical { shadow: none; border: 1px solid #eee; margin: 0; }
        }
        /* Filtre pour assombrir légèrement la couleur d'accentuation pour le texte (lisibilité) */
        .text-accent { color: {{ $mainColor }}; filter: brightness(0.7); }
    </style>
</head>
<body class="bg-gray-100 flex flex-col items-center justify-center min-h-screen gap-4 p-4">

    <div class="no-print">
        <button onclick="window.print()" class="flex items-center gap-2 bg-slate-800 text-white px-8 py-3 rounded-full hover:bg-black transition shadow-xl font-bold uppercase text-sm tracking-widest">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 00-2 2h2m2 4h10a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            Imprimer ce Badge
        </button>
    </div>

    <div class="badge-vertical relative bg-white flex flex-col items-center overflow-hidden shadow-2xl rounded-[2.5rem] border border-gray-100">
        
        <div class="w-full pt-10 flex-none flex justify-center z-10 px-6">
            @if($employee->company && $employee->company->logo)
                <div class="bg-white px-6 py-2 rounded-full shadow-sm border border-gray-50 text-center">
                    <img src="{{ asset('storage/' . $employee->company->logo) }}" class="h-8 w-auto object-contain mx-auto">
                </div>
            @else
                 <div class="bg-white px-6 py-2 rounded-full shadow-sm border border-gray-50 font-black text-xs uppercase text-slate-400">
                    {{ $employee->company->name ?? 'YA CONSULTING' }}
                </div>
            @endif
        </div>

        <div class="relative mt-1 z-10">
            {{-- Cercle photo simple --}}
            <div class="w-44 h-44 rounded-full shadow-xl overflow-hidden bg-gray-100">
                @if($employee->photo)
                    <img src="{{ asset('storage/' . $employee->photo) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                        <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                    </div>
                @endif
            </div>
            
            <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 bg-slate-900 text-white px-5 py-1.5 rounded-full text-sm font-mono font-bold shadow-lg border-2 border-white">
                {{ $employee->matricule }}
            </div>
        </div>

        <div class="flex-grow flex flex-col items-center justify-center w-full px-8 text-center z-10">
            
            <div class="mb-5">
                {{-- Nom de famille : Forcé en Noir profond pour lisibilité --}}
                <h1 class="text-3xl font-black uppercase tracking-tighter text-slate-900 leading-none mb-1">
                    {{ $employee->last_name }}
                </h1>
                {{-- Prénom : Couleur de l'accentuation (assombrie légèrement pour lisibilité) --}}
                <h2 class="text-xl font-bold uppercase text-accent">
                    {{ $employee->first_name }}
                </h2>
                <div class="h-1.5 w-14 bg-slate-200 mx-auto mt-4 rounded-full"></div>
            </div>
            
            {{-- Fonction / Poste --}}
            <div class="bg-slate-50 px-4 py-1 rounded-lg border border-slate-100">
                <p class="text-[11px] font-black text-slate-600 uppercase tracking-widest">
                    {{ $employee->function ?? 'Collaborateur' }}
                </p>
            </div>

            <div class="bg-white p-2 rounded-2xl shadow-md border border-gray-100 mt-8">
                {!! QrCode::size(85)->margin(1)->generate($qrData) !!}
            </div>
        </div>

        <div class="w-full h-12 flex-none relative z-10">
            <div class="absolute inset-0 opacity-90" style="background-color: {{ $mainColor }}; clip-path: polygon(0 100%, 100% 100%, 100% 0);"></div>
            {{-- La section est vide comme demandé --}}
        </div>
    </div>

</body>
</html>
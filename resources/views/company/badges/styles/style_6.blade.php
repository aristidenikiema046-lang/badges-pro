@php 
    $mainColor = $mainColor ?? ($employee->company->badge_color ?? '#000000'); 
    
    $qrData = "NOM: {$employee->last_name}\n"
            . "PRENOM: {$employee->first_name}\n"
            . "POSTE: {$employee->function}\n"
            . "ID: {$employee->matricule}\n"
            . "ENTREPRISE: " . ($employee->company->name ?? 'N/A');
@endphp

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .badge-container {
            width: 100%;
            max-width: 600px;
            aspect-ratio: 1.7 / 1;
            font-family: sans-serif;
        }
        .sidebar-pattern {
            background-image: url('https://www.transparenttextures.com/patterns/cubes.png');
        }
        @media print {
            .no-print { display: none; }
            body { background: white; }
            .badge-container { box-shadow: none !important; border: 1px solid #eee; }
        }
        /* Ajustements pour très petits écrans */
        @media (max-width: 480px) {
            .badge-container { aspect-ratio: auto; min-height: 250px; flex-direction: column; }
            .sidebar-side { width: 100% !important; height: 120px; }
            .content-side { width: 100% !important; padding: 1rem !important; }
        }
    </style>
</head>
<body class="bg-gray-100 flex flex-col items-center justify-center min-h-screen gap-6 p-4">

    <div class="no-print">
        <button onclick="window.print()" class="flex items-center gap-2 bg-slate-800 text-white px-6 py-2 rounded-full hover:bg-black transition shadow-lg font-bold uppercase text-xs tracking-widest">
            Imprimer le badge
        </button>
    </div>

    <div class="badge-container bg-white shadow-2xl overflow-hidden flex relative border-2 mx-auto rounded-[1.5rem]" 
         style="border-color: {{ $mainColor }}">
        
        {{-- Partie gauche : Photo --}}
        <div class="sidebar-side w-2/5 relative flex items-center justify-center" style="background-color: {{ $mainColor }}">
            <div class="absolute inset-0 opacity-20 sidebar-pattern"></div>
            <div class="z-10 relative">
                @if($employee->photo)
                    <img src="{{ asset('storage/' . $employee->photo) }}" 
                         class="w-24 h-24 sm:w-44 sm:h-56 rounded-full object-cover shadow-2xl border-4 border-white">
                @else
                    <div class="w-24 h-24 sm:w-44 sm:h-56 rounded-full bg-white flex items-center justify-center text-[10px] text-gray-400 font-bold border-2 border-dashed border-gray-200">
                        SANS PHOTO
                    </div>
                @endif
            </div>
        </div>

        {{-- Partie droite : Informations --}}
        <div class="content-side w-3/5 flex flex-col p-4 sm:p-8 justify-between bg-white relative">
            <div class="flex items-center gap-2 sm:gap-4 justify-end border-b pb-2 sm:pb-4">
                <div class="text-right">
                    @if(!isset($hideCompanyName) || !$hideCompanyName)
                        <p class="font-black text-sm sm:text-2xl uppercase leading-none" style="color: {{ $mainColor }}">
                            {{ $employee->company->name ?? 'ENTREPRISE' }}
                        </p>
                    @endif
                    <p class="text-[8px] text-gray-400 font-bold tracking-[0.2em] mt-1 uppercase">Carte Pro</p>
                </div>
                @if($employee->company && $employee->company->logo)
                    <img src="{{ asset('storage/' . $employee->company->logo) }}" class="h-8 w-8 sm:h-14 sm:w-14 object-contain">
                @endif
            </div>

            <div class="flex-grow flex flex-col justify-center py-2">
                <p class="text-gray-400 text-[8px] font-black uppercase tracking-widest mb-1">Nom & Prénoms</p>
                <p class="text-lg sm:text-3xl font-extrabold text-slate-900 leading-tight uppercase truncate">
                    {{ $employee->first_name }} {{ $employee->last_name }}
                </p>
                
                <div class="flex gap-4 mt-2">
                    <div>
                        <p class="text-gray-400 text-[7px] font-black uppercase">Fonction</p>
                        <p class="text-[10px] sm:text-sm font-bold uppercase truncate" style="color: {{ $mainColor }}">
                            {{ $employee->function ?? 'Collaborateur' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-[7px] font-black uppercase">Matricule</p>
                        <p class="text-[10px] sm:text-sm font-mono font-bold text-slate-700">{{ $employee->matricule }}</p>
                    </div>
                </div>
            </div>

            <div class="flex justify-end items-end pb-2">
                <div class="bg-white p-1 border-2 rounded-xl shadow-sm" style="border-color: {{ $mainColor }}">
                    {!! QrCode::size(50)->margin(0)->generate($qrData) !!}
                </div>
            </div>
        </div>
    </div>

</body>
</html>
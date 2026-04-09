@php 
    $mainColor = $mainColor ?? ($employee->company->badge_color ?? '#000000'); 
    
    // Préparation des données pour le QR Code (Nom, Poste, Matricule, Entreprise)
    $qrData = "NOM: {$employee->last_name}\n"
            . "PRENOM: {$employee->first_name}\n"
            . "POSTE: {$employee->function}\n"
            . "ID: {$employee->matricule}\n"
            . "ENTREPRISE: " . ($employee->company->name ?? 'N/A');
@endphp

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .badge-container {
            width: 600px;
            height: 350px;
            font-family: 'sans-serif';
        }
        .sidebar-pattern {
            background-image: url('https://www.transparenttextures.com/patterns/cubes.png');
        }
        /* Style pour masquer le bouton lors de l'impression réelle */
        @media print {
            .no-print { display: none; }
            body { background: white; }
            .badge-container { shadow: none; border: 1px solid #eee; }
        }
    </style>
</head>
<body class="bg-gray-100 flex flex-col items-center justify-center min-h-screen gap-6">

    <div class="no-print">
        <button onclick="window.print()" class="flex items-center gap-2 bg-slate-800 text-white px-6 py-2 rounded-full hover:bg-black transition shadow-lg font-bold">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 00-2 2h2m2 4h10a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            IMPRIMER LE BADGE
        </button>
    </div>

    <div class="badge-container bg-white shadow-2xl overflow-hidden flex relative border-2 mx-auto rounded-[1.5rem]" 
         style="border-color: {{ $mainColor }}">
        
        <div class="w-2/5 relative flex items-center justify-center" style="background-color: {{ $mainColor }}">
            <div class="absolute inset-0 opacity-20 sidebar-pattern"></div>
            <div class="z-10 relative">
                @if($employee->photo)
                    <img src="{{ asset('storage/' . $employee->photo) }}" 
                         class="w-44 h-56 rounded-full object-cover shadow-2xl border-4 border-white">
                @else
                    <div class="w-44 h-56 rounded-full bg-white flex items-center justify-center text-gray-400 font-bold border-2 border-dashed border-gray-200">
                        SANS PHOTO
                    </div>
                @endif
            </div>
            <div class="absolute -bottom-10 -left-10 w-32 h-32 rounded-full opacity-30 bg-white"></div>
        </div>

        <div class="w-3/5 flex flex-col p-8 justify-between bg-white relative">
            
            <div class="flex items-center gap-4 justify-end border-b pb-4">
                <div class="text-right">
                    <p class="font-black text-2xl uppercase leading-none" style="color: {{ $mainColor }}">
                        {{ $employee->company->name ?? 'ENTREPRISE' }}
                    </p>
                    <p class="text-[10px] text-gray-400 font-bold tracking-[0.2em] mt-1">CARTE PROFESSIONNELLE</p>
                </div>
                @if($employee->company && $employee->company->logo)
                    <img src="{{ asset('storage/' . $employee->company->logo) }}" class="h-14 w-14 object-contain">
                @endif
            </div>

            <div class="flex-grow flex flex-col justify-center py-2">
                <div class="mb-4">
                    <p class="text-gray-400 text-[10px] font-black uppercase tracking-widest mb-1">Nom & Prénoms</p>
                    <p class="text-3xl font-extrabold text-slate-900 leading-tight">
                        {{ $employee->first_name }} <br> {{ $employee->last_name }}
                    </p>
                </div>
                
                <div class="flex gap-6">
                    <div>
                        <p class="text-gray-400 text-[9px] font-black uppercase">Fonction</p>
                        <p class="text-sm font-bold uppercase" style="color: {{ $mainColor }}">
                            {{ $employee->function ?? 'Collaborateur' }}
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-[9px] font-black uppercase">Matricule</p>
                        <p class="text-sm font-mono font-bold text-slate-700">{{ $employee->matricule }}</p>
                    </div>
                </div>
            </div>

            <div class="flex justify-end items-end -mt-8 pb-2">
                <div class="bg-white p-1.5 border-2 rounded-xl shadow-sm" style="border-color: {{ $mainColor }}">
                    {!! QrCode::size(85)->margin(0)->generate($qrData) !!}
                </div>
            </div>
        </div>
    </div>

</body>
</html>
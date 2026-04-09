@php 
    $mainColor = $employee->company->badge_color ?? '#1e293b'; 
    
    // Préparation des données pour le QR Code (Inspiré du Style 6)
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
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .badge-container {
            width: 600px;
            height: 350px;
            font-family: 'sans-serif';
        }
        /* Motif circuit board spécifique au Style 1 */
        .tech-pattern {
            background-image: url('https://www.transparenttextures.com/patterns/circuit-board.png');
        }
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
        
        <div class="w-[40%] relative flex items-center justify-center bg-slate-50 border-r border-gray-100 overflow-hidden">
            <div class="absolute inset-0 opacity-10 tech-pattern"></div>

            <div class="absolute inset-0 opacity-30 pointer-events-none">
                <svg width="100%" height="100%" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <path d="M0 20 L35 20 L55 45" stroke="{{ $mainColor }}" stroke-width="1.5" fill="none" />
                    <circle cx="35" cy="20" r="1.5" fill="{{ $mainColor }}" />
                    <path d="M0 80 L45 80 L65 100" stroke="{{ $mainColor }}" stroke-width="1.5" fill="none" />
                </svg>
            </div>

            <div class="z-10 w-44 h-56 rounded-[2rem] overflow-hidden shadow-xl border-4 border-white bg-white">
                @if($employee->photo)
                    <img src="{{ asset('storage/' . $employee->photo) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-400 font-bold border-2 border-dashed border-gray-200 uppercase text-[10px]">
                        Sans Photo
                    </div>
                @endif
            </div>
        </div>

        <div class="w-[60%] flex flex-col p-8 justify-between bg-white relative">
            
            <div class="flex items-center justify-end gap-3 border-b pb-4">
                <div class="text-right">
                    <p class="font-black text-lg uppercase leading-none" style="color: {{ $mainColor }}">
                        {{ $employee->company->name ?? 'YA CONSULTING' }}
                    </p>
                    <p class="text-[8px] text-gray-400 font-bold tracking-[0.2em] mt-1 uppercase">Carte Professionnelle</p>
                </div>
                @if($employee->company && $employee->company->logo)
                    <img src="{{ asset('storage/' . $employee->company->logo) }}" class="h-10 w-auto object-contain">
                @endif
            </div>

            <div class="mt-4 flex-grow">
                <h1 class="text-3xl font-black text-slate-900 uppercase tracking-tighter leading-none">
                    {{ $employee->last_name }}
                </h1>
                <h2 class="text-2xl font-bold uppercase mt-1" style="color: {{ $mainColor }}">
                    {{ $employee->first_name }}
                </h2>
                
                <div class="mt-4 flex flex-col gap-1">
                    <div class="flex items-center gap-2">
                        <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Poste:</span>
                        <span class="text-xs font-bold text-slate-700 uppercase">{{ $employee->function ?? 'N/A' }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Matricule:</span>
                        <span class="text-xs font-mono font-black" style="color: {{ $mainColor }}">{{ $employee->matricule }}</span>
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-end">
                <div class="text-left">
                    <p class="text-[7px] font-black text-slate-300 uppercase tracking-[0.3em]">Digital Security ID</p>
                    <p class="text-[9px] font-bold text-slate-400 italic lowercase">{{ $employee->department ?? 'direction générale' }}</p>
                </div>
                
                <div class="p-1.5 bg-white border-2 rounded-xl shadow-sm" style="border-color: {{ $mainColor }}">
                    {!! QrCode::size(70)->margin(0)->generate($qrData) !!}
                </div>
            </div>
        </div>
    </div>

</body>
</html>
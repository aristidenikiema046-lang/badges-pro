@php 
    $mainColor = $employee->company->badge_color ?? '#1e293b'; 
    
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
        /* Style des circuits renforcé */
        .tech-line {
            position: absolute;
            background-color: {{ $mainColor }};
            opacity: 0.6; /* Opacité augmentée pour plus de contraste */
            height: 2px;
            border-radius: 2px;
            /* Petit effet de lueur pour donner un aspect "électrique" */
            box-shadow: 0 0 4px {{ $mainColor }};
        }
        
        .tech-dot {
            position: absolute;
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background-color: {{ $mainColor }};
            opacity: 0.8;
            box-shadow: 0 0 6px {{ $mainColor }};
        }

        @media print {
            .no-print { display: none; }
            body { background: white; }
            .badge-container { box-shadow: none; border: 1px solid #eee; }
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
        
        <div class="w-[42%] relative flex items-center justify-center bg-slate-100 border-r border-gray-200 overflow-hidden">
            
            <div class="absolute inset-0 pointer-events-none">
                <div class="tech-line w-24 top-12 left-0"></div>
                <div class="tech-line w-16 top-12 left-24 rotate-45 origin-left"></div>
                <div class="tech-dot top-[38px] left-[32px]"></div>
                
                <div class="tech-line w-32 top-1/2 left-0 -translate-y-1/2"></div>
                <div class="tech-dot top-1/2 left-[120px] -translate-y-1/2"></div>
                
                <div class="tech-line w-20 bottom-16 left-0"></div>
                <div class="tech-line w-12 bottom-16 left-20 -rotate-45 origin-left"></div>
                <div class="tech-dot bottom-[22px] left-[138px]"></div>

                <div class="tech-line w-40 bottom-8 left-0"></div>
                <div class="tech-dot bottom-[30px] left-[155px]"></div>
            </div>

            <div class="z-10 w-44 h-56 rounded-[1.5rem] overflow-hidden shadow-2xl border-4 border-white bg-white">
                @if($employee->photo)
                    <img src="{{ asset('storage/' . $employee->photo) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-400 font-bold uppercase text-[10px] p-4 text-center">
                        Photo
                    </div>
                @endif
            </div>
        </div>

        <div class="w-[58%] flex flex-col p-8 justify-between bg-white relative">
            <div class="flex items-center justify-end gap-3 border-b border-gray-50 pb-4">
                <div class="text-right">
                    <p class="font-black text-xl uppercase leading-none" style="color: {{ $mainColor }}">
                        {{ $employee->company->name ?? 'ENTREPRISE' }}
                    </p>
                    <p class="text-[8px] text-gray-400 font-bold tracking-[0.2em] mt-1 uppercase">Identification Digitale</p>
                </div>
                @if($employee->company && $employee->company->logo)
                    <img src="{{ asset('storage/' . $employee->company->logo) }}" class="h-12 w-auto object-contain">
                @endif
            </div>

            <div class="mt-6">
                <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest mb-1">Détails Collaborateur</p>
                <h1 class="text-3xl font-black text-slate-900 uppercase tracking-tighter leading-none">
                    {{ $employee->last_name }}
                </h1>
                <h2 class="text-2xl font-bold uppercase mt-1" style="color: {{ $mainColor }}">
                    {{ $employee->first_name }}
                </h2>
                
                <div class="mt-6 grid grid-cols-2 gap-4">
                    <div>
                        <span class="block text-[8px] font-black text-gray-400 uppercase tracking-widest">Poste</span>
                        <span class="text-xs font-bold text-slate-700 uppercase">{{ $employee->function ?? 'Collaborateur' }}</span>
                    </div>
                    <div>
                        <span class="block text-[8px] font-black text-gray-400 uppercase tracking-widest">Matricule</span>
                        <span class="text-xs font-mono font-black" style="color: {{ $mainColor }}">{{ $employee->matricule }}</span>
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-end mt-4">
                <div class="text-left border-l-2 pl-3" style="border-color: {{ $mainColor }}">
                    <p class="text-[7px] font-black text-slate-400 uppercase tracking-[0.2em]">Sécurité & Accès</p>
                    <p class="text-[10px] font-bold text-slate-900 uppercase">{{ $employee->department ?? 'Standard' }}</p>
                </div>
                
                <div class="p-1.5 bg-white border-2 rounded-xl shadow-sm" style="border-color: {{ $mainColor }}">
                    {!! QrCode::size(75)->margin(0)->generate($qrData) !!}
                </div>
            </div>
        </div>
    </div>

</body>
</html>
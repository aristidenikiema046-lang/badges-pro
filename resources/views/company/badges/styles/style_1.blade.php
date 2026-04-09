@php 
    // Bleu profond et sombre par défaut
    $mainColor = $employee->company->badge_color ?? '#1e3a8a'; 
    
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
        
        /* Arrière-plan de circuits plus dense */
        .circuit-bg {
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 140px; /* Plus large pour plus de traits */
            pointer-events: none;
            z-index: 1;
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
        
        <div class="w-[42%] relative flex items-center justify-center bg-white border-r border-gray-100 overflow-hidden">
            
            <svg class="circuit-bg" viewBox="0 0 120 350" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g opacity="0.9" stroke="{{ $mainColor }}" stroke-width="1.8">
                    <path d="M0 30H50L70 50H100" />
                    <circle cx="100" cy="50" r="3" fill="{{ $mainColor }}" />
                    <path d="M20 0V20L40 40" />
                    <circle cx="20" cy="20" r="2" fill="{{ $mainColor }}" />
                    
                    <path d="M0 100H40L60 120H90L110 140" />
                    <circle cx="110" cy="140" r="3.5" fill="{{ $mainColor }}" />
                    <path d="M0 160H30L50 180H80" />
                    <circle cx="80" cy="180" r="3" fill="{{ $mainColor }}" />
                    
                    <path d="M0 240H20L45 265V310L70 335H110" />
                    <circle cx="110" cy="335" r="3.5" fill="{{ $mainColor }}" />
                    <path d="M0 290H35L55 310H85" />
                    <circle cx="85" cy="310" r="3" fill="{{ $mainColor }}" />
                    <path d="M10 350V320L30 300" />
                    <circle cx="10" cy="320" r="2" fill="{{ $mainColor }}" />
                </g>
            </svg>

            <div class="z-10 w-44 h-56 rounded-[1.5rem] overflow-hidden shadow-xl border-4 border-white bg-gray-50">
                @if($employee->photo)
                    <img src="{{ asset('storage/' . $employee->photo) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-gray-400 font-bold uppercase text-[10px] p-4 text-center">Photo</div>
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
                        <span class="text-xs font-mono font-black px-2 py-0.5 rounded bg-slate-100" style="color: {{ $mainColor }}">
                            {{ $employee->matricule }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-end mt-4">
                <div class="text-left border-l-4 pl-3" style="border-color: {{ $mainColor }}">
                    <p class="text-[7px] font-black text-slate-400 uppercase tracking-[0.2em]">Sécurité & Accès</p>
                    <p class="text-[10px] font-bold text-slate-900 uppercase">{{ $employee->department ?? 'Standard' }}</p>
                </div>
                
                <div class="p-2 bg-white border-2 rounded-xl shadow-md flex items-center justify-center" style="border-color: {{ $mainColor }}">
                    <div class="bg-white p-1">
                        {!! QrCode::size(85)->margin(0)->generate($qrData) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
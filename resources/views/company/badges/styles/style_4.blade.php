@php 
    $mainColor = $mainColor ?? ($employee->company->badge_color ?? '#1e293b'); 
    
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
            body { background: white; padding: 0; }
            .badge-container { box-shadow: none !important; border: 1px solid #eee; }
        }
        /* Ajustements mobiles */
        @media (max-width: 640px) {
            .badge-container { aspect-ratio: auto; min-height: 400px; flex-direction: column; }
            .sidebar-part { width: 100% !important; padding: 20px 0; }
            .content-part { width: 100% !important; padding: 20px !important; }
        }
    </style>
</head>
<body class="bg-gray-100 flex flex-col items-center justify-center min-h-screen gap-6 p-4">

    <div class="no-print">
        <button onclick="window.print()" class="flex items-center gap-2 bg-slate-800 text-white px-8 py-3 rounded-full hover:bg-black transition shadow-xl font-bold uppercase text-xs tracking-widest">
            Imprimer le badge
        </button>
    </div>

    {{-- Badge Container --}}
    <div class="badge-container bg-white shadow-2xl overflow-hidden flex relative border-2 mx-auto rounded-[2rem]" 
         style="border-color: {{ $mainColor }}">
        
        {{-- Partie latérale colorée --}}
        <div class="sidebar-part w-2/5 relative flex items-center justify-center" style="background-color: {{ $mainColor }}">
            <div class="absolute inset-0 opacity-10 sidebar-pattern"></div>
            
            <div class="z-10 relative">
                <div class="w-24 h-24 sm:w-40 sm:h-40 rounded-full border-4 border-white shadow-2xl overflow-hidden bg-white">
                    @if($employee->photo)
                        <img src="{{ asset('storage/' . $employee->photo) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                            <svg class="w-12 h-12 sm:w-20 sm:h-20" fill="currentColor" viewBox="0 0 20 20"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path></svg>
                        </div>
                    @endif
                </div>
            </div>
            <div class="absolute -bottom-12 -left-12 w-32 h-32 rounded-full opacity-20 bg-white"></div>
        </div>

        {{-- Partie contenu --}}
        <div class="content-part w-3/5 flex flex-col p-4 sm:p-8 justify-between bg-white relative">
            
            <div class="flex items-center justify-end gap-3 border-b border-gray-100 pb-2">
                <div class="text-right">
                    @if(!isset($hideCompanyName) || !$hideCompanyName)
                        <p class="font-black text-sm sm:text-xl uppercase leading-none" style="color: {{ $mainColor }}">
                            {{ $employee->company->name ?? 'YA CONSULTING' }}
                        </p>
                    @endif
                    <p class="text-[8px] text-gray-400 font-bold tracking-widest mt-1 uppercase">Carte Pro</p>
                </div>
                @if($employee->company && $employee->company->logo)
                    <img src="{{ asset('storage/' . $employee->company->logo) }}" class="h-6 sm:h-10 w-auto object-contain">
                @endif
            </div>

            <div class="py-2">
                <p class="text-gray-400 text-[8px] font-black uppercase tracking-widest mb-0.5">Identité</p>
                <h1 class="text-lg sm:text-2xl font-extrabold text-slate-900 leading-tight uppercase truncate">
                    {{ $employee->first_name }} {{ $employee->last_name }}
                </h1>
                
                <div class="mt-2 flex gap-4">
                    <div>
                        <p class="text-gray-400 text-[7px] font-black uppercase">Fonction</p>
                        <p class="text-[10px] sm:text-xs font-bold text-slate-700 uppercase">{{ $employee->function ?? 'Collaborateur' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-[7px] font-black uppercase">Matricule</p>
                        <p class="text-[10px] sm:text-xs font-mono font-black tracking-tighter" style="color: {{ $mainColor }}">{{ $employee->matricule }}</p>
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-end mt-auto">
                <div class="text-left pb-1">
                    <p class="text-[7px] font-bold text-gray-300 uppercase tracking-widest">Security ID</p>
                    <p class="text-[8px] font-bold text-slate-400 italic truncate max-w-[80px]">{{ $employee->department ?? 'DIRECTION' }}</p>
                </div>
                
                <div class="bg-white p-0.5 sm:p-1 border rounded-lg shadow-sm" style="border-color: {{ $mainColor }}44">
                    {!! QrCode::size(50)->margin(0)->generate($qrData) !!}
                </div>
            </div>
        </div>
    </div>

</body>
</html>
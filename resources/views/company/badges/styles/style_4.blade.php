@php 
    $mainColor = $mainColor ?? ($employee->company->badge_color ?? '#1e293b'); 
    
    // Préparation des données pour le QR Code
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
        .badge-container {
            width: 600px;
            height: 350px;
            font-family: 'sans-serif';
        }
        .sidebar-pattern {
            background-image: url('https://www.transparenttextures.com/patterns/cubes.png');
        }
        @media print {
            .no-print { display: none; }
            body { background: white; padding: 0; }
            .badge-container { box-shadow: none; border: 1px solid #eee; margin: 0; }
        }
    </style>
</head>
<body class="bg-gray-100 flex flex-col items-center justify-center min-h-screen gap-6 p-4">

    <div class="no-print">
        <button onclick="window.print()" class="flex items-center gap-2 bg-slate-800 text-white px-8 py-3 rounded-full hover:bg-black transition shadow-xl font-bold uppercase text-xs tracking-widest">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 00-2 2h2m2 4h10a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
            </svg>
            Imprimer le badge corrigé
        </button>
    </div>

    <div class="badge-container bg-white shadow-2xl overflow-hidden flex relative border-2 mx-auto rounded-[2rem]" 
         style="border-color: {{ $mainColor }}">
        
        <div class="w-2/5 relative flex items-center justify-center" style="background-color: {{ $mainColor }}">
            <div class="absolute inset-0 opacity-10 sidebar-pattern"></div>
            
            <div class="z-10 relative">
                <div class="w-40 h-40 rounded-full border-4 border-white shadow-2xl overflow-hidden bg-white">
                    @if($employee->photo)
                        <img src="{{ asset('storage/' . $employee->photo) }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                            <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 20 20"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path></svg>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="absolute -bottom-12 -left-12 w-32 h-32 rounded-full opacity-20 bg-white"></div>
        </div>

        <div class="w-3/5 flex flex-col p-8 justify-between bg-white relative">
            
            <div class="flex items-center justify-end gap-3 border-b border-gray-100 pb-3">
                <div class="text-right">
                    <p class="font-black text-xl uppercase leading-none" style="color: {{ $mainColor }}">
                        {{ $employee->company->name ?? 'YA CONSULTING' }}
                    </p>
                    <p class="text-[9px] text-gray-400 font-bold tracking-widest mt-1 uppercase">Carte Professionnelle</p>
                </div>
                @if($employee->company && $employee->company->logo)
                    <img src="{{ asset('storage/' . $employee->company->logo) }}" class="h-10 w-auto object-contain">
                @endif
            </div>

            <div class="py-4">
                <p class="text-gray-400 text-[9px] font-black uppercase tracking-widest mb-1">Identité</p>
                <h1 class="text-2xl font-extrabold text-slate-900 leading-tight uppercase">
                    {{ $employee->first_name }} {{ $employee->last_name }}
                </h1>
                
                <div class="mt-3 flex gap-4">
                    <div>
                        <p class="text-gray-400 text-[8px] font-black uppercase">Fonction</p>
                        <p class="text-xs font-bold text-slate-700 uppercase">{{ $employee->function ?? 'Collaborateur' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-[8px] font-black uppercase">Matricule</p>
                        <p class="text-xs font-mono font-black tracking-tighter" style="color: {{ $mainColor }}">{{ $employee->matricule }}</p>
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-end mt-auto">
                <div class="text-left pb-1">
                    <p class="text-[8px] font-bold text-gray-300 uppercase tracking-widest">Digital Security</p>
                    <p class="text-[10px] font-bold text-slate-400 italic">{{ $employee->department ?? 'DIRECTION GÉNÉRALE' }}</p>
                </div>
                
                <div class="bg-white p-1 border rounded-lg shadow-sm" style="border-color: {{ $mainColor }}44">
                    {!! QrCode::size(75)->margin(0)->generate($qrData) !!}
                </div>
            </div>
        </div>
    </div>

</body>
</html>
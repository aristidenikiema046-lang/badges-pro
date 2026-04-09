@php 
    // Utilisation de la couleur de l'entreprise ou noir par défaut
    $mainColor = $mainColor ?? ($employee->company->badge_color ?? '#000000'); 
    
    // Données QR Code
    $qrData = "NOM: {$employee->last_name}\n"
            . "PRENOM: {$employee->first_name}\n"
            . "POSTE: {$employee->function}\n"
            . "ID: {$employee->matricule}";
@endphp

<div class="badge-card bg-white shadow-2xl overflow-hidden flex relative border mx-auto" 
     style="width: 600px; height: 350px; border-radius: 1.5rem; border-color: #e2e8f0;">
    
    <div class="w-[40%] relative flex items-center justify-center bg-slate-50 overflow-hidden border-r border-gray-100">
        <div class="absolute inset-0 opacity-20" 
             style="background-image: url('https://www.transparenttextures.com/patterns/circuit-board.png');">
        </div>
        
        <div class="absolute inset-0 opacity-40 pointer-events-none">
            <svg width="100%" height="100%" viewBox="0 0 100 100" preserveAspectRatio="none">
                <path d="M0 20 L30 20 L50 40 M0 80 L40 80 L60 100" stroke="{{ $mainColor }}" stroke-width="2" fill="none" />
                <circle cx="30" cy="20" r="2" fill="{{ $mainColor }}" />
                <circle cx="50" cy="40" r="2" fill="{{ $mainColor }}" />
            </svg>
        </div>

        <div class="z-10 w-44 h-56 rounded-[2rem] overflow-hidden shadow-2xl border-4 border-white bg-white">
            @if($employee->photo)
                <img src="{{ asset('storage/' . $employee->photo) }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center text-gray-300 bg-gray-50">
                    <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 20 20"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path></svg>
                </div>
            @endif
        </div>
    </div>

    <div class="w-[60%] flex flex-col p-8 justify-between bg-white relative">
        
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-2">
                @if($employee->company && $employee->company->logo)
                    <img src="{{ asset('storage/' . $employee->company->logo) }}" class="h-10 w-auto object-contain">
                @endif
                <span class="font-bold text-lg tracking-tight text-slate-700">
                    {{ $employee->company->name ?? 'Paymetrust' }}
                </span>
            </div>
        </div>

        <div class="mt-4">
            <h1 class="text-3xl font-black text-slate-900 uppercase tracking-tight leading-tight">
                {{ $employee->first_name }} <br> {{ $employee->last_name }}
            </h1>
            <p class="text-lg font-medium mt-1" style="color: {{ $mainColor }}">
                {{ $employee->function ?? 'Analyste Financier' }}
            </p>
            <p class="text-slate-500 font-bold text-sm mt-2">
                Matricule : <span class="font-mono">{{ $employee->matricule }}</span>
            </p>
        </div>

        <div class="flex justify-between items-end">
            <div class="pb-1">
                <span class="text-[8px] font-black text-slate-300 uppercase tracking-[0.3em]">Authentification Digitale</span>
            </div>
            
            <div class="p-1.5 bg-white border rounded-xl shadow-sm" style="border-color: #f1f5f9">
                {!! QrCode::size(80)->margin(0)->generate($qrData) !!}
            </div>
        </div>
    </div>
</div>
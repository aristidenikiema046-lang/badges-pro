@php $mainColor = $employee->badge_color ?? '#059669'; @endphp
<div class="badge-fixed-container relative bg-white flex overflow-hidden w-full h-full border border-gray-200">
    
    {{-- Bande de couleur décorative à gauche --}}
    <div class="absolute left-0 top-0 bottom-0 w-2 z-10" style="background-color: {{ $mainColor }}"></div>

    {{-- Partie Gauche : Photo --}}
    <div class="w-1/3 flex items-center justify-center p-4 flex-none bg-gray-50 relative">
        {{-- Décoration d'arrière-plan discrète --}}
        <div class="absolute inset-0 opacity-5" style="background-image: radial-gradient({{ $mainColor }} 1px, transparent 1px); background-size: 10px 10px;"></div>
        
        <div class="w-full aspect-square rounded-2xl overflow-hidden shadow-xl border-[3px] bg-white z-10" style="border-color: {{ $mainColor }}">
            <img src="{{ $getPath($employee->photo) }}" class="w-full h-full object-cover">
        </div>
    </div>

    {{-- Partie Droite : Informations --}}
    <div class="flex-1 flex flex-col justify-between p-5 text-right relative">
        
        {{-- Logo de l'entreprise --}}
        <div class="flex justify-end mb-2">
            @if($employee->company && $employee->company->logo)
                <img src="{{ $getPath($employee->company->logo) }}" class="h-8 w-auto object-contain">
            @endif
        </div>

        {{-- Nom et Prénom --}}
        <div class="mt-2">
            <h1 class="text-2xl font-black uppercase text-gray-900 leading-none tracking-tighter break-words">
                {{ $employee->last_name }}
            </h1>
            <h1 class="text-xl font-bold uppercase leading-none mt-1" style="color: {{ $mainColor }}">
                {{ $employee->first_name }}
            </h1>
        </div>

        {{-- Poste et Département --}}
        <div class="mt-3">
            <p class="text-[11px] font-black text-gray-700 uppercase tracking-wide">
                {{ $employee->function }}
            </p>
            <p class="text-[9px] font-bold uppercase italic opacity-70" style="color: {{ $mainColor }}">
                {{ $employee->department ?? 'DIRECTION GÉNÉRALE' }}
            </p>
        </div>

        {{-- Footer avec QR Code et Matricule --}}
        <div class="mt-4 pt-3 border-t border-gray-100 flex justify-between items-center">
             <div class="flex flex-col text-left">
                <span class="text-[7px] font-bold text-gray-400 uppercase tracking-widest">Matricule</span>
                <span class="text-[10px] font-mono font-black text-gray-800 uppercase">{{ $employee->badge_number }}</span>
             </div>
             <div class="p-1 bg-white rounded-lg border border-gray-100 shadow-sm">
                <img src="{{ $getPath($employee->qr_code) }}" class="w-10 h-10">
             </div>
        </div>
    </div>
</div>
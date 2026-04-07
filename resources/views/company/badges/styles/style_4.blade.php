@php $mainColor = $employee->badge_color ?? '#059669'; @endphp
<div class="badge-fixed-container relative bg-white flex overflow-hidden w-full h-full border border-gray-200">
    
    {{-- Bande de couleur décorative à gauche --}}
    <div class="absolute left-0 top-0 bottom-0 w-3 z-20" style="background-color: {{ $mainColor }}"></div>

    {{-- Partie Gauche : Photo agrandie (Passage à 40% de la largeur) --}}
    <div class="w-2/5 flex items-center justify-center p-6 flex-none bg-gray-50/50 relative border-r border-gray-100">
        {{-- Décoration d'arrière-plan --}}
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient({{ $mainColor }} 1px, transparent 1px); background-size: 12px 12px;"></div>
        
        {{-- Photo Ultra : Utilise tout l'espace disponible de la colonne --}}
        <div class="w-full aspect-square rounded-[2rem] overflow-hidden shadow-2xl border-[4px] bg-white z-10" style="border-color: {{ $mainColor }}">
            <img src="{{ $getPath($employee->photo) }}" class="w-full h-full object-cover scale-105">
        </div>
    </div>

    {{-- Partie Droite : Informations --}}
    <div class="flex-1 flex flex-col justify-between p-6 text-right relative">
        
        {{-- Logo de l'entreprise --}}
        <div class="flex justify-end mb-1">
            @if($employee->company && $employee->company->logo)
                <img src="{{ $getPath($employee->company->logo) }}" class="h-10 w-auto object-contain">
            @endif
        </div>

        {{-- Nom et Prénom --}}
        <div class="mt-2">
            <h1 class="text-3xl font-black uppercase text-gray-900 leading-[0.85] tracking-tighter break-words">
                {{ $employee->last_name }}
            </h1>
            <h1 class="text-xl font-bold uppercase leading-none mt-2" style="color: {{ $mainColor }}">
                {{ $employee->first_name }}
            </h1>
        </div>

        {{-- Poste et Département --}}
        <div class="mt-2 bg-gray-50/50 p-2 rounded-lg border-r-4" style="border-color: {{ $mainColor }}">
            <p class="text-[12px] font-black text-gray-800 uppercase tracking-tight leading-tight">
                {{ $employee->function }}
            </p>
            <p class="text-[10px] font-bold uppercase italic mt-0.5" style="color: {{ $mainColor }}">
                {{ $employee->department ?? 'DIRECTION GÉNÉRALE' }}
            </p>
        </div>

        {{-- Footer avec QR Code et Matricule --}}
        <div class="mt-4 pt-3 border-t border-gray-100 flex justify-between items-center">
             <div class="flex flex-col text-left">
                <span class="text-[8px] font-bold text-gray-400 uppercase tracking-widest">Matricule</span>
                <span class="text-[12px] font-mono font-black text-gray-800 uppercase tracking-tighter">{{ $employee->badge_number }}</span>
             </div>
             <div class="p-1.5 bg-white rounded-xl border border-gray-100 shadow-sm">
                <img src="{{ $getPath($employee->qr_code) }}" class="w-11 h-11">
             </div>
        </div>
    </div>
</div>
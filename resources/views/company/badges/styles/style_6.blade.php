@php $mainColor = $employee->badge_color ?? '#059669'; @endphp
<div class="badge-fixed-container relative bg-white flex flex-col items-center overflow-hidden w-full h-full border border-gray-100">
    
    {{-- Éléments de design géométriques --}}
    <div class="absolute -top-12 -right-12 w-40 h-40 rounded-full opacity-20" style="background-color: {{ $mainColor }}"></div>
    <div class="absolute -bottom-12 -left-12 w-32 h-32 rounded-full opacity-10" style="background-color: {{ $mainColor }}"></div>

    {{-- 1. HEADER : Logo de l'entreprise --}}
    <div class="w-full pt-8 flex-none flex justify-center z-10 px-6">
        @if($employee->company && $employee->company->logo)
            <img src="{{ $getPath($employee->company->logo) }}" class="h-10 w-auto object-contain">
        @endif
    </div>

    {{-- 2. CORPS : Informations complètes --}}
    <div class="flex-grow flex flex-col items-center justify-center z-10 px-6 text-center">
        
        {{-- Photo inclinée (Style distinctif) --}}
        <div class="w-32 h-32 rounded-[2.5rem] rotate-6 overflow-hidden border-[3px] bg-white shadow-2xl mb-5 flex-none" style="border-color: {{ $mainColor }}">
            <img src="{{ $getPath($employee->photo) }}" class="w-full h-full object-cover -rotate-6 scale-110">
        </div>

        {{-- Identité : Nom et Prénom --}}
        <div class="mb-3">
            <h1 class="text-xl font-black uppercase text-gray-900 tracking-tighter leading-tight">
                {{ $employee->last_name }}
            </h1>
            <h1 class="text-lg font-bold uppercase leading-none" style="color: {{ $mainColor }}">
                {{ $employee->first_name }}
            </h1>
        </div>

        {{-- Séparateur visuel --}}
        <div class="flex items-center gap-2 mb-3 w-full justify-center opacity-40">
            <div class="h-1 w-8 rounded-full" style="background-color: {{ $mainColor }}"></div>
            <div class="h-1 w-1 rounded-full" style="background-color: {{ $mainColor }}"></div>
        </div>

        {{-- Poste / Fonction --}}
        <p class="text-[11px] font-black text-gray-700 uppercase tracking-widest leading-tight">
            {{ $employee->function }}
        </p>
        
        {{-- 3. DÉPARTEMENT (Ajouté/Mis en valeur) --}}
        <div class="mt-2 inline-block px-4 py-1 rounded-full text-[9px] font-bold text-white uppercase tracking-tighter shadow-sm" style="background-color: {{ $mainColor }}">
            {{ $employee->department ?? 'SANS DÉPARTEMENT' }}
        </div>
    </div>

    {{-- 4. FOOTER : Matricule et QR Code --}}
    <div class="w-full p-5 flex justify-between items-center px-8 flex-none bg-gray-50 border-t border-gray-100 z-10">
        <div class="flex flex-col">
            <span class="text-[7px] font-bold text-gray-400 uppercase tracking-[0.2em]">Identification</span>
            {{-- ID / Matricule --}}
            <span class="text-[11px] font-mono font-black text-gray-800 uppercase">{{ $employee->badge_number }}</span>
        </div>
        {{-- QR Code --}}
        <div class="bg-white p-1.5 rounded-lg shadow-sm border border-gray-100">
            <img src="{{ $getPath($employee->qr_code) }}" class="w-9 h-9">
        </div>
    </div>
</div>
@php 
    // On récupère la couleur de l'entreprise ou celle définie pour l'employé
    $mainColor = $employee->company->badge_color ?? '#059669'; 
@endphp

<div class="badge-fixed-container relative bg-white flex flex-col items-center overflow-hidden w-full h-full border border-gray-100 shadow-lg">
    {{-- Barre de couleur supérieure --}}
    <div class="w-full h-3 flex-none" style="background-color: {{ $mainColor }}"></div>
    
    {{-- 1. Logo de l'entreprise --}}
    <div class="w-full pt-4 flex justify-center flex-none px-4">
        @if($employee->company && $employee->company->logo)
            <img src="{{ asset('storage/' . $employee->company->logo) }}" class="h-10 w-auto object-contain">
        @endif
    </div>

    {{-- 2. Zone centrale : Identité (Remplace la photo par un design textuel aéré) --}}
    <div class="flex-grow flex flex-col items-center justify-center w-full px-6 text-center">
        
        {{-- Icône de badge ou initiale en fond (Optionnel pour le style) --}}
        <div class="mb-4 opacity-10">
             <svg width="60" height="60" viewBox="0 0 24 24" fill="{{ $mainColor }}">
                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
             </svg>
        </div>

        {{-- Identité de l'employé --}}
        <div class="mb-4">
            <h1 class="text-2xl font-black uppercase leading-tight text-gray-900 tracking-tighter">
                {{ $employee->last_name }}
            </h1>
            <h1 class="text-xl font-bold uppercase leading-none" style="color: {{ $mainColor }}">
                {{ $employee->first_name }}
            </h1>
        </div>

        {{-- Fonction et Département --}}
        <div class="space-y-1">
            <p class="text-[13px] font-extrabold text-gray-700 uppercase tracking-wide">
                {{ $employee->function }}
            </p>
            <div class="inline-block px-3 py-1 rounded-full text-[10px] font-bold text-white uppercase mt-1" style="background-color: {{ $mainColor }}">
                {{ $employee->department ?? 'GÉNÉRAL' }}
            </div>
        </div>
    </div>

    {{-- 3. Footer : Matricule et Email Pro --}}
    <div class="w-full p-5 flex justify-between items-end flex-none border-t border-gray-100 bg-gray-50/80">
        <div class="flex flex-col text-left leading-tight">
            <span class="text-[8px] font-bold text-gray-400 uppercase tracking-widest mb-1">Matricule</span>
            <span class="text-xs font-black text-gray-800 font-mono">{{ $employee->matricule }}</span>
        </div>
        
        <div class="flex flex-col text-right leading-tight">
            <span class="text-[8px] font-bold text-gray-400 uppercase tracking-widest mb-1">Contact Pro</span>
            <span class="text-[10px] font-semibold text-gray-600 italic">{{ $employee->email }}</span>
        </div>
    </div>
</div>
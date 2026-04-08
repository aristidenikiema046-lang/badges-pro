@php 
    $mainColor = $employee->company->badge_color ?? '#059669'; 
@endphp

<div class="badge-fixed-container relative bg-white flex flex-col items-center overflow-hidden w-full h-full border border-gray-100 shadow-lg">
    {{-- Barre de couleur supérieure --}}
    <div class="w-full h-3 flex-none" style="background-color: {{ $mainColor }}"></div>
    
    {{-- 1. Header : Logo + Nom de l'Entreprise --}}
    <div class="w-full pt-4 flex flex-col items-center flex-none px-4">
        @if($employee->company && $employee->company->logo)
            <img src="{{ asset('storage/' . $employee->company->logo) }}" class="h-10 w-auto object-contain mb-1">
        @endif
        {{-- AJOUT : Nom de l'entreprise --}}
        <p class="text-[10px] font-black uppercase tracking-widest text-gray-400">
            {{ $employee->company->name }}
        </p>
    </div>

    {{-- 2. Zone centrale : Identité --}}
    <div class="flex-grow flex flex-col items-center justify-center w-full px-6 text-center">
        {{-- AJOUT : Code QR dynamique --}}
        <div class="mb-4 p-2 border-2 rounded-2xl" style="border-color: {{ $mainColor }}22"> {{-- 22 pour une légère transparence --}}
            {!! QrCode::size(70)->generate($employee->matricule) !!}
        </div>

        <div class="mb-4">
            <h1 class="text-2xl font-black uppercase leading-tight text-gray-900 tracking-tighter">
                {{ $employee->last_name }}
            </h1>
            <h1 class="text-xl font-bold uppercase leading-none" style="color: {{ $mainColor }}">
                {{ $employee->first_name }}
            </h1>
        </div>

        <div class="space-y-1">
            <p class="text-[13px] font-extrabold text-gray-700 uppercase tracking-wide">
                {{ $employee->function }}
            </p>
            <div class="inline-block px-3 py-1 rounded-full text-[10px] font-bold text-white uppercase mt-1" style="background-color: {{ $mainColor }}">
                {{ $employee->department ?? 'GÉNÉRAL' }}
            </div>
        </div>
    </div>

    {{-- 3. Footer : Matricule et Contact --}}
    <div class="w-full p-5 flex justify-between items-end flex-none border-t border-gray-100 bg-gray-50/80">
        <div class="flex flex-col text-left leading-tight">
            <span class="text-[8px] font-bold text-gray-400 uppercase tracking-widest mb-1">Matricule</span>
            <span class="text-xs font-black text-gray-800 font-mono">{{ $employee->matricule }}</span>
        </div>
        
        <div class="flex flex-col text-right leading-tight">
            <span class="text-[8px] font-bold text-gray-400 uppercase tracking-widest mb-1">Contact Pro</span>
            <span class="text-[9px] font-semibold text-gray-600 truncate max-w-[120px]">{{ $employee->email }}</span>
        </div>
    </div>
</div>
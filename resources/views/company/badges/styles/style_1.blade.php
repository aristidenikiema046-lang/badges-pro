@php 
    $mainColor = $employee->company->badge_color ?? '#059669'; 
@endphp

<div class="relative bg-white flex flex-col items-center overflow-hidden w-full h-full font-sans">
    <!-- Barre de couleur supérieure -->
    <div class="w-full h-4 flex-none" style="background-color: {{ $mainColor }}"></div>
    
    <!-- Header : Logo et Nom Entreprise -->
    <div class="w-full pt-6 flex flex-col items-center flex-none px-4">
        @if($employee->company && $employee->company->logo)
            <img src="{{ $getPath($employee->company->logo) }}" class="h-14 w-auto object-contain mb-2">
        @endif
        <p class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 text-center line-clamp-1">
            {{ $employee->company->name }}
        </p>
    </div>

    <!-- Corps central : QR Code et Identité -->
    <div class="flex-grow flex flex-col items-center justify-center w-full px-6 text-center">
        <!-- Zone QR Code -->
        <div class="mb-6 p-3 border-2 rounded-[1.5rem] bg-white shadow-sm" style="border-color: {{ $mainColor }}33">
             {!! QrCode::size(120)->margin(1)->generate($employee->matricule) !!}
        </div>

        <!-- Nom et Prénom -->
        <div class="mb-4 w-full">
            <h1 class="text-2xl font-black uppercase leading-tight text-gray-900 tracking-tighter truncate px-2">
                {{ $employee->last_name }}
            </h1>
            <h2 class="text-xl font-bold uppercase leading-none mt-1 truncate px-2" style="color: {{ $mainColor }}">
                {{ $employee->first_name }}
            </h2>
        </div>

        <!-- Fonction et Département -->
        <div class="w-full">
            <p class="text-[13px] font-extrabold text-gray-700 uppercase tracking-wide truncate px-2">
                {{ $employee->function }}
            </p>
            <div class="inline-block px-4 py-1 rounded-full text-[10px] font-bold text-white uppercase mt-3 shadow-sm" style="background-color: {{ $mainColor }}">
                {{ $employee->department ?? 'GÉNÉRAL' }}
            </div>
        </div>
    </div>

    <!-- Footer : Matricule et Contact -->
    <div class="w-full p-5 flex justify-between items-center flex-none border-t border-gray-100 bg-gray-50">
        <div class="flex flex-col text-left overflow-hidden">
            <span class="text-[8px] font-bold text-gray-400 uppercase tracking-widest">Matricule</span>
            <span class="text-xs font-black text-gray-800 font-mono">{{ $employee->matricule }}</span>
        </div>
        <div class="text-right overflow-hidden ml-2">
            <span class="text-[8px] font-bold text-gray-400 uppercase tracking-widest block">Contact</span>
            <span class="text-[9px] font-semibold text-gray-600 truncate block">{{ $employee->email }}</span>
        </div>
    </div>
</div>
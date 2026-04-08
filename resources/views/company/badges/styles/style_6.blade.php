@php 
    $mainColor = $employee->company->badge_color ?? '#059669'; 
@endphp

<div class="relative bg-white flex flex-row items-center overflow-hidden w-full h-full font-sans border border-gray-100">
    
    <!-- Décoration d'angle (Haut-Droit) -->
    <div class="absolute top-0 right-0 w-32 h-32 opacity-10 rounded-bl-full pointer-events-none" 
         style="background-color: {{ $mainColor }}"></div>

    <!-- Section Gauche : Identité (65% de la largeur) -->
    <div class="w-[65%] pl-10 pr-4 z-10 flex flex-col justify-center h-full">
        <!-- Logo -->
        <div class="mb-6">
            @if($employee->company && $employee->company->logo)
                <img src="{{ $getPath($employee->company->logo) }}" class="h-10 w-auto object-contain">
            @endif
        </div>

        <!-- Nom et Prénom -->
        <div class="mb-5">
            <h1 class="text-4xl font-black uppercase text-gray-900 leading-none tracking-tighter truncate">
                {{ $employee->last_name }}
            </h1>
            <h2 class="text-xl font-bold uppercase mt-1 truncate" style="color: {{ $mainColor }}">
                {{ $employee->first_name }}
            </h2>
        </div>
        
        <!-- Fonction et Matricule -->
        <div class="flex items-center gap-3">
            <div class="px-3 py-1.5 rounded-lg bg-gray-900 text-white text-[10px] font-black uppercase tracking-widest truncate max-w-[180px]">
                {{ $employee->function }}
            </div>
            <span class="text-[10px] font-mono text-gray-400 font-bold tracking-widest border-l pl-3 border-gray-200">
                {{ $employee->matricule }}
            </span>
        </div>
    </div>

    <!-- Section Droite : QR Code (35% de la largeur) -->
    <div class="w-[35%] flex justify-center items-center pr-10 z-10 h-full">
        <div class="bg-white p-3 rounded-2xl shadow-xl border-2 transform rotate-2" style="border-color: {{ $mainColor }}">
            {!! QrCode::size(115)->margin(1)->generate($employee->matricule) !!}
        </div>
    </div>

    <!-- Ligne d'accentuation (Bas-Gauche) -->
    <div class="absolute bottom-0 left-10 w-40 h-1.5 rounded-t-full pointer-events-none" 
         style="background-color: {{ $mainColor }}"></div>
</div>
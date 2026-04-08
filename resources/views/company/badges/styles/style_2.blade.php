@php 
    $mainColor = $employee->company->badge_color ?? '#059669'; 
@endphp

<div class="relative bg-white flex flex-col items-center overflow-hidden w-full h-full font-sans">
    <!-- Forme géométrique d'arrière-plan -->
    <div class="absolute top-0 left-0 w-full h-56 flex-none" 
         style="background-color: {{ $mainColor }}; clip-path: polygon(0 0, 100% 0, 100% 75%, 0% 100%);">
    </div>

    <!-- Header : Logo et Nom Entreprise (au-dessus de la forme) -->
    <div class="w-full pt-6 flex-none flex flex-col items-center px-4 z-10">
        @if($employee->company && $employee->company->logo)
            <div class="bg-white p-2 rounded-xl shadow-lg mb-2">
                <img src="{{ $getPath($employee->company->logo) }}" class="h-10 w-auto object-contain">
            </div>
        @endif
        <p class="text-[9px] font-black uppercase tracking-[0.2em] text-white drop-shadow-md text-center line-clamp-1">
            {{ $employee->company->name }}
        </p>
    </div>

    <!-- Corps central -->
    <div class="flex-grow flex flex-col items-center justify-center w-full px-6 text-center z-10">
        <!-- Zone QR Code avec bordure épaisse blanche -->
        <div class="bg-white p-4 rounded-[2rem] shadow-xl mb-6 border-[6px] border-white">
            {!! QrCode::size(130)->margin(1)->generate($employee->matricule) !!}
        </div>

        <!-- Identité -->
        <div class="space-y-1 w-full px-2">
            <h2 class="text-xl font-black uppercase tracking-tight text-gray-900 leading-none truncate">
                {{ $employee->first_name }}
            </h2>
            <h1 class="text-2xl font-black uppercase tracking-tighter leading-tight truncate" style="color: {{ $mainColor }}">
                {{ $employee->last_name }}
            </h1>
        </div>
        
        <!-- Séparateur discret -->
        <div class="w-12 h-1 my-4 rounded-full mx-auto" style="background-color: {{ $mainColor }}; opacity: 0.2;"></div>
        
        <!-- Fonction et Département -->
        <div class="w-full px-2">
            <p class="text-[13px] font-black text-gray-800 uppercase tracking-widest truncate">
                {{ $employee->function }}
            </p>
            <p class="text-[9px] font-bold uppercase italic mt-1" style="color: {{ $mainColor }}">
                {{ $employee->department ?? 'SANS DÉPARTEMENT' }}
            </p>
        </div>
    </div>

    <!-- Footer -->
    <div class="w-full p-4 flex justify-between items-center flex-none bg-gray-50 border-t border-gray-100">
        <div class="border-l-4 pl-3" style="border-color: {{ $mainColor }}">
            <span class="text-[7px] text-gray-400 font-bold uppercase tracking-widest block">ID Number</span>
            <span class="text-xs font-mono font-black text-gray-800 uppercase leading-none">{{ $employee->matricule }}</span>
        </div>
        <div class="overflow-hidden text-right ml-2">
            <span class="text-[9px] font-bold text-gray-700 truncate block">{{ $employee->email }}</span>
        </div>
    </div>
</div>
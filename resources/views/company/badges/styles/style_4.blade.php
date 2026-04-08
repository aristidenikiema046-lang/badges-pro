@php 
    $mainColor = $employee->company->badge_color ?? '#059669'; 
@endphp

<div class="relative bg-white flex flex-row overflow-hidden w-full h-full font-sans">
    <!-- Barre d'accentuation latérale gauche -->
    <div class="absolute left-0 top-0 bottom-0 w-3 z-20" style="background-color: {{ $mainColor }}"></div>

    <!-- Zone Gauche : QR Code (50% de la largeur) -->
    <div class="w-1/2 flex items-center justify-center p-6 flex-none bg-gray-50 relative border-r border-gray-100">
        <div class="bg-white p-4 rounded-[1.5rem] shadow-xl z-10 border border-gray-100">
            {!! QrCode::size(130)->margin(1)->generate($employee->matricule) !!}
        </div>
        <!-- Filigrane discret -->
        <span class="absolute bottom-4 left-8 text-[8px] font-bold text-gray-300 uppercase tracking-widest">Digital Security</span>
    </div>

    <!-- Zone Droite : Infos (50% de la largeur) -->
    <div class="w-1/2 flex flex-col justify-center p-6 text-right relative">
        <!-- Logo en haut à droite -->
        <div class="absolute top-6 right-6">
            @if($employee->company && $employee->company->logo)
                <img src="{{ $getPath($employee->company->logo) }}" class="h-8 w-auto object-contain">
            @endif
        </div>

        <!-- Identité de l'employé -->
        <div class="mt-8">
            <h1 class="text-2xl font-black uppercase text-gray-900 leading-tight tracking-tighter truncate">
                {{ $employee->last_name }}
            </h1>
            <h2 class="text-xl font-bold uppercase leading-none mt-1 truncate" style="color: {{ $mainColor }}">
                {{ $employee->first_name }}
            </h2>
        </div>

        <!-- Fonction et Département -->
        <div class="mt-4 pt-4 border-t-2 border-gray-100/80">
            <p class="text-sm font-black text-gray-800 uppercase leading-none truncate">
                {{ $employee->function }}
            </p>
            <p class="text-[9px] font-bold uppercase italic mt-1.5" style="color: {{ $mainColor }}">
                {{ $employee->department ?? 'DIRECTION GÉNÉRALE' }}
            </p>
        </div>

        <!-- Matricule en bas -->
        <div class="mt-auto pt-4 flex justify-end">
            <div class="flex flex-col">
                <span class="text-[7px] font-bold text-gray-300 uppercase tracking-widest">Matricule</span>
                <span class="text-xs font-mono font-black text-gray-800 tracking-tighter">{{ $employee->matricule }}</span>
            </div>
        </div>
    </div>
</div>
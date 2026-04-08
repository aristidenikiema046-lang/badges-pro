@php 
    $mainColor = $employee->company->badge_color ?? '#1d4ed8'; // Bleu par défaut plus proche de l'image
@endphp

<div class="relative bg-white flex flex-row items-center overflow-hidden w-full h-full font-sans shadow-inner">
    
    <!-- Arrière-plan décoratif (Circuit imprimé à gauche) -->
    <div class="absolute left-0 top-0 bottom-0 w-1/3 opacity-20 pointer-events-none z-0">
        <svg viewBox="0 0 100 100" preserveAspectRatio="none" class="h-full w-full">
            <path d="M0 20 L20 20 L30 10 M0 40 L25 40 L35 50 M0 60 L15 60 L25 70 M0 80 L20 80 L30 90" 
                  stroke="{{ $mainColor }}" stroke-width="1" fill="none" />
            <circle cx="30" cy="10" r="1.5" fill="{{ $mainColor }}" />
            <circle cx="35" cy="50" r="1.5" fill="{{ $mainColor }}" />
            <circle cx="25" cy="70" r="1.5" fill="{{ $mainColor }}" />
            <circle cx="30" cy="90" r="1.5" fill="{{ $mainColor }}" />
        </svg>
    </div>

    <!-- Section Photo (Gauche) -->
    <div class="w-[40%] h-full flex items-center justify-center pl-6 z-10">
        <div class="relative w-48 h-56 overflow-hidden rounded-[2.5rem] border-4 border-white shadow-lg">
            @if($employee->photo)
                <img src="{{ $getPath($employee->photo) }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-slate-100 flex items-center justify-center">
                    <svg class="w-20 h-20 text-slate-300" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            @endif
        </div>
    </div>

    <!-- Section Infos (Droite) -->
    <div class="w-[60%] h-full flex flex-col justify-between py-10 px-8 z-10">
        
        <!-- Logo en haut à droite -->
        <div class="flex justify-end">
            @if($employee->company && $employee->company->logo)
                <img src="{{ $getPath($employee->company->logo) }}" class="h-10 w-auto object-contain">
            @else
                <span class="font-bold text-xl" style="color: {{ $mainColor }}">{{ $employee->company->name }}</span>
            @endif
        </div>

        <!-- Détails Employé (Milieu) -->
        <div class="text-left mt-4">
            <h1 class="text-3xl font-extrabold text-slate-900 uppercase tracking-tight leading-none mb-2">
                {{ $employee->first_name }} {{ $employee->last_name }}
            </h1>
            <p class="text-lg font-medium opacity-80" style="color: {{ $mainColor }}">
                {{ $employee->function }}
            </p>
            <p class="text-md font-semibold text-slate-500 mt-1">
                Matricule : {{ $employee->matricule }}
            </p>
        </div>

        <!-- QR Code en bas à droite -->
        <div class="flex justify-end items-end mt-2">
            <div class="bg-white p-1">
                {!! QrCode::size(85)->margin(0)->generate($employee->matricule) !!}
            </div>
        </div>
    </div>
</div>
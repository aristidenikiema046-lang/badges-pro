@php 
    $mainColor = $employee->company->badge_color ?? '#059669'; 
    $lastNameLength = strlen($employee->last_name);
@endphp

<div class="relative bg-white flex flex-row items-center overflow-hidden w-full h-full font-sans border border-gray-100">
    
    <!-- Décoration d'angle -->
    <div class="absolute top-0 right-0 w-40 h-40 opacity-5 rounded-bl-full pointer-events-none" 
         style="background-color: {{ $mainColor }}"></div>

    <!-- Section Gauche : Identité (Prend tout l'espace restant) -->
    <div class="flex-grow pl-8 pr-4 z-10 flex flex-col justify-center h-full min-w-0">
        <!-- Logo -->
        <div class="mb-3">
            @if($employee->company && $employee->company->logo)
                <img src="{{ $getPath($employee->company->logo) }}" class="h-10 w-auto max-w-[180px] object-contain">
            @else
                 <span class="text-[10px] font-black uppercase tracking-widest text-gray-300">{{ $employee->company->name }}</span>
            @endif
        </div>

        <!-- Bloc Nom/Prénom Adaptatif -->
        <div class="mb-4">
            {{-- Taille dynamique : Normal (4xl), Long (3xl), Très long (2xl) --}}
            <h1 class="font-black uppercase text-gray-900 leading-tight tracking-tighter truncate
                {{ $lastNameLength > 18 ? 'text-2xl' : ($lastNameLength > 12 ? 'text-3xl' : 'text-4xl') }}">
                {{ $employee->last_name }}
            </h1>
            <h2 class="text-lg font-bold uppercase opacity-90 truncate" style="color: {{ $mainColor }}">
                {{ $employee->first_name }}
            </h2>
        </div>
        
        <!-- Fonction et Matricule -->
        <div class="flex flex-col gap-2">
            <div class="flex flex-wrap items-center gap-2">
                <div class="px-2.5 py-1 rounded-md bg-gray-900 text-white text-[9px] font-bold uppercase tracking-wider whitespace-nowrap">
                    {{ $employee->function }}
                </div>
                <div class="text-[10px] font-mono text-gray-400 font-bold border-l pl-2 border-gray-200 whitespace-nowrap">
                    ID: {{ $employee->matricule }}
                </div>
            </div>
            
            @if($employee->department)
                <p class="text-[8px] font-bold text-gray-400 uppercase tracking-[0.2em] truncate">
                    {{ $employee->department }}
                </p>
            @endif
        </div>
    </div>

    <!-- Section Droite : QR Code (Taille fixe garantie) -->
    <div class="flex-none w-[140px] flex justify-center items-center pr-8 z-10 h-full">
        <div class="bg-white p-2.5 rounded-2xl shadow-xl border-2 flex-none" style="border-color: {{ $mainColor }}">
            {!! QrCode::size(105)->margin(1)->generate($employee->matricule) !!}
        </div>
    </div>

    <!-- Décoration Footer -->
    <div class="absolute bottom-0 left-0 w-full h-1 opacity-10" style="background-color: {{ $mainColor }}"></div>
    <div class="absolute bottom-0 left-8 w-24 h-1 rounded-t-full" style="background-color: {{ $mainColor }}"></div>
</div>
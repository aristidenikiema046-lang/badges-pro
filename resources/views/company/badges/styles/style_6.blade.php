@php 
    $mainColor = $employee->company->badge_color ?? '#059669'; 
@endphp

<div class="relative bg-white flex flex-row items-center overflow-hidden w-full h-full font-sans border border-gray-100">
    
    <!-- Décoration d'angle (Plus discrète pour laisser de la place) -->
    <div class="absolute top-0 right-0 w-40 h-40 opacity-5 rounded-bl-full pointer-events-none" 
         style="background-color: {{ $mainColor }}"></div>

    <!-- Section Gauche : Identité (Élargie à 70% pour les noms longs) -->
    <div class="w-[70%] pl-8 pr-4 z-10 flex flex-col justify-center h-full">
        <!-- Logo de l'entreprise -->
        <div class="mb-4">
            @if($employee->company && $employee->company->logo)
                <img src="{{ $getPath($employee->company->logo) }}" class="h-12 w-auto max-w-[200px] object-contain">
            @else
                 <span class="text-[10px] font-black uppercase tracking-widest text-gray-300">{{ $employee->company->name }}</span>
            @endif
        </div>

        <!-- Bloc Nom/Prénom : Taille adaptative -->
        <div class="mb-4">
            {{-- Le nom s'adapte : text-4xl par défaut, descend à 3xl si trop long --}}
            <h1 class="font-black uppercase text-gray-900 leading-[0.9] tracking-tighter {{ strlen($employee->last_name) > 12 ? 'text-3xl' : 'text-4xl' }}">
                {{ $employee->last_name }}
            </h1>
            <h2 class="text-xl font-bold uppercase mt-1 opacity-90" style="color: {{ $mainColor }}">
                {{ $employee->first_name }}
            </h2>
        </div>
        
        <!-- Fonction et Département -->
        <div class="flex flex-col gap-2">
            <div class="flex items-center gap-3">
                <span class="px-3 py-1 rounded-md bg-gray-900 text-white text-[10px] font-bold uppercase tracking-wider">
                    {{ $employee->function }}
                </span>
                <span class="text-[10px] font-mono text-gray-400 font-bold border-l pl-3 border-gray-200">
                    {{ $employee->matricule }}
                </span>
            </div>
            {{-- Ajout du département si disponible pour remplir l'espace --}}
            @if($employee->department)
                <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">{{ $employee->department }}</p>
            @endif
        </div>
    </div>

    <!-- Section Droite : QR Code (30%) -->
    <div class="w-[30%] flex justify-center items-center pr-8 z-10 h-full">
        <div class="bg-white p-3 rounded-2xl shadow-2xl border-2" style="border-color: {{ $mainColor }}">
            {{-- Taille ajustée pour ne pas étouffer le texte --}}
            {!! QrCode::size(120)->margin(1)->generate($employee->matricule) !!}
        </div>
    </div>

    <!-- Barre de pied de badge décorative -->
    <div class="absolute bottom-0 left-0 w-full h-1.5 opacity-20" style="background-color: {{ $mainColor }}"></div>
    <div class="absolute bottom-0 left-8 w-32 h-1.5 rounded-t-full" style="background-color: {{ $mainColor }}"></div>
</div>
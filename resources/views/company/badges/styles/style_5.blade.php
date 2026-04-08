@php 
    $mainColor = $employee->company->badge_color ?? '#059669'; 
@endphp

<div class="relative bg-white flex flex-col items-center overflow-hidden w-full h-full font-sans">
    
    {{-- Grille technique décorative --}}
    <div class="absolute inset-0 opacity-[0.07] pointer-events-none">
        <svg width="100%" height="100%" viewBox="0 0 100 120" fill="none" stroke="{{ $mainColor }}" stroke-width="0.5">
            <path d="M0 20 L100 20 M0 40 L100 40 M0 60 L100 60 M0 80 L100 80 M0 100 L100 100 M20 0 L20 120 M40 0 L40 120 M60 0 L60 120 M80 0 L80 120" stroke-dasharray="2 2" />
        </svg>
    </div>

    <!-- Header : Logo avec pillule blanche -->
    <div class="w-full pt-8 flex-none flex justify-center z-10 px-6">
        @if($employee->company && $employee->company->logo)
            <div class="bg-white px-5 py-2 rounded-full shadow-md border border-gray-50">
                <img src="{{ $getPath($employee->company->logo) }}" class="h-8 w-auto object-contain">
            </div>
        @endif
    </div>

    <!-- Corps central -->
    <div class="flex-grow flex flex-col items-center justify-center w-full px-6 text-center z-10">
        <!-- Bloc QR Code Contrasté -->
        <div class="bg-gray-900 p-5 rounded-[2.5rem] shadow-2xl mb-6 transform -rotate-1">
            <div class="bg-white p-2 rounded-[1.8rem]">
                {!! QrCode::size(125)->margin(1)->generate($employee->matricule) !!}
            </div>
        </div>

        <!-- Identité -->
        <div class="mb-4 w-full">
            <h1 class="text-2xl font-black uppercase tracking-widest text-gray-900 truncate px-2">
                {{ $employee->last_name }}
            </h1>
            <div class="h-1 w-10 bg-gray-900 mx-auto my-2 rounded-full"></div>
            <h2 class="text-lg font-bold uppercase truncate px-2" style="color: {{ $mainColor }}">
                {{ $employee->first_name }}
            </h2>
        </div>
        
        <!-- Fonction -->
        <p class="text-[11px] font-black text-gray-500 uppercase tracking-[0.25em] max-w-full truncate px-4">
            {{ $employee->function }}
        </p>
    </div>

    <!-- Footer : Triangle inversé -->
    <div class="w-full h-16 flex-none flex items-end justify-center relative z-10">
        <div class="absolute inset-0" style="background-color: {{ $mainColor }}; clip-path: polygon(0 100%, 100% 100%, 100% 0);"></div>
        <div class="relative pb-4 flex flex-col items-center">
            <span class="text-white font-mono font-black tracking-widest text-xs uppercase opacity-90">
                {{ $employee->matricule }}
            </span>
        </div>
    </div>
</div>
@php 
    $mainColor = $employee->company->badge_color ?? '#059669'; 
@endphp

<div class="relative bg-white flex flex-col items-center overflow-hidden w-full h-full font-sans">
    
    {{-- Motifs vectoriels d'arrière-plan --}}
    <div class="absolute inset-0 opacity-10 pointer-events-none">
        <svg width="100%" height="100%" viewBox="0 0 100 100" preserveAspectRatio="none">
            <circle cx="100" cy="0" r="40" fill="{{ $mainColor }}" />
            <circle cx="0" cy="100" r="30" fill="{{ $mainColor }}" />
        </svg>
    </div>

    <!-- Header -->
    <div class="w-full pt-8 pb-4 flex flex-col items-center z-10 flex-none px-4">
        @if($employee->company && $employee->company->logo)
            <img src="{{ $getPath($employee->company->logo) }}" class="h-12 w-auto object-contain">
        @endif
        <p class="text-[9px] font-black uppercase tracking-[0.2em] text-gray-400 mt-2 truncate max-w-full">
            {{ $employee->company->name }}
        </p>
    </div>

    <!-- Corps central -->
    <div class="flex-grow flex flex-col items-center justify-center w-full px-6 text-center z-10">
        
        <div class="mb-8 relative flex items-center justify-center">
            {{-- Décoration autour du QR (Statique pour compatibilité PDF) --}}
            <div class="absolute -inset-4 border-2 border-dashed rounded-full opacity-20" style="border-color: {{ $mainColor }}"></div>
            
            <div class="bg-white p-3 rounded-3xl shadow-xl relative z-20 border border-gray-50">
                {!! QrCode::size(130)->margin(1)->generate($employee->matricule) !!}
            </div>
        </div>

        <!-- Identité -->
        <div class="w-full px-2">
            <h1 class="text-3xl font-black uppercase text-gray-900 leading-none tracking-tighter truncate">
                {{ $employee->last_name }}
            </h1>
            <h2 class="text-lg font-bold uppercase tracking-[0.15em] mt-2 truncate" style="color: {{ $mainColor }}">
                {{ $employee->first_name }}
            </h2>
        </div>
        
        <!-- Séparateur avec Fonction -->
        <div class="mt-6 flex items-center gap-3 w-full px-2">
            <div class="h-px flex-grow bg-gray-200"></div>
            <p class="text-[10px] font-black uppercase text-gray-500 tracking-widest whitespace-nowrap">
                {{ $employee->function }}
            </p>
            <div class="h-px flex-grow bg-gray-200"></div>
        </div>
    </div>

    <!-- Footer -->
    <div class="w-full px-8 py-5 flex flex-col items-center flex-none border-t border-gray-50 bg-gray-50/50 z-10">
        <span class="text-[7px] font-bold text-gray-400 uppercase tracking-[0.4em] mb-1">Authentic ID</span>
        <div class="flex flex-col items-center">
            <span class="text-sm font-mono font-black text-gray-800 tracking-tighter">{{ $employee->matricule }}</span>
            <span class="text-[9px] font-medium text-gray-500 mt-1 truncate max-w-[200px]">{{ $employee->email }}</span>
        </div>
    </div>
</div>
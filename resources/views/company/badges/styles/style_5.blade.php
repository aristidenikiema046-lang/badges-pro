@php $mainColor = $employee->badge_color ?? '#059669'; @endphp
<div class="badge-fixed-container relative bg-white flex flex-col items-center overflow-hidden w-full h-full border border-gray-100">
    
    {{-- Background Design SVG --}}
    <div class="absolute inset-0 opacity-40 pointer-events-none">
        <svg width="100%" height="100%" viewBox="0 0 100 120" preserveAspectRatio="none" fill="none" stroke="{{ $mainColor }}" stroke-width="0.3">
            <path d="M5 15 L5 5 L15 5 M5 10 L10 10" />
            <circle cx="15" cy="5" r="0.8" fill="{{ $mainColor }}" />
            <path d="M5 30 L5 80 M5 45 L8 45 L8 55 L5 55" />
            <path d="M95 15 L95 5 L85 5" />
            <rect x="94" y="10" width="2" height="2" fill="{{ $mainColor }}" />
            <path d="M95 30 L95 80 M95 60 L92 60 L92 70 L95 70" />
            <circle cx="92" cy="65" r="0.8" fill="{{ $mainColor }}" />
            <path d="M5 90 L5 95 L15 95 M95 90 L95 95 L85 95" />
        </svg>
    </div>

    {{-- Header Logo --}}
    <div class="w-full pt-6 flex-none flex justify-center z-10 px-6">
        @if($employee->company && $employee->company->logo)
            <img src="{{ $getPath($employee->company->logo) }}" class="h-9 w-auto object-contain">
        @endif
    </div>

    <div class="flex-grow flex flex-col items-center justify-center w-full px-6 text-center z-10">
        {{-- PHOTO ULTRA TAILLE : w-52 h-60 (Format Portrait plus grand) --}}
        <div class="w-52 h-60 rounded-3xl overflow-hidden border-[3px] border-white shadow-2xl mb-4 bg-gray-50 flex-none relative">
            <img src="{{ $getPath($employee->photo) }}" class="w-full h-full object-cover scale-105">
        </div>

        {{-- Identité --}}
        <div class="mb-2">
            <h1 class="text-xl font-black uppercase tracking-tight text-gray-900 leading-none">
                {{ $employee->last_name }}
            </h1>
            <h1 class="text-lg font-bold uppercase leading-tight" style="color: {{ $mainColor }}">
                {{ $employee->first_name }}
            </h1>
        </div>
        
        <div class="h-[2.5px] w-10 my-2 rounded-full mx-auto" style="background-color: {{ $mainColor }}"></div>
        
        <div class="space-y-0.5">
            <p class="text-[12px] font-black text-gray-700 uppercase tracking-widest">
                {{ $employee->function }}
            </p>
            <p class="text-[9px] font-extrabold uppercase opacity-80" style="color: {{ $mainColor }}">
                {{ $employee->department ?? 'DÉPARTEMENT' }}
            </p>
        </div>
    </div>

    {{-- Footer avec clip-path (Biseau) --}}
    <div class="w-full h-24 flex-none relative mt-auto">
        <div class="absolute inset-0 z-0" style="background-color: {{ $mainColor }}; clip-path: polygon(0 35%, 100% 0, 100% 100%, 0% 100%);"></div>
        
        <div class="relative z-10 h-full w-full px-6 flex justify-between items-center pt-6">
            <div class="bg-white p-1.5 rounded-xl shadow-lg">
                <img src="{{ $getPath($employee->qr_code) }}" class="w-10 h-10">
            </div>
            <div class="text-right flex flex-col leading-tight">
                <span class="text-[7px] font-bold text-white/80 uppercase tracking-widest">Matricule Officiel</span>
                <span class="text-[12px] font-mono font-black text-white uppercase tracking-tighter">{{ $employee->badge_number }}</span>
            </div>
        </div>
    </div>
</div>
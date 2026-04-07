@php $mainColor = $employee->badge_color ?? '#059669'; @endphp
<div class="badge-fixed-container relative bg-white flex flex-col items-center overflow-hidden w-full h-full border border-gray-100">
    
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

    <div class="w-full pt-8 flex-none flex justify-center z-10 px-6">
        @if($employee->company && $employee->company->logo)
            <img src="{{ $getPath($employee->company->logo) }}" class="h-10 w-auto object-contain">
        @endif
    </div>

    <div class="flex-grow flex flex-col items-center justify-center w-full px-6 text-center z-10">
        <div class="w-32 h-36 rounded-2xl overflow-hidden border-2 border-gray-50 shadow-xl mb-4 bg-gray-100">
            <img src="{{ $getPath($employee->photo) }}" class="w-full h-full object-cover">
        </div>

        <h1 class="text-xl font-black uppercase tracking-tighter text-gray-800 leading-tight">
            {{ $employee->first_name }} <br> {{ $employee->last_name }}
        </h1>
        
        <div class="h-[2px] w-8 my-2 rounded-full mx-auto" style="background-color: {{ $mainColor }}"></div>
        
        <p class="text-[11px] font-bold text-gray-600 uppercase tracking-widest">
            {{ $employee->function }}
        </p>
        
        <p class="text-[9px] font-extrabold mt-1 uppercase" style="color: {{ $mainColor }}">
            {{ $employee->department ?? 'DÉPARTEMENT' }}
        </p>
    </div>

    <div class="w-full h-24 flex-none relative mt-auto">
        <div class="absolute inset-0 z-0" style="background-color: {{ $mainColor }}; clip-path: polygon(0 25%, 100% 0, 100% 100%, 0% 100%);"></div>
        
        <div class="relative z-10 h-full w-full px-5 flex justify-between items-center pt-4">
            <div class="bg-white p-1 rounded-lg shadow-md">
                <img src="{{ $getPath($employee->qr_code) }}" class="w-10 h-10">
            </div>
            <div class="text-right flex flex-col">
                <span class="text-[7px] font-bold text-white/70 uppercase tracking-widest">Matricule Officiel</span>
                <span class="text-[11px] font-mono font-black text-white uppercase">{{ $employee->badge_number }}</span>
            </div>
        </div>
    </div>
</div>
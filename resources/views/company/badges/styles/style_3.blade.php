@php $mainColor = $employee->badge_color ?? '#059669'; @endphp
<div class="badge-fixed-container relative bg-white flex flex-col items-center overflow-hidden w-full h-full border border-gray-100">
    
    {{-- Background Design SVG --}}
    <div class="absolute inset-0 opacity-20 pointer-events-none">
        <svg width="100%" height="100%" viewBox="0 0 100 100" preserveAspectRatio="none">
            <path d="M0 20 L15 20 L20 25 M0 50 L10 50 L15 55 M0 80 L20 80 L25 85" fill="none" stroke="{{ $mainColor }}" stroke-width="0.5" />
            <path d="M100 20 L85 20 L80 25 M100 50 L90 50 L85 55 M100 80 L80 80 L75 85" fill="none" stroke="{{ $mainColor }}" stroke-width="0.5" />
            <circle cx="20" cy="25" r="1" fill="{{ $mainColor }}" />
            <circle cx="80" cy="25" r="1" fill="{{ $mainColor }}" />
        </svg>
    </div>

    {{-- Header Logo --}}
    <div class="w-full pt-4 flex-none flex justify-center px-4 z-10">
        @if($employee->company && $employee->company->logo)
            <img src="{{ $getPath($employee->company->logo) }}" class="h-9 w-auto object-contain">
        @endif
    </div>

    <div class="flex-grow flex flex-col items-center justify-center w-full px-4 text-center z-10">
        {{-- PHOTO ULTRA TAILLE : w-52 h-52 avec ombre portée colorée accentuée --}}
        <div class="w-52 h-52 rounded-2xl overflow-hidden mb-4 flex-none relative shadow-2xl border-[3px] border-white" 
             style="box-shadow: 0 10px 30px -10px {{ $mainColor }}88;">
            <img src="{{ $getPath($employee->photo) }}" class="w-full h-full object-cover scale-105">
        </div>

        {{-- Identité --}}
        <h1 class="text-xl font-black uppercase text-gray-900 break-words leading-tight tracking-tight px-2">
            {{ $employee->first_name }} <br>
            <span style="color: {{ $mainColor }}">{{ $employee->last_name }}</span>
        </h1>
        
        <p class="text-[12px] font-black uppercase mt-2 tracking-[0.2em] text-gray-700">{{ $employee->function }}</p>
        
        {{-- Séparateur Design --}}
        <div class="mt-3 flex items-center gap-3 justify-center w-full">
            <div class="h-[1.5px] flex-grow max-w-[30px]" style="background-color: {{ $mainColor }}"></div>
            <p class="text-[10px] font-black uppercase tracking-tighter whitespace-nowrap" style="color: {{ $mainColor }}">
                {{ $employee->department ?? 'GÉNÉRAL' }}
            </p>
            <div class="h-[1.5px] flex-grow max-w-[30px]" style="background-color: {{ $mainColor }}"></div>
        </div>
    </div>

    {{-- Footer --}}
    <div class="w-full px-5 py-4 flex justify-between items-center flex-none border-t border-gray-100 bg-gray-50/30 z-10">
        <div class="flex flex-col">
            <span class="text-[7px] font-bold text-gray-400 uppercase tracking-widest">ID System</span>
            <span class="text-[11px] font-mono font-black text-gray-800 tracking-tight">{{ $employee->badge_number }}</span>
        </div>
        <div class="bg-white p-1 rounded-lg border border-gray-200 shadow-sm">
            <img src="{{ $getPath($employee->qr_code) }}" class="w-10 h-10">
        </div>
    </div>
</div>
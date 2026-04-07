@php $mainColor = $employee->badge_color ?? '#059669'; @endphp
<div class="badge-fixed-container relative bg-white flex flex-col items-center overflow-hidden w-full h-full border border-gray-200">
    
    {{-- Background Design : Ajusté pour la grande photo --}}
    <div class="absolute top-0 left-0 w-full h-40 flex-none" style="background-color: {{ $mainColor }}; clip-path: polygon(0 0, 100% 0, 100% 60%, 0% 100%);"></div>

    {{-- Header avec Logo --}}
    <div class="w-full pt-4 flex-none flex justify-center px-4 z-10">
        @if($employee->company && $employee->company->logo)
            <div class="bg-white/95 p-1.5 rounded-xl backdrop-blur-sm shadow-md">
                <img src="{{ $getPath($employee->company->logo) }}" class="h-7 w-auto object-contain">
            </div>
        @endif
    </div>

    {{-- Corps du badge --}}
    <div class="flex-grow flex flex-col items-center justify-center w-full px-4 text-center z-10 mt-1">
        
        {{-- PHOTO ULTRA : w-52 h-52 (Cercle parfait) --}}
        <div class="w-52 h-52 rounded-full overflow-hidden border-[6px] border-white shadow-2xl mb-4 flex-none relative">
            <img src="{{ $getPath($employee->photo) }}" class="w-full h-full object-cover scale-105">
        </div>

        {{-- Infos Employé --}}
        <div class="mt-2">
            <h1 class="text-xl font-black uppercase tracking-tight text-gray-900 leading-none">
                {{ $employee->first_name }}
            </h1>
            <h1 class="text-2xl font-black uppercase tracking-tighter leading-tight" style="color: {{ $mainColor }}">
                {{ $employee->last_name }}
            </h1>
        </div>
        
        {{-- Séparateur plus marqué --}}
        <div class="w-16 h-1.5 my-3 rounded-full mx-auto" style="background-color: {{ $mainColor }}; opacity: 0.2;"></div>
        
        <div class="space-y-1">
            <p class="text-[12px] font-black text-gray-800 uppercase tracking-wide">{{ $employee->function }}</p>
            
            <p class="text-[9px] font-bold uppercase italic tracking-widest" style="color: {{ $mainColor }}">
                {{ $employee->department ?? 'SANS DÉPARTEMENT' }}
            </p>
        </div>
    </div>

    {{-- Footer avec ID et QR Code --}}
    <div class="w-full p-4 flex justify-between items-center flex-none bg-gray-50/90 border-t border-gray-100">
        <div class="flex flex-col border-l-4 pl-3" style="border-color: {{ $mainColor }}">
            <span class="text-[7px] text-gray-400 font-bold uppercase tracking-widest">Matricule</span>
            <span class="text-[11px] font-mono font-black text-gray-800 uppercase leading-none">{{ $employee->badge_number }}</span>
        </div>
        <div class="p-1 bg-white border border-gray-100 rounded-lg shadow-sm">
            <img src="{{ $getPath($employee->qr_code) }}" class="w-10 h-10">
        </div>
    </div>
</div>
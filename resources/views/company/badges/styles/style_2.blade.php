@php $mainColor = $employee->badge_color ?? '#059669'; @endphp
<div class="badge-fixed-container relative bg-white flex flex-col items-center overflow-hidden w-full h-full border border-gray-200">
    
    {{-- Background Design : Forme géométrique colorée en haut --}}
    <div class="absolute top-0 left-0 w-full h-32 flex-none" style="background-color: {{ $mainColor }}; clip-path: polygon(0 0, 100% 0, 100% 70%, 0% 100%);"></div>

    {{-- Header avec Logo (sur fond coloré) --}}
    <div class="w-full pt-6 flex-none flex justify-center px-4 z-10">
        @if($employee->company && $employee->company->logo)
            <div class="bg-white/90 p-1.5 rounded-lg backdrop-blur-sm shadow-sm">
                <img src="{{ $getPath($employee->company->logo) }}" class="h-8 w-auto object-contain">
            </div>
        @endif
    </div>

    {{-- Corps du badge --}}
    <div class="flex-grow flex flex-col items-center justify-center w-full px-4 text-center z-10 mt-2">
        {{-- Photo avec double bordure --}}
        <div class="w-28 h-28 rounded-full overflow-hidden border-4 border-white shadow-lg mb-3 flex-none relative">
            <img src="{{ $getPath($employee->photo) }}" class="w-full h-full object-cover">
        </div>

        {{-- Infos Employé --}}
        <div class="mt-2">
            <h1 class="text-xl font-black uppercase tracking-tight text-gray-800 leading-none">
                {{ $employee->first_name }}
            </h1>
            <h1 class="text-xl font-black uppercase tracking-tight leading-none" style="color: {{ $mainColor }}">
                {{ $employee->last_name }}
            </h1>
        </div>
        
        <div class="w-10 h-1 my-3 rounded-full mx-auto" style="background-color: {{ $mainColor }}; opacity: 0.3;"></div>
        
        <p class="text-[11px] font-extrabold text-gray-700 uppercase tracking-wider">{{ $employee->function }}</p>
        
        {{-- Département avec style différent --}}
        <p class="text-[9px] font-bold uppercase mt-1 italic" style="color: {{ $mainColor }}">
            — {{ $employee->department ?? 'SANS DÉPARTEMENT' }} —
        </p>
    </div>

    {{-- Footer avec ID et QR Code (plus compact) --}}
    <div class="w-full p-4 flex justify-between items-end flex-none bg-gray-50/80 backdrop-blur-md">
        <div class="flex flex-col border-l-2 pl-3" style="border-color: {{ $mainColor }}">
            <span class="text-[7px] text-gray-400 font-bold uppercase tracking-widest">Matricule</span>
            <span class="text-[10px] font-mono font-black text-gray-700 uppercase leading-none">{{ $employee->badge_number }}</span>
        </div>
        <div class="p-1.5 bg-white border border-gray-200 rounded-md shadow-inner">
            <img src="{{ $getPath($employee->qr_code) }}" class="w-9 h-9">
        </div>
    </div>
</div>
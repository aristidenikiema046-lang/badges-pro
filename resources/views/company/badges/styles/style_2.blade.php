@php 
    $mainColor = $employee->company->badge_color ?? '#059669'; 
@endphp

<div class="relative bg-white flex flex-col items-center overflow-hidden w-full h-full font-sans border border-gray-100">
    <div class="absolute top-0 left-0 w-full h-52 flex-none" 
         style="background-color: {{ $mainColor }}; clip-path: polygon(0 0, 100% 0, 100% 85%, 0% 100%);">
    </div>

    <div class="w-full pt-6 flex-none flex flex-col items-center px-4 z-10">
        @if($employee->company && $employee->company->logo)
            <div class="bg-white p-2 rounded-lg shadow-sm mb-1">
                <img src="{{ $getPath($employee->company->logo) }}" class="h-8 w-auto object-contain">
            </div>
        @endif
        <p class="text-[8px] font-black uppercase tracking-[0.3em] text-white/90 text-center drop-shadow-sm">
            {{ $employee->company->name }}
        </p>
    </div>

    <div class="relative mt-4 z-20">
        <div class="w-32 h-32 rounded-full border-[6px] border-white shadow-xl overflow-hidden bg-gray-100">
            @if($employee->photo)
                <img src="{{ $getPath($employee->photo) }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center bg-gray-200">
                    <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
            @endif
        </div>
        @if($employee->is_validated)
        <div class="absolute bottom-1 right-1 bg-green-500 border-2 border-white w-6 h-6 rounded-full flex items-center justify-center shadow-lg">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        @endif
    </div>

    <div class="flex-grow flex flex-col items-center justify-center w-full px-6 text-center mt-2">
        <div class="space-y-0 w-full">
            <h2 class="text-xl font-bold uppercase tracking-tight text-gray-700 leading-none">
                {{ $employee->first_name }}
            </h2>
            <h1 class="text-3xl font-black uppercase tracking-tighter leading-none mb-2" style="color: {{ $mainColor }}">
                {{ $employee->last_name }}
            </h1>
        </div>
        
        <div class="w-full bg-gray-50 py-2 rounded-xl border border-gray-100">
            <p class="text-[12px] font-black text-gray-800 uppercase tracking-wider">
                {{ $employee->function }}
            </p>
            <p class="text-[10px] font-bold uppercase italic" style="color: {{ $mainColor }}">
                {{ $employee->department ?? 'SANS DÉPARTEMENT' }}
            </p>
        </div>

        <div class="mt-4 opacity-90 hover:opacity-100 transition-opacity">
            {!! QrCode::size(70)->margin(0)->color(substr($mainColor, 1, 2) ? 0 : 0, 0, 0)->generate($employee->matricule) !!}
        </div>
    </div>

    <div class="w-full p-4 flex justify-between items-center flex-none bg-white border-t border-dashed border-gray-200">
        <div class="flex flex-col">
            <span class="text-[7px] text-gray-400 font-bold uppercase tracking-widest">Matricule</span>
            <span class="text-[11px] font-mono font-black text-gray-800 tracking-tighter">{{ $employee->matricule }}</span>
        </div>
        <div class="h-8 w-[1px] bg-gray-200"></div>
        <div class="flex flex-col text-right">
            <span class="text-[7px] text-gray-400 font-bold uppercase tracking-widest">Contact</span>
            <span class="text-[9px] font-bold text-gray-700 truncate max-w-[120px]">{{ $employee->email }}</span>
        </div>
    </div>
</div>
@php $mainColor = $employee->badge_color ?? '#059669'; @endphp
<div class="badge-fixed-container relative bg-white flex flex-col items-center overflow-hidden w-full h-full border border-gray-100">
    
    <div class="absolute inset-0 opacity-20 pointer-events-none">
        <svg width="100%" height="100%" viewBox="0 0 100 100" preserveAspectRatio="none">
            <path d="M0 20 L15 20 L20 25 M0 50 L10 50 L15 55 M0 80 L20 80 L25 85" fill="none" stroke="{{ $mainColor }}" stroke-width="0.5" />
            <path d="M100 20 L85 20 L80 25 M100 50 L90 50 L85 55 M100 80 L80 80 L75 85" fill="none" stroke="{{ $mainColor }}" stroke-width="0.5" />
            <circle cx="20" cy="25" r="1" fill="{{ $mainColor }}" />
            <circle cx="80" cy="25" r="1" fill="{{ $mainColor }}" />
        </svg>
    </div>

    <div class="w-full pt-6 flex-none flex justify-center px-4 z-10">
        @if($employee->company && $employee->company->logo)
            <img src="{{ $getPath($employee->company->logo) }}" class="h-10 w-auto object-contain">
        @endif
    </div>

    <div class="flex-grow flex flex-col items-center justify-center w-full px-4 text-center z-10">
        <div class="w-32 h-32 rounded-xl overflow-hidden mb-4 flex-none relative shadow-[0_0_15px_rgba(0,0,0,0.1)] border-2 border-white" 
             style="box-shadow: 0 0 20px -5px {{ $mainColor }}44;">
            <img src="{{ $getPath($employee->photo) }}" class="w-full h-full object-cover">
        </div>

        <h1 class="text-xl font-black uppercase text-gray-800 break-words leading-none tracking-tight">
            {{ $employee->first_name }} <span style="color: {{ $mainColor }}">{{ $employee->last_name }}</span>
        </h1>
        
        <p class="text-[11px] font-bold uppercase mt-2 tracking-widest text-gray-600">{{ $employee->function }}</p>
        
        <div class="mt-2 flex items-center gap-2">
            <div class="h-[1px] w-4" style="background-color: {{ $mainColor }}"></div>
            <p class="text-[9px] font-extrabold uppercase tracking-tighter" style="color: {{ $mainColor }}">{{ $employee->department ?? 'GÉNÉRAL' }}</p>
            <div class="h-[1px] w-4" style="background-color: {{ $mainColor }}"></div>
        </div>
    </div>

    <div class="w-full px-4 py-3 flex justify-between items-center flex-none border-t border-gray-50 bg-gray-50/50 z-10">
        <div class="flex flex-col">
            <span class="text-[7px] font-bold text-gray-400 uppercase tracking-widest">ID System</span>
            <span class="text-[10px] font-mono font-black text-gray-700">{{ $employee->badge_number }}</span>
        </div>
        <div class="bg-white p-1 rounded-md border border-gray-100 shadow-sm">
            <img src="{{ $getPath($employee->qr_code) }}" class="w-8 h-8">
        </div>
    </div>
</div>
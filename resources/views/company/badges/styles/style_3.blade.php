@php $mainColor = $employee->company->badge_color ?? '#059669'; @endphp
<div class="badge-fixed-container relative bg-white flex flex-col items-center overflow-hidden w-full h-full border border-gray-100">
    {{-- Motifs vectoriels --}}
    <div class="absolute inset-0 opacity-10 pointer-events-none">
        <svg width="100%" height="100%" viewBox="0 0 100 100" preserveAspectRatio="none">
            <circle cx="100" cy="0" r="40" fill="{{ $mainColor }}" />
            <circle cx="0" cy="100" r="30" fill="{{ $mainColor }}" />
        </svg>
    </div>

    <div class="w-full py-10 flex flex-col items-center z-10">
        @if($employee->company && $employee->company->logo)
            <img src="{{ $getPath($employee->company->logo) }}" class="h-12 w-auto object-contain">
        @endif
    </div>

    <div class="flex-grow flex flex-col items-center justify-center w-full px-6 text-center z-10">
        <div class="mb-10 relative">
            {{-- Décoration autour du QR --}}
            <div class="absolute -inset-4 border border-dashed rounded-full animate-spin-slow opacity-20" style="border-color: {{ $mainColor }}"></div>
            <div class="bg-white p-4 rounded-3xl shadow-lg relative">
                {!! QrCode::size(150)->margin(1)->generate($employee->matricule) !!}
            </div>
        </div>

        <h1 class="text-4xl font-black uppercase text-gray-900 leading-tight tracking-tighter">
            {{ $employee->last_name }}
        </h1>
        <h1 class="text-xl font-bold uppercase tracking-[0.2em] mt-2" style="color: {{ $mainColor }}">
            {{ $employee->first_name }}
        </h1>
        
        <div class="mt-8 flex items-center gap-4 w-full">
            <div class="h-px flex-grow bg-gray-200"></div>
            <p class="text-[12px] font-black uppercase text-gray-500">{{ $employee->function }}</p>
            <div class="h-px flex-grow bg-gray-200"></div>
        </div>
    </div>

    <div class="w-full px-8 py-6 flex flex-col items-center flex-none border-t border-gray-50 bg-gray-50/50">
        <span class="text-[8px] font-bold text-gray-400 uppercase tracking-[0.4em] mb-1">Authentic ID</span>
        <span class="text-sm font-mono font-black text-gray-800">{{ $employee->matricule }}</span>
    </div>
</div>
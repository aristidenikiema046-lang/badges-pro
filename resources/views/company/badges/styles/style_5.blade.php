@php $mainColor = $employee->company->badge_color ?? '#059669'; @endphp
<div class="badge-fixed-container relative bg-white flex flex-col items-center overflow-hidden w-full h-full border border-gray-100">
    <div class="absolute inset-0 opacity-20 pointer-events-none">
        <svg width="100%" height="100%" viewBox="0 0 100 120" fill="none" stroke="{{ $mainColor }}" stroke-width="0.5">
            <path d="M0 40 L100 40 M0 80 L100 80 M40 0 L40 120 M80 0 L80 120" stroke-dasharray="2 2" />
        </svg>
    </div>

    <div class="w-full pt-10 flex-none flex justify-center z-10 px-6">
        @if($employee->company && $employee->company->logo)
            <img src="{{ $getPath($employee->company->logo) }}" class="h-10 w-auto object-contain bg-white px-4 py-2 rounded-full shadow-sm">
        @endif
    </div>

    <div class="flex-grow flex flex-col items-center justify-center w-full px-6 text-center z-10">
        <div class="bg-gray-900 p-6 rounded-[3rem] shadow-[0_20px_50px_rgba(0,0,0,0.2)] mb-8">
            <div class="bg-white p-3 rounded-[2rem]">
                {!! QrCode::size(160)->margin(1)->generate($employee->matricule) !!}
            </div>
        </div>

        <div class="mb-4">
            <h1 class="text-2xl font-black uppercase tracking-widest text-gray-900">
                {{ $employee->last_name }}
            </h1>
            <div class="h-1 w-12 bg-gray-900 mx-auto my-2"></div>
            <h1 class="text-xl font-bold uppercase" style="color: {{ $mainColor }}">
                {{ $employee->first_name }}
            </h1>
        </div>
        
        <p class="text-[12px] font-black text-gray-500 uppercase tracking-[0.3em]">
            {{ $employee->function }}
        </p>
    </div>

    <div class="w-full h-16 flex-none flex items-center justify-center relative z-10">
        <div class="absolute inset-0" style="background-color: {{ $mainColor }}; clip-path: polygon(0 100%, 100% 100%, 100% 0);"></div>
        <span class="relative text-white font-mono font-black tracking-widest text-sm pt-4">#{{ $employee->matricule }}</span>
    </div>
</div>
@php 
    $mainColor = $employee->badge_color ?? '#3b82f6'; 
    $is_export = isset($isPdf) && $isPdf;

    $getPath = function($path) use ($is_export) {
        if (empty($path)) return '';
        return $is_export ? public_path('storage/' . $path) : asset('storage/' . $path);
    };
@endphp

<div class="badge-fixed-container relative bg-[#f8fafc] flex flex-col items-center overflow-hidden font-sans" 
     style="width: 54mm; height: 85.6mm; min-width: 54mm; min-height: 85.6mm; box-sizing: border-box;">
    
    <div class="absolute inset-0 opacity-[0.08]" style="pointer-events: none;">
        <svg width="100%" height="100%" viewBox="0 0 100 100" preserveAspectRatio="none">
            <path d="M0 30 L15 30 L20 25 M0 70 L20 70 L30 80 M100 20 L85 20 L80 15 M100 80 L80 80 L70 70" stroke="{{ $mainColor }}" fill="none" stroke-width="0.5"/>
            <circle cx="20" cy="25" r="0.8" fill="{{ $mainColor }}"/>
            <circle cx="80" cy="15" r="0.8" fill="{{ $mainColor }}"/>
        </svg>
    </div>

    <div class="w-full pt-8 px-6 flex justify-center z-10">
        @if($employee->company && $employee->company->logo)
            <img src="{{ $getPath($employee->company->logo) }}" class="h-10 w-auto object-contain">
        @else
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 rounded-full" style="background-color: {{ $mainColor }}"></div>
                <span class="font-bold text-xl tracking-tighter text-slate-800">Paymetrust</span>
            </div>
        @endif
    </div>

    <div class="mt-8 relative z-10">
        <div class="w-36 h-44 rounded-xl overflow-hidden border-[3px] border-white shadow-2xl bg-white">
            @if($employee->photo)
                <img src="{{ $getPath($employee->photo) }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center bg-slate-100 text-slate-300">
                    <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 20 20"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path></svg>
                </div>
            @endif
        </div>
    </div>

    <div class="mt-6 px-4 text-center z-10">
        <h1 class="text-2xl font-black uppercase tracking-tight text-[#2563eb] leading-tight">
            {{ $employee->first_name }} {{ $employee->last_name }}
        </h1>
        <p class="mt-1 text-sm font-semibold text-slate-500 uppercase tracking-wide">
            {{ $employee->function }}
        </p>
    </div>

    <div class="mt-auto w-full px-6 pb-6 flex justify-end items-end z-10">
        <div class="p-1.5 bg-white border border-slate-100 rounded-xl shadow-sm">
            <img src="{{ $getPath($employee->qr_code) }}" class="w-12 h-12">
        </div>
    </div>

    <div class="absolute top-3 left-1/2 -translate-x-1/2 w-8 h-1.5 bg-slate-200 rounded-full"></div>
</div>
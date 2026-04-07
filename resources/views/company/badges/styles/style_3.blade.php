@php 
    $mainColor = $employee->badge_color ?? '#2563eb'; 
    $is_export = isset($isPdf) && $isPdf;

    $getPath = function($path) use ($is_export) {
        if (empty($path)) return '';
        return $is_export ? public_path('storage/' . $path) : asset('storage/' . $path);
    };
@endphp

<div class="badge-fixed-container relative bg-white flex flex-col items-center overflow-hidden font-sans" 
     style="width: 54mm; height: 85.6mm; min-width: 54mm; min-height: 85.6mm; box-sizing: border-box;">
    
    <div class="absolute inset-0 m-2 border border-slate-300 opacity-60" style="pointer-events: none;">
        <div class="absolute top-0 left-0 w-2 h-2 border-t border-l" style="border-color: {{ $mainColor }}"></div>
        <div class="absolute bottom-0 right-0 w-2 h-2 border-b border-r" style="border-color: {{ $mainColor }}"></div>
        <div class="absolute top-4 right-[-1px] w-1 h-4 bg-slate-200"></div>
    </div>

    <div class="w-full pt-8 px-6 flex justify-center z-10">
        @if($employee->company && $employee->company->logo)
            <img src="{{ $getPath($employee->company->logo) }}" class="h-9 w-auto object-contain">
        @else
            <div class="flex items-center gap-2">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <circle cx="12" cy="12" r="10" fill="{{ $mainColor }}"/>
                    <circle cx="12" cy="12" r="4" fill="white"/>
                </svg>
                <span class="font-bold text-lg tracking-tight text-slate-800">Paymetrust</span>
            </div>
        @endif
    </div>

    <div class="mt-8 relative z-10">
        <div class="w-36 h-40 rounded-xl overflow-hidden bg-slate-100 shadow-sm border border-slate-100">
            @if($employee->photo)
                <img src="{{ $getPath($employee->photo) }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center text-slate-300">
                    <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path></svg>
                </div>
            @endif
        </div>
    </div>

    <div class="mt-8 px-4 text-center z-10">
        <h1 class="text-xl font-black uppercase tracking-tight text-slate-800 leading-none">
            {{ $employee->first_name }} {{ $employee->last_name }}
        </h1>
        <p class="mt-2 text-sm font-medium text-slate-500">
            {{ $employee->function }}
        </p>
    </div>

    <div class="mt-auto w-full h-10 flex items-center justify-center z-10" 
         style="background: linear-gradient(to right, {{ $mainColor }}, {{ $mainColor }}dd);">
        <span class="text-[10px] font-bold text-white uppercase tracking-[0.2em]">
            ID : {{ $employee->badge_number }}
        </span>
    </div>

    <div class="absolute top-3 left-1/2 -translate-x-1/2 w-10 h-2 bg-slate-200 rounded-full opacity-50"></div>
</div>
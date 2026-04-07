@php $mainColor = $employee->badge_color ?? '#0066ff'; $is_export = isset($isPdf) && $isPdf; $getPath = function($path) use ($is_export) { if (empty($path)) return ''; return $is_export ? public_path('storage/' . $path) : asset('storage/' . $path); }; @endphp

<div class="badge-fixed-container relative bg-white flex flex-col items-center overflow-hidden font-sans" 
     style="width: 54mm; height: 85.6mm; min-width: 54mm; min-height: 85.6mm; box-sizing: border-box;">
    
    <div class="absolute inset-0 opacity-[0.06]" style="pointer-events: none;">
        <svg width="100%" height="100%" viewBox="0 0 100 100" preserveAspectRatio="none"><path d="M10 0 L10 10 L0 20 M90 0 L90 10 L100 20 M10 100 L10 90 L0 80 M90 100 L90 90 L100 80" stroke="{{ $mainColor }}" fill="none" stroke-width="0.5"/></svg>
    </div>

    <div class="w-full pt-10 px-6 flex justify-center z-10">
        @if($employee->company && $employee->company->logo)
            <img src="{{ $getPath($employee->company->logo) }}" class="h-10 w-auto object-contain">
        @endif
    </div>

    <div class="mt-8 relative z-10">
        <div class="w-36 h-40 rounded-xl overflow-hidden border bg-slate-50 border-slate-100 shadow-lg">
            @if($employee->photo)
                <img src="{{ $getPath($employee->photo) }}" class="w-full h-full object-cover">
            @endif
        </div>
    </div>

    <div class="mt-8 px-4 text-center z-10">
        <h1 class="text-2xl font-black uppercase tracking-tight text-slate-900 leading-tight">
            {{ $employee->first_name }} <br> {{ $employee->last_name }}
        </h1>
        <p class="mt-2 text-sm font-semibold text-slate-500">
            {{ $employee->function }}
        </p>
    </div>
</div>
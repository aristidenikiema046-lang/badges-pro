@php $mainColor = $employee->badge_color ?? '#0066ff'; $is_export = isset($isPdf) && $isPdf; $getPath = function($path) use ($is_export) { if (empty($path)) return ''; return $is_export ? public_path('storage/' . $path) : asset('storage/' . $path); }; @endphp

<div class="badge-fixed-container relative bg-white flex flex-col items-center overflow-hidden font-sans" 
     style="width: 54mm; height: 85.6mm; min-width: 54mm; min-height: 85.6mm; box-sizing: border-box;">
    
    <div class="absolute inset-0 opacity-[0.1]" style="pointer-events: none;">
        <svg width="100%" height="100%" viewBox="0 0 100 100" preserveAspectRatio="none">
            <path d="M0 0 L15 15 M100 0 L85 15 M0 100 L15 85 M100 100 L85 85" stroke="{{ $mainColor }}" fill="none" stroke-width="1.5"/>
            <circle cx="15" cy="15" r="2" fill="{{ $mainColor }}"/>
            <circle cx="85" cy="15" r="2" fill="{{ $mainColor }}"/>
            <circle cx="15" cy="85" r="2" fill="{{ $mainColor }}"/>
            <circle cx="85" cy="85" r="2" fill="{{ $mainColor }}"/>
        </svg>
    </div>

    <div class="w-full pt-10 px-6 flex justify-center z-10">
        @if($employee->company && $employee->company->logo)
            <img src="{{ $getPath($employee->company->logo) }}" class="h-10 w-auto object-contain">
        @endif
    </div>

    <div class="mt-10 relative z-10">
        <div class="w-36 h-36 rounded-2xl overflow-hidden border-2 bg-white flex items-center justify-center shadow-lg" style="border-color: {{ $mainColor }};">
            @if($employee->photo)
                <img src="{{ $getPath($employee->photo) }}" class="w-full h-full object-cover">
            @endif
        </div>
    </div>

    <div class="mt-10 px-4 text-center z-10">
        <h1 class="text-2xl font-black uppercase tracking-tight text-slate-900 leading-tight">
            {{ $employee->first_name }} {{ $employee->last_name }}
        </h1>
        <p class="mt-2 text-sm font-semibold text-slate-500">
            {{ $employee->function }}
        </p>
    </div>
</div>
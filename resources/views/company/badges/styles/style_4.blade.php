@php 
    $mainColor = $employee->badge_color ?? '#0066ff'; 
    $is_export = isset($isPdf) && $isPdf;
    $getPath = function($path) use ($is_export) {
        if (empty($path)) return '';
        return $is_export ? public_path('storage/' . $path) : asset('storage/' . $path);
    };
@endphp

<div class="badge-fixed-container relative bg-white flex overflow-hidden font-sans" 
     style="width: 85.6mm; height: 54mm; min-width: 85.6mm; min-height: 54mm; box-sizing: border-box; border: 1px solid #eee;">
    
    <div class="absolute left-0 top-0 bottom-0 w-16 opacity-[0.12]" style="pointer-events: none;">
        <svg width="100%" height="100%" viewBox="0 0 50 100" preserveAspectRatio="none">
            <path d="M0 20 L20 20 L25 15 M0 50 L25 50 L30 55 M0 80 L20 80 L25 85" stroke="{{ $mainColor }}" fill="none" stroke-width="0.5"/>
            <circle cx="25" cy="15" r="1.2" fill="{{ $mainColor }}"/>
            <circle cx="30" cy="55" r="1.2" fill="{{ $mainColor }}"/>
            <circle cx="25" cy="85" r="1.2" fill="{{ $mainColor }}"/>
        </svg>
    </div>

    <div class="w-[45%] h-full flex items-center justify-center pl-6 relative z-10">
        <div class="w-32 h-36 rounded-2xl overflow-hidden shadow-xl border-2 bg-slate-50" style="border-color: {{ $mainColor }};">
            @if($employee->photo)
                <img src="{{ $getPath($employee->photo) }}" class="w-full h-full object-cover">
            @endif
        </div>
    </div>

    <div class="w-[55%] pr-8 py-6 flex flex-col justify-center items-end text-right z-10">
        @if($employee->company && $employee->company->logo)
            <img src="{{ $getPath($employee->company->logo) }}" class="h-8 w-auto object-contain mb-4">
        @endif
        
        <h1 class="text-xl font-black uppercase text-slate-900 leading-tight">
            {{ $employee->first_name }} <br>
            {{ $employee->last_name }}
        </h1>
        <p class="mt-1 text-sm font-semibold" style="color: {{ $mainColor }}">
            {{ $employee->function }}
        </p>
    </div>
</div>
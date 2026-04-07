@php 
    $mainColor = $employee->badge_color ?? '#0066ff'; 
    $is_export = isset($isPdf) && $isPdf;
    $getPath = function($path) use ($is_export) {
        if (empty($path)) return '';
        return $is_export ? public_path('storage/' . $path) : asset('storage/' . $path);
    };
@endphp

<div class="badge-fixed-container relative bg-white flex flex-col items-center overflow-hidden font-sans" 
     style="width: 54mm; height: 85.6mm; min-width: 54mm; min-height: 85.6mm; box-sizing: border-box; border: 1px solid #eee;">
    
    <div class="absolute inset-0 opacity-[0.12]" style="pointer-events: none;">
        <svg width="100%" height="100%" viewBox="0 0 100 100" preserveAspectRatio="none">
            <path d="M0 10 L10 10 L15 5 M90 0 L90 5 L85 10 M100 20 L95 20 L90 15 M0 30 L5 30 L10 25 M0 70 L5 70 L10 75 M100 80 L95 80 L90 85 M0 90 L10 90 L15 95 M100 90 L90 90 L85 85" stroke="{{ $mainColor }}" fill="none" stroke-width="0.3"/>
            <circle cx="15" cy="5" r="0.6" fill="{{ $mainColor }}"/>
            <circle cx="90" cy="15" r="0.6" fill="{{ $mainColor }}"/>
            <circle cx="10" cy="75" r="0.6" fill="{{ $mainColor }}"/>
            <circle cx="90" cy="85" r="0.6" fill="{{ $mainColor }}"/>
        </svg>
    </div>

    <div class="w-full pt-8 px-6 flex justify-center z-10">
        @if($employee->company && $employee->company->logo)
            <img src="{{ $getPath($employee->company->logo) }}" class="h-10 w-auto object-contain">
        @else
            <div class="flex items-center gap-2">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" fill="{{ $mainColor }}"/><circle cx="12" cy="12" r="4" fill="white"/></svg>
                <span class="font-bold text-xl tracking-tighter text-slate-800">Paymetrust</span>
            </div>
        @endif
    </div>

    <div class="mt-8 relative z-10">
        <div class="w-36 h-36 rounded-2xl overflow-hidden border-2 bg-white flex items-center justify-center" 
             style="border-color: {{ $mainColor }}; box-shadow: 0 0 15px {{ $mainColor }}66;">
            @if($employee->photo)
                <img src="{{ $getPath($employee->photo) }}" class="w-full h-full object-cover">
            @else
                <svg class="w-16 h-16 text-gray-200" fill="currentColor" viewBox="0 0 20 20"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path></svg>
            @endif
        </div>
    </div>

    <div class="mt-8 px-4 text-center z-10">
        <h1 class="text-2xl font-black uppercase tracking-tight leading-tight" style="color: {{ $mainColor }}">
            {{ $employee->first_name }} {{ $employee->last_name }}
        </h1>
        <p class="mt-2 text-sm font-semibold" style="color: {{ $mainColor }}aa">
            {{ $employee->function }}
        </p>
    </div>
</div>
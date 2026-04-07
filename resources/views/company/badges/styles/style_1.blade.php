@php 
    $mainColor = $employee->badge_color ?? '#0066ff'; 
    $is_export = isset($isPdf) && $isPdf;
    $getPath = function($path) use ($is_export) {
        if (empty($path)) return '';
        return $is_export ? public_path('storage/' . $path) : asset('storage/' . $path);
    };
@endphp

<div class="badge-fixed-container relative bg-white flex flex-col items-center overflow-hidden font-sans w-full h-full" 
     style="box-sizing: border-box; border: 1px solid #eee;">
    
    <div class="absolute inset-0 opacity-[0.12]" style="pointer-events: none;">
        <svg width="100%" height="100%" viewBox="0 0 100 100" preserveAspectRatio="none">
            <path d="M0 10 L10 10 L15 5 M90 0 L90 5 L85 10 M100 20 L95 20 L90 15 M0 30 L5 30 L10 25 M0 70 L5 70 L10 75 M100 80 L95 80 L90 85 M0 90 L10 90 L15 95 M100 90 L90 90 L85 85" stroke="{{ $mainColor }}" fill="none" stroke-width="0.3"/>
        </svg>
    </div>

    <div class="w-full pt-6 px-6 flex justify-center z-10 flex-none">
        @if($employee->company && $employee->company->logo)
            <img src="{{ $getPath($employee->company->logo) }}" class="h-12 w-auto object-contain">
        @else
            <div class="flex items-center gap-2">
                <span class="font-bold text-xl tracking-tighter text-slate-800">Paymetrust</span>
            </div>
        @endif
    </div>

    <div class="flex-grow flex flex-col items-center justify-center z-10 w-full px-4">
        <div class="w-32 h-32 rounded-2xl overflow-hidden border-2 bg-white shadow-lg mb-4 flex-none" 
             style="border-color: {{ $mainColor }};">
            @if($employee->photo)
                <img src="{{ $getPath($employee->photo) }}" class="w-full h-full object-cover">
            @else
                <svg class="w-12 h-12 text-gray-200" fill="currentColor" viewBox="0 0 20 20"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path></svg>
            @endif
        </div>

        <div class="text-center w-full">
            <h1 class="text-xl md:text-2xl font-black uppercase tracking-tight leading-tight break-words" style="color: {{ $mainColor }}">
                {{ $employee->first_name }} <br> {{ $employee->last_name }}
            </h1>
            <p class="mt-1 text-sm font-bold uppercase tracking-widest opacity-70" style="color: {{ $mainColor }}">
                {{ $employee->function }}
            </p>
        </div>
    </div>

    <div class="w-full p-4 flex justify-between items-end z-10 flex-none border-t border-slate-50">
        <div class="text-left">
            <p class="text-[9px] font-bold text-slate-400">ID NUMBER</p>
            <p class="text-xs font-black text-slate-700">{{ $employee->badge_number ?? 'N/A' }}</p>
        </div>
        
        @if($employee->qr_code)
            <div class="bg-white p-1 rounded-lg border border-slate-100 shadow-sm">
                <img src="{{ $getPath($employee->qr_code) }}" class="w-12 h-12 object-contain">
            </div>
        @endif
    </div>
</div>
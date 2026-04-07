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
    
    <div class="absolute inset-0 opacity-10" style="pointer-events: none;">
        <svg width="100%" height="100%" viewBox="0 0 100 100" preserveAspectRatio="none">
            <path d="M0 20 L20 20 L25 15 M80 0 L80 10 L90 20 M0 80 L10 80 L20 90 M100 70 L90 70 L80 60" stroke="{{ $mainColor }}" fill="none" stroke-width="0.5"/>
            <circle cx="25" cy="15" r="1" fill="{{ $mainColor }}"/>
            <circle cx="80" cy="60" r="1" fill="{{ $mainColor }}"/>
        </svg>
    </div>

    <div class="w-full pt-6 px-4 flex justify-center z-10">
        @if($employee->company && $employee->company->logo)
            <img src="{{ $getPath($employee->company->logo) }}" class="h-10 w-auto object-contain">
        @else
            <span class="font-bold text-xl uppercase tracking-tighter" style="color: {{ $mainColor }}">ENTREPRISE</span>
        @endif
    </div>

    <div class="mt-6 relative z-10">
        <div class="w-32 h-32 rounded-2xl overflow-hidden border-2 bg-white shadow-xl flex items-center justify-center" 
             style="border-color: {{ $mainColor }}; box-shadow: 0 0 15px {{ $mainColor }}44;">
            @if($employee->photo)
                <img src="{{ $getPath($employee->photo) }}" class="w-full h-full object-cover">
            @else
                <svg class="w-16 h-16 text-gray-200" fill="currentColor" viewBox="0 0 20 20"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path></svg>
            @endif
        </div>
    </div>

    <div class="mt-6 px-4 text-center z-10 w-full">
        <h1 class="text-xl font-black uppercase tracking-tight text-gray-900 leading-tight">
            {{ $employee->first_name }} <br> 
            <span style="color: {{ $mainColor }}">{{ $employee->last_name }}</span>
        </h1>
        
        <p class="mt-2 text-sm font-semibold text-gray-600">
            {{ $employee->function }}
        </p>
        
        <div class="mt-1 flex items-center justify-center gap-2">
            <span class="h-[1px] w-4 bg-gray-300"></span>
            <p class="text-[9px] font-bold uppercase text-gray-400 tracking-widest">
                {{ $employee->department ?? 'Opérations' }}
            </p>
            <span class="h-[1px] w-4 bg-gray-300"></span>
        </div>
    </div>

    <div class="mt-auto w-full px-4 pb-4 flex justify-between items-end z-10">
        <div class="flex flex-col">
            <span class="text-[7px] font-bold text-gray-400 uppercase tracking-tighter">Matricule</span>
            <span class="text-xs font-mono font-black text-gray-800">{{ $employee->badge_number }}</span>
        </div>
        
        <div class="p-1 bg-white border border-gray-100 rounded-sm shadow-sm">
            <img src="{{ $getPath($employee->qr_code) }}" class="w-10 h-10">
        </div>
    </div>

    <div class="absolute bottom-0 left-0 w-full h-1" style="background-color: {{ $mainColor }}"></div>
</div>
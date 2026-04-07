@php 
    /**
     * Configuration des couleurs et des chemins
     * Le paramètre $isPdf est envoyé par le contrôleur lors de l'export dompdf
     */
    $mainColor = $employee->badge_color ?? '#1e293b'; 
    $is_export = isset($isPdf) && $isPdf;

    $getPath = function($path) use ($is_export) {
        if (empty($path)) return '';
        // dompdf nécessite des chemins absolus (public_path) pour accéder aux fichiers locaux
        return $is_export ? public_path('storage/' . $path) : asset('storage/' . $path);
    };
@endphp

<div class="badge-fixed-container relative bg-white flex overflow-hidden font-sans" 
     style="--main-color: {{ $mainColor }}; width: 85.6mm; height: 54mm; min-width: 85.6mm; min-height: 54mm; box-sizing: border-box;">
    
    <div class="relative z-10 flex items-center justify-center" 
         style="background-color: var(--main-color); width: 115px; height: 100%;">
        
        <div class="w-28 h-36 rounded-xl overflow-hidden border-2 border-white shadow-lg transform -rotate-1 translate-x-6 bg-gray-100">
            @if($employee->photo)
                <img src="{{ $getPath($employee->photo) }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center text-gray-400">
                    <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path></svg>
                </div>
            @endif
        </div>
        
        <div class="absolute right-[-15px] top-0 h-full w-10 z-[-1] transform skew-x-[-7deg]" 
             style="background-color: var(--main-color);"></div>
    </div>

    <div class="flex-1 pl-12 pr-6 py-4 flex flex-col justify-between items-end text-right">
        
        <div class="flex justify-between items-start w-full">
            <div class="p-1 bg-white border border-gray-100 shadow-sm">
                <img src="{{ $getPath($employee->qr_code) }}" class="w-10 h-10">
            </div>
            @if($employee->company && $employee->company->logo)
                <img src="{{ $getPath($employee->company->logo) }}" class="h-8 w-auto object-contain">
            @endif
        </div>

        <div class="mt-1">
            <h1 class="text-2xl font-black text-gray-900 uppercase leading-tight">{{ $employee->first_name }}</h1>
            <h2 class="text-2xl font-light text-gray-700 uppercase leading-none mb-1">{{ $employee->last_name }}</h2>
            <div class="h-1 w-12 bg-[var(--main-color)] ml-auto mb-2"></div>
            
            <p class="text-sm font-bold italic" style="color: var(--main-color);">{{ $employee->function }}</p>
            <p class="text-[8px] font-black uppercase text-gray-400 tracking-widest">{{ $employee->department ?? 'Direction' }}</p>
        </div>

        <div class="mt-auto">
            <span class="block text-[7px] font-bold text-gray-400 uppercase tracking-tighter">Matricule Employé</span>
            <span class="text-sm font-mono font-black text-gray-800">{{ $employee->badge_number }}</span>
        </div>
    </div>
</div>
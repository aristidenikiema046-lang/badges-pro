@php 
    $mainColor = $employee->badge_color ?? '#0f172a'; 
    $is_export = isset($isPdf) && $isPdf;
    $getPath = function($path) use ($is_export) {
        if (empty($path)) return '';
        return $is_export ? public_path('storage/' . $path) : asset('storage/' . $path);
    };
@endphp

<div class="badge-fixed-container relative bg-white flex flex-col items-center overflow-hidden w-full h-full border">
    <div class="w-full pt-8 flex-none flex justify-center">
        <img src="{{ $getPath($employee->company->logo) }}" class="h-10 w-auto object-contain">
    </div>

    <div class="flex-grow flex flex-col items-center justify-center w-full px-6 text-center">
        <div class="w-36 h-36 rounded-full border-4 border-slate-50 shadow-inner overflow-hidden mb-6 flex-none">
            <img src="{{ $getPath($employee->photo) }}" class="w-full h-full object-cover">
        </div>
        <h1 class="text-xl font-black uppercase tracking-tight text-slate-900 break-words leading-tight">
            {{ $employee->first_name }} <br> {{ $employee->last_name }}
        </h1>
        <p class="text-xs font-bold text-slate-400 mt-2 uppercase tracking-[0.2em]">{{ $employee->function }}</p>
    </div>
    
    <div class="p-6 flex-none">
        <img src="{{ $getPath($employee->qr_code) }}" class="w-12 h-12 opacity-60">
    </div>
</div>
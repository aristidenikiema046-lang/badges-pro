@php 
    $mainColor = $employee->badge_color ?? '#0066ff'; 
    $is_export = isset($isPdf) && $isPdf;
    $getPath = function($path) use ($is_export) {
        if (empty($path)) return '';
        return $is_export ? public_path('storage/' . $path) : asset('storage/' . $path);
    };
@endphp

<div class="badge-fixed-container relative bg-white flex flex-col items-center overflow-hidden w-full h-full">
    <div class="absolute inset-0 opacity-[0.1]" style="pointer-events: none;">
        <svg width="100%" height="100%">
            <circle cx="15" cy="15" r="2" fill="{{ $mainColor }}"/>
            <circle cx="85" cy="85" r="2" fill="{{ $mainColor }}"/>
            <circle cx="85" cy="15" r="2" fill="{{ $mainColor }}"/>
            <circle cx="15" cy="85" r="2" fill="{{ $mainColor }}"/>
        </svg>
    </div>

    <div class="w-full pt-10 flex-none flex justify-center z-10">
        <img src="{{ $getPath($employee->company->logo) }}" class="h-9 w-auto">
    </div>

    <div class="flex-grow flex flex-col items-center justify-center z-10 px-6 text-center">
        <div class="w-32 h-32 rounded-3xl rotate-3 overflow-hidden border-2 bg-white shadow-lg mb-6 flex-none" style="border-color: {{ $mainColor }};">
            <img src="{{ $getPath($employee->photo) }}" class="w-full h-full object-cover -rotate-3">
        </div>
        <h1 class="text-xl font-black uppercase text-slate-900 break-words w-full leading-tight">
            {{ $employee->first_name }} {{ $employee->last_name }}
        </h1>
        <div class="h-1 w-10 my-3 rounded-full self-center" style="background-color: {{ $mainColor }}"></div>
        <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">{{ $employee->function }}</p>
    </div>
    
    <div class="w-full p-6 flex justify-center flex-none">
        <span class="text-[10px] font-black text-slate-300 tracking-[0.4em] italic uppercase">ID: {{ $employee->badge_number }}</span>
    </div>
</div>
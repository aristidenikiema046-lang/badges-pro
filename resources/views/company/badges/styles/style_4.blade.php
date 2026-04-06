@php 
    $mainColor = $employee->badge_color ?? '#059669'; 
    $is_export = isset($isPdf) && $isPdf;
    $getPath = function($path) use ($is_export) {
        return $is_export ? public_path('storage/' . $path) : asset('storage/' . $path);
    };
@endphp
<div class="relative w-full h-full bg-slate-50 flex overflow-hidden font-sans border-t-[6px]" style="border-color: {{ $mainColor }}; --main-color: {{ $mainColor }};">
    <div class="w-[58%] h-full p-6 flex flex-col justify-between">
        <div class="flex items-center gap-2">
            @if($employee->company && $employee->company->logo)
                <div class="p-1.5 bg-white rounded-lg shadow-sm border border-slate-100">
                    <img src="{{ $getPath($employee->company->logo) }}" class="h-8 w-auto object-contain">
                </div>
            @endif
            <div class="flex flex-col">
                <span class="text-slate-900 font-bold text-[11px] leading-tight">{{ $employee->company->name ?? 'Corporate' }}</span>
                <span class="text-[8px] font-black uppercase tracking-widest text-slate-400">Badge Accès</span>
            </div>
        </div>
        <div class="mt-2">
            <h1 class="text-3xl font-extrabold text-slate-950 uppercase leading-none tracking-tighter">{{ $employee->first_name }}</h1>
            <h2 class="text-3xl font-light text-slate-700 uppercase leading-none tracking-tighter mb-2">{{ $employee->last_name }}</h2>
            <div class="h-1 w-12 mb-3 rounded-full" style="background-color: var(--main-color);"></div>
            <p class="text-lg font-bold uppercase tracking-tight text-slate-900 leading-tight">{{ $employee->function }}</p>
            <p class="text-[9px] font-bold uppercase text-slate-400 tracking-widest">{{ $employee->department ?? 'Général' }}</p>
        </div>
        <div class="w-full flex justify-between items-end border-t border-slate-200 pt-3">
            <div class="text-left">
                <span class="block text-[8px] font-bold text-slate-400 uppercase tracking-widest">Matricule</span>
                <span class="text-base font-mono font-bold text-slate-950">{{ $employee->badge_number }}</span>
            </div>
            <div class="flex items-center gap-1 bg-emerald-100 text-emerald-800 px-2 py-1 rounded-md">
                <div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div>
                <span class="text-[8px] font-black uppercase">Actif</span>
            </div>
        </div>
    </div>
    <div class="w-[42%] h-full relative z-10 flex flex-col items-center justify-center gap-4 p-4" style="background-color: var(--main-color);">
        <div class="w-36 h-40 rounded-2xl overflow-hidden shadow-xl border-[4px] border-white bg-white">
            <img src="{{ $getPath($employee->photo) }}" class="w-full h-full object-cover">
        </div>
        <div class="p-1.5 bg-white rounded-xl shadow-lg">
            <img src="{{ $getPath($employee->qr_code) }}" class="w-16 h-16">
        </div>
    </div>
</div>
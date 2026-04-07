@php 
    $mainColor = $employee->badge_color ?? '#1e293b'; 
    $is_export = isset($isPdf) && $isPdf;
    $getPath = function($path) use ($is_export) {
        if (empty($path)) return '';
        return $is_export ? public_path('storage/' . $path) : asset('storage/' . $path);
    };
@endphp

<div class="badge-fixed-container relative bg-white flex flex-col items-center overflow-hidden w-full h-full border">
    <div class="w-full pt-6 flex-none flex justify-center">
        <img src="{{ $getPath($employee->company->logo) }}" class="h-8 w-auto object-contain">
    </div>

    <div class="flex-grow flex flex-col items-center justify-center w-full px-4">
        <div class="w-32 h-36 rounded-xl overflow-hidden shadow-md border border-slate-100 mb-4 flex-none">
            <img src="{{ $getPath($employee->photo) }}" class="w-full h-full object-cover">
        </div>
        <h1 class="text-lg font-black uppercase text-slate-800 text-center break-words w-full leading-tight">
            {{ $employee->first_name }} {{ $employee->last_name }}
        </h1>
        <p class="text-xs font-medium text-slate-500 uppercase tracking-wide">{{ $employee->function }}</p>
    </div>

    <div class="w-full h-10 flex items-center justify-center flex-none" style="background-color: {{ $mainColor }};">
        <span class="text-[10px] font-bold text-white uppercase tracking-[0.2em]">MATRICULE : {{ $employee->badge_number }}</span>
    </div>
</div>
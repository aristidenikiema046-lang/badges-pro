@php 
    $mainColor = $employee->badge_color ?? '#64748b'; 
    $is_export = isset($isPdf) && $isPdf;
    $getPath = function($path) use ($is_export) {
        return $is_export ? public_path('storage/' . $path) : asset('storage/' . $path);
    };
@endphp
<div class="relative w-full h-full bg-[#fafaf9] flex flex-col p-8 font-serif border-4" style="border-color: var(--main-color); --main-color: {{ $mainColor }};">
    <div class="flex justify-between items-start">
        @if($employee->company && $employee->company->logo)
            <img src="{{ $getPath($employee->company->logo) }}" class="h-8 w-auto grayscale opacity-70">
        @endif
        <img src="{{ $getPath($employee->qr_code) }}" class="w-12 h-12 opacity-60 border p-1">
    </div>
    <div class="flex items-center h-full gap-10">
        <div class="w-40 h-40 rounded-full border-2 p-1" style="border-color: var(--main-color);">
            <img src="{{ $getPath($employee->photo) }}" class="w-full h-full rounded-full object-cover">
        </div>
        <div class="flex-1 text-right font-sans">
            <h1 class="text-3xl font-light text-slate-800 italic">{{ $employee->first_name }}</h1>
            <h2 class="text-4xl font-black uppercase text-slate-900" style="color: var(--main-color);">{{ $employee->last_name }}</h2>
            <p class="text-lg font-medium text-slate-500 uppercase tracking-widest mt-2">{{ $employee->function }}</p>
            <p class="text-xs font-bold text-gray-400 uppercase">{{ $employee->department ?? 'Direction' }}</p>
        </div>
    </div>
    <div class="mt-auto flex justify-between items-end border-t pt-2">
        <span class="text-xs font-mono text-gray-400 tracking-widest uppercase">Matricule : {{ $employee->badge_number }}</span>
    </div>
</div>
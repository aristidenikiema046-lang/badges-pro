@php 
    $mainColor = $employee->badge_color ?? '#f59e0b'; 
    $is_export = isset($isPdf) && $isPdf;
    $getPath = function($path) use ($is_export) {
        return $is_export ? public_path('storage/' . $path) : asset('storage/' . $path);
    };
@endphp
<div class="relative w-full h-full bg-white flex overflow-hidden font-sans" style="--main-color: {{ $mainColor }};">
    <div class="absolute top-0 left-0 w-full h-24 origin-top-left -rotate-6 z-0 opacity-20" style="background-color: var(--main-color);"></div>
    <div class="w-[45%] h-full relative z-10 flex items-center justify-center pl-6">
        <div class="w-48 h-56 rounded-2xl overflow-hidden shadow-2xl border-4 border-white">
            <img src="{{ $getPath($employee->photo) }}" class="w-full h-full object-cover">
        </div>
    </div>
    <div class="w-[55%] h-full flex flex-col justify-center items-start pl-12 pr-8 relative z-10">
        @if($employee->company && $employee->company->logo)
            <img src="{{ $getPath($employee->company->logo) }}" class="absolute top-6 right-6 h-10 opacity-30 grayscale">
        @endif
        <div class="mb-4">
            <span class="px-2 py-0.5 text-[10px] font-black text-white uppercase rounded-md" style="background-color: var(--main-color);">{{ $employee->department ?? 'Team' }}</span>
            <h1 class="text-4xl font-black text-slate-900 uppercase leading-none mt-2">{{ $employee->first_name }}</h1>
            <h2 class="text-4xl font-bold opacity-60 uppercase leading-none" style="color: var(--main-color);">{{ $employee->last_name }}</h2>
        </div>
        <p class="text-lg font-bold text-slate-700 italic border-l-4 pl-3" style="border-color: var(--main-color);">{{ $employee->function }}</p>
        <div class="mt-6 flex items-center gap-4">
            <img src="{{ $getPath($employee->qr_code) }}" class="w-12 h-12 border p-1 bg-white">
            <span class="text-[9px] font-mono text-slate-400 uppercase">Ref: {{ $employee->badge_number }}</span>
        </div>
    </div>
</div>
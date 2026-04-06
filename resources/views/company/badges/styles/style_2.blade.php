@php 
    $mainColor = $employee->badge_color ?? '#3b82f6'; 
    $is_export = isset($isPdf) && $isPdf;
    $getPath = function($path) use ($is_export) {
        return $is_export ? public_path('storage/' . $path) : asset('storage/' . $path);
    };
@endphp
<div class="relative w-full h-full bg-[#111827] flex overflow-hidden font-sans" style="--main-color: {{ $mainColor }};">
    <div class="absolute inset-0 opacity-10" style="background-image: linear-gradient(var(--main-color) 1px, transparent 1px), linear-gradient(90deg, var(--main-color) 1px, transparent 1px); background-size: 30px 30px;"></div>
    <div class="w-[40%] h-full flex items-center justify-center relative z-10">
        <div class="w-48 h-48 rounded-[2.5rem] overflow-hidden border-2 shadow-xl bg-gray-800" style="border-color: var(--main-color);">
            <img src="{{ $getPath($employee->photo) }}" class="w-full h-full object-cover">
        </div>
    </div>
    <div class="w-[60%] pr-12 py-10 flex flex-col justify-between items-end text-right relative z-10 text-white">
        <div class="flex items-center gap-3">
            <span class="text-xs font-bold" style="color: var(--main-color);">{{ $employee->company->name }}</span>
            @if($employee->company && $employee->company->logo)
                <img src="{{ $getPath($employee->company->logo) }}" class="h-10 w-auto object-contain">
            @endif
        </div>
        <div>
            <h1 class="text-4xl font-black uppercase tracking-tighter leading-none">{{ $employee->first_name }}</h1>
            <h2 class="text-5xl font-thin uppercase leading-none" style="color: var(--main-color);">{{ $employee->last_name }}</h2>
            <p class="text-sm font-mono tracking-widest text-gray-400 mt-2 uppercase">{{ $employee->function }} | {{ $employee->department ?? 'S/D' }}</p>
        </div>
        <div class="w-full flex justify-between items-end">
            <img src="{{ $getPath($employee->qr_code) }}" class="w-10 h-10 bg-white p-1 rounded">
            <p class="text-lg font-mono tracking-tighter">{{ $employee->badge_number }}</p>
        </div>
    </div>
</div>
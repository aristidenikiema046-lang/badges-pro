@php 
    $mainColor = $employee->badge_color ?? '#1e293b'; 
    $is_export = isset($isPdf) && $isPdf;
    $getPath = function($path) use ($is_export) {
        return $is_export ? public_path('storage/' . $path) : asset('storage/' . $path);
    };
@endphp

<div class="relative w-full h-full bg-white flex overflow-hidden font-sans" style="--main-color: {{ $mainColor }};">
    <div class="w-[35%] h-full relative z-10 flex items-center justify-center" style="background-color: var(--main-color);">
        <div class="w-44 h-52 rounded-2xl overflow-hidden border-4 border-white shadow-2xl transform -rotate-1 translate-x-8 bg-gray-100">
            <img src="{{ $getPath($employee->photo) }}" class="w-full h-full object-cover">
        </div>
        <div class="absolute right-[-20px] top-0 h-full w-10 z-[-1] transform skew-x-[-5deg]" style="background-color: var(--main-color);"></div>
    </div>

    <div class="w-[65%] pl-20 pr-10 py-8 flex flex-col justify-between items-end text-right">
        <div class="flex justify-between items-start w-full">
            <img src="{{ $getPath($employee->qr_code) }}" class="w-12 h-12 border p-1 bg-white">
            @if($employee->company && $employee->company->logo)
                <img src="{{ $getPath($employee->company->logo) }}" class="h-10 w-auto object-contain">
            @endif
        </div>
        <div>
            <h1 class="text-4xl font-black text-gray-900 uppercase leading-none">{{ $employee->first_name }}</h1>
            <h2 class="text-4xl font-light text-gray-700 uppercase leading-none mb-4">{{ $employee->last_name }}</h2>
            <p class="text-xl font-bold italic" style="color: var(--main-color);">{{ $employee->function }}</p>
            <p class="text-[10px] font-black uppercase text-gray-400 tracking-widest">{{ $employee->department ?? 'Général' }}</p>
        </div>
        <div class="text-right">
            <span class="block text-[8px] font-bold text-gray-400 uppercase">Matricule ID</span>
            <span class="text-lg font-mono font-black text-gray-800">{{ $employee->badge_number }}</span>
        </div>
    </div>
</div>
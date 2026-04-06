@php 
    $mainColor = $employee->badge_color ?? '#1e293b'; 
    $is_export = isset($isPdf) && $isPdf;
    $getPath = function($path) use ($is_export) {
        return $is_export ? public_path('storage/' . $path) : asset('storage/' . $path);
    };
@endphp
<div class="relative w-full h-full bg-white flex flex-col font-sans border-[10px]" style="border-color: {{ $mainColor }};">
    <div class="h-16 w-full flex items-center justify-between px-8 bg-gray-50 border-b">
        @if($employee->company && $employee->company->logo)
            <img src="{{ $getPath($employee->company->logo) }}" class="h-8 w-auto object-contain">
        @endif
        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Badge Professionnel</p>
    </div>
    <div class="flex-1 flex p-6 gap-8 items-center">
        <div class="w-36 h-44 bg-gray-100 border-2 rounded shadow-sm overflow-hidden">
            <img src="{{ $getPath($employee->photo) }}" class="w-full h-full object-cover">
        </div>
        <div class="flex-1">
            <h1 class="text-3xl font-black text-gray-900 uppercase">{{ $employee->last_name }}</h1>
            <h2 class="text-2xl font-medium text-gray-600 uppercase">{{ $employee->first_name }}</h2>
            <div class="mt-4">
                <p class="text-[9px] font-bold text-gray-400 uppercase">Fonction</p>
                <p class="text-lg font-bold uppercase" style="color: {{ $mainColor }};">{{ $employee->function }}</p>
                <p class="text-sm font-bold text-gray-500 uppercase">{{ $employee->department ?? 'Standard' }}</p>
            </div>
        </div>
        <div class="flex flex-col items-center">
            <img src="{{ $getPath($employee->qr_code) }}" class="w-16 h-16 border p-1 mb-2">
            <span class="text-[9px] font-mono font-bold">{{ $employee->badge_number }}</span>
        </div>
    </div>
</div>
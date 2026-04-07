@php 
    $mainColor = $employee->badge_color ?? '#2563eb'; 
    $is_export = isset($isPdf) && $isPdf;
    $getPath = function($path) use ($is_export) {
        if (empty($path)) return '';
        return $is_export ? public_path('storage/' . $path) : asset('storage/' . $path);
    };
@endphp

<div class="badge-fixed-container relative bg-[#f8fafc] flex flex-col items-center overflow-hidden w-full h-full">
    <div class="w-full pt-6 flex-none flex justify-center">
        <img src="{{ $getPath($employee->company->logo) }}" class="h-8 w-auto object-contain">
    </div>

    <div class="flex-grow flex flex-col items-center justify-center w-full px-4 text-center">
        <div class="w-32 h-40 rounded-xl overflow-hidden border-[3px] border-white shadow-2xl mb-4 flex-none">
            <img src="{{ $getPath($employee->photo) }}" class="w-full h-full object-cover">
        </div>
        <h1 class="text-xl font-black uppercase text-[#2563eb] break-words w-full leading-tight">
            {{ $employee->first_name }} <br> {{ $employee->last_name }}
        </h1>
        <p class="text-[10px] font-bold text-slate-500 uppercase mt-1 tracking-widest">{{ $employee->function }}</p>
    </div>

    <div class="mt-auto w-full p-4 flex justify-end flex-none">
        <div class="p-1 bg-white border rounded-lg shadow-sm">
            <img src="{{ $getPath($employee->qr_code) }}" class="w-10 h-10">
        </div>
    </div>
</div>
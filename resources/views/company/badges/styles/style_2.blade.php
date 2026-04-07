@php $mainColor = $employee->badge_color ?? '#0066ff'; $is_export = isset($isPdf) && $isPdf; $getPath = function($path) use ($is_export) { if (empty($path)) return ''; return $is_export ? public_path('storage/' . $path) : asset('storage/' . $path); }; @endphp

<div class="badge-fixed-container relative bg-[#f8fafc] flex flex-col items-center overflow-hidden font-sans" 
     style="width: 54mm; height: 85.6mm; min-width: 54mm; min-height: 85.6mm; box-sizing: border-box;">
    
    <div class="w-full pt-8 px-6 flex justify-center z-10">
        @if($employee->company && $employee->company->logo)
            <img src="{{ $getPath($employee->company->logo) }}" class="h-10 w-auto object-contain">
        @endif
    </div>

    <div class="mt-8 relative z-10">
        <div class="w-36 h-44 rounded-xl overflow-hidden border-[3px] border-white shadow-2xl bg-white">
            @if($employee->photo)
                <img src="{{ $getPath($employee->photo) }}" class="w-full h-full object-cover">
            @endif
        </div>
    </div>

    <div class="mt-6 px-4 text-center z-10">
        <h1 class="text-2xl font-black uppercase tracking-tight text-[#2563eb] leading-tight">
            {{ $employee->first_name }} {{ $employee->last_name }}
        </h1>
        <p class="mt-1 text-sm font-semibold text-slate-500 uppercase tracking-wide">
            {{ $employee->function }}
        </p>
    </div>

    <div class="mt-auto w-full px-6 pb-6 flex justify-end items-end z-10">
        <div class="p-1.5 bg-white border border-slate-100 rounded-xl shadow-sm">
            <img src="{{ $getPath($employee->qr_code) }}" class="w-12 h-12">
        </div>
    </div>
</div>
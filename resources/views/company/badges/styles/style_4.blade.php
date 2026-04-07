@php 
    $mainColor = $employee->badge_color ?? '#0066ff'; 
    $is_export = isset($isPdf) && $isPdf;
    $getPath = function($path) use ($is_export) {
        if (empty($path)) return '';
        return $is_export ? public_path('storage/' . $path) : asset('storage/' . $path);
    };
@endphp

<div class="badge-fixed-container relative bg-white flex overflow-hidden w-full h-full" style="border: 1px solid #eee;">
    <div class="w-1/3 flex items-center justify-center p-4 flex-none">
        <div class="w-full aspect-square rounded-2xl overflow-hidden shadow-xl border-2" style="border-color: {{ $mainColor }};">
            <img src="{{ $getPath($employee->photo) }}" class="w-full h-full object-cover">
        </div>
    </div>

    <div class="flex-1 flex flex-col justify-center p-6 text-right">
        <div class="mb-4 flex justify-end">
            <img src="{{ $getPath($employee->company->logo) }}" class="h-8 w-auto object-contain">
        </div>
        
        <h1 class="text-2xl font-black uppercase text-slate-900 leading-none break-words">
            {{ $employee->first_name }} <br> {{ $employee->last_name }}
        </h1>
        <p class="mt-2 text-sm font-bold uppercase tracking-wider" style="color: {{ $mainColor }}">{{ $employee->function }}</p>
        
        <div class="mt-6 pt-4 border-t border-slate-100 flex justify-between items-center">
             <div class="bg-white p-1 border rounded shadow-sm">
                <img src="{{ $getPath($employee->qr_code) }}" class="w-10 h-10">
             </div>
             <span class="text-[10px] font-mono text-slate-400 font-bold uppercase tracking-widest">#{{ $employee->badge_number }}</span>
        </div>
    </div>
</div>
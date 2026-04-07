@php $mainColor = $employee->badge_color ?? '#059669'; @endphp
<div class="badge-fixed-container relative bg-white flex overflow-hidden w-full h-full border">
    <div class="w-1/3 flex items-center justify-center p-3 flex-none bg-gray-50">
        <div class="w-full aspect-square rounded-xl overflow-hidden shadow-lg border-2" style="border-color: {{ $mainColor }}">
            <img src="{{ $getPath($employee->photo) }}" class="w-full h-full object-cover">
        </div>
    </div>
    <div class="flex-1 flex flex-col justify-center p-4 text-right">
        <img src="{{ $getPath($employee->company->logo) }}" class="h-6 w-auto object-contain self-end mb-3">
        <h1 class="text-xl font-black uppercase text-gray-900 leading-none break-words">
            {{ $employee->last_name }} <br> <span style="color: {{ $mainColor }}">{{ $employee->first_name }}</span>
        </h1>
        <p class="mt-1 text-[10px] font-bold text-gray-500 uppercase">{{ $employee->function }} @if($employee->department) | {{ $employee->department }} @endif</p>
        <div class="mt-4 pt-3 border-t flex justify-between items-center">
             <img src="{{ $getPath($employee->qr_code) }}" class="w-8 h-8 opacity-80">
             <span class="text-[9px] font-mono text-gray-400 font-bold uppercase tracking-tighter">ID: {{ $employee->badge_number }}</span>
        </div>
    </div>
</div>
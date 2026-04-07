@php $mainColor = $employee->badge_color ?? '#059669'; @endphp
<div class="badge-fixed-container relative bg-white flex flex-col items-center overflow-hidden w-full h-full border">
    <div class="w-full pt-4 flex-none flex justify-center px-4">
        <img src="{{ $getPath($employee->company->logo) }}" class="h-8 w-auto object-contain">
    </div>
    <div class="flex-grow flex flex-col items-center justify-center w-full px-4 text-center">
        <div class="w-32 h-32 rounded-full overflow-hidden shadow-md border-4 border-gray-50 mb-3 flex-none">
            <img src="{{ $getPath($employee->photo) }}" class="w-full h-full object-cover">
        </div>
        <h1 class="text-md font-black uppercase text-gray-800 break-words leading-tight">
            {{ $employee->first_name }} {{ $employee->last_name }}
        </h1>
        <p class="text-[10px] font-bold uppercase" style="color: {{ $mainColor }}">{{ $employee->function }}</p>
        <p class="text-[8px] text-gray-400 font-mono mt-1 uppercase">{{ $employee->department ?? '' }}</p>
    </div>
    <div class="w-full h-12 flex items-center justify-center flex-none mt-auto" style="background-color: {{ $mainColor }};">
        <span class="text-[10px] font-bold text-white uppercase tracking-widest">ID: {{ $employee->badge_number }}</span>
    </div>
</div>
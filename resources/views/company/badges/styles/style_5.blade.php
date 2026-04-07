@php $mainColor = $employee->badge_color ?? '#059669'; @endphp
<div class="badge-fixed-container relative bg-white flex flex-col items-center overflow-hidden w-full h-full border border-gray-200">
    <div class="absolute top-0 left-0 w-full h-16 opacity-10" style="background-color: {{ $mainColor }}"></div>
    <div class="w-full pt-6 flex-none flex justify-center z-10">
        <img src="{{ $getPath($employee->company->logo) }}" class="h-8 w-auto">
    </div>
    <div class="flex-grow flex flex-col items-center justify-center w-full px-6 text-center z-10">
        <div class="w-24 h-24 rounded-full border-4 border-white shadow-lg overflow-hidden mb-4 flex-none">
            <img src="{{ $getPath($employee->photo) }}" class="w-full h-full object-cover">
        </div>
        <h1 class="text-lg font-black uppercase text-gray-900 break-words">{{ $employee->first_name }} {{ $employee->last_name }}</h1>
        <div class="px-3 py-0.5 rounded text-[9px] font-bold text-white uppercase mt-1 inline-block" style="background-color: {{ $mainColor }}">
            {{ $employee->function }}
        </div>
        <p class="text-[8px] text-gray-400 mt-2 italic uppercase">{{ $employee->department }}</p>
    </div>
    <div class="p-4 flex-none">
        <img src="{{ $getPath($employee->qr_code) }}" class="w-12 h-12">
    </div>
</div>
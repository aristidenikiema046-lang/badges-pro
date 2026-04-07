@php $mainColor = $employee->badge_color ?? '#059669'; @endphp
<div class="badge-fixed-container relative bg-white flex flex-col items-center overflow-hidden w-full h-full border border-gray-100">
    <div class="w-full h-2 flex-none" style="background-color: {{ $mainColor }}"></div>
    <div class="w-full pt-4 flex justify-center flex-none px-4">
        @if($employee->company && $employee->company->logo)
            <img src="{{ $getPath($employee->company->logo) }}" class="h-10 w-auto object-contain">
        @endif
    </div>
    <div class="flex-grow flex flex-col items-center justify-center w-full px-4 text-center">
        <div class="w-28 h-28 rounded-2xl overflow-hidden border-2 bg-white shadow-md mb-3 flex-none" style="border-color: {{ $mainColor }}">
            <img src="{{ $getPath($employee->photo) }}" class="w-full h-full object-cover">
        </div>
        <h1 class="text-lg font-black uppercase leading-tight break-words w-full" style="color: {{ $mainColor }}">
            {{ $employee->first_name }} <br> {{ $employee->last_name }}
        </h1>
        <p class="text-[10px] font-bold text-gray-600 uppercase mt-1">{{ $employee->function }}</p>
        <p class="text-[8px] font-medium text-gray-400 uppercase italic">{{ $employee->department ?? '' }}</p>
    </div>
    <div class="w-full p-3 flex justify-between items-end flex-none border-t border-gray-50 bg-gray-50/50">
        <div class="text-[9px] font-bold text-gray-400 uppercase">ID: {{ $employee->badge_number }}</div>
        <div class="bg-white p-1 rounded border border-gray-200 shadow-sm">
            <img src="{{ $getPath($employee->qr_code) }}" class="w-8 h-8">
        </div>
    </div>
</div>
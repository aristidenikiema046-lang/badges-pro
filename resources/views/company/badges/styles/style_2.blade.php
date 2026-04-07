@php $mainColor = $employee->badge_color ?? '#059669'; @endphp
<div class="badge-fixed-container relative bg-[#f8fafc] flex flex-col items-center overflow-hidden w-full h-full border">
    <div class="w-full pt-6 flex-none flex justify-center">
        <img src="{{ $getPath($employee->company->logo) }}" class="h-8 w-auto object-contain">
    </div>
    <div class="flex-grow flex flex-col items-center justify-center w-full px-4 text-center">
        <div class="w-28 h-36 rounded-xl overflow-hidden border-[3px] border-white shadow-xl mb-3 flex-none">
            <img src="{{ $getPath($employee->photo) }}" class="w-full h-full object-cover">
        </div>
        <h1 class="text-lg font-black uppercase break-words w-full" style="color: {{ $mainColor }}">
            {{ $employee->first_name }} <br> {{ $employee->last_name }}
        </h1>
        <p class="text-[9px] font-bold text-gray-500 uppercase tracking-widest">{{ $employee->function }}</p>
        <span class="text-[8px] bg-gray-200 px-2 py-0.5 rounded-full mt-1 text-gray-600 uppercase">{{ $employee->department ?? '' }}</span>
    </div>
    <div class="w-full p-4 flex justify-end flex-none">
        <img src="{{ $getPath($employee->qr_code) }}" class="w-10 h-10 border p-1 bg-white rounded-lg">
    </div>
</div>
@php $mainColor = $employee->badge_color ?? '#059669'; @endphp
<div class="badge-fixed-container relative bg-white flex flex-col items-center overflow-hidden w-full h-full border">
    <div class="absolute -top-10 -right-10 w-32 h-32 rounded-full opacity-10" style="background-color: {{ $mainColor }}"></div>
    <div class="w-full pt-8 flex-none flex justify-center z-10">
        <img src="{{ $getPath($employee->company->logo) }}" class="h-8 w-auto">
    </div>
    <div class="flex-grow flex flex-col items-center justify-center z-10 px-6 text-center">
        <div class="w-28 h-28 rounded-3xl rotate-3 overflow-hidden border-2 bg-white shadow-xl mb-4 flex-none" style="border-color: {{ $mainColor }}">
            <img src="{{ $getPath($employee->photo) }}" class="w-full h-full object-cover -rotate-3">
        </div>
        <h1 class="text-lg font-black uppercase text-gray-900 break-words leading-tight">{{ $employee->last_name }} {{ $employee->first_name }}</h1>
        <p class="text-[9px] font-bold text-gray-500 uppercase mt-1 tracking-tighter">
            {{ $employee->function }} • {{ $employee->department ?? '' }}
        </p>
        <div class="h-1 w-10 my-3 rounded-full mx-auto" style="background-color: {{ $mainColor }}"></div>
    </div>
    <div class="w-full p-4 flex justify-between items-center px-6 flex-none bg-gray-50 border-t">
        <span class="text-[9px] font-black text-gray-300 tracking-widest uppercase">ID: {{ $employee->badge_number }}</span>
        <img src="{{ $getPath($employee->qr_code) }}" class="w-8 h-8 mix-blend-multiply opacity-70">
    </div>
</div>
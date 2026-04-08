@php $mainColor = $employee->company->badge_color ?? '#059669'; @endphp
<div class="badge-fixed-container relative bg-white flex flex-col items-center overflow-hidden w-full h-full border border-gray-200">
    <div class="absolute top-0 left-0 w-full h-64 flex-none" style="background-color: {{ $mainColor }}; clip-path: polygon(0 0, 100% 0, 100% 70%, 0% 100%);"></div>

    <div class="w-full pt-8 flex-none flex flex-col items-center px-4 z-10">
        @if($employee->company && $employee->company->logo)
            <div class="bg-white p-2 rounded-2xl shadow-xl mb-3">
                <img src="{{ $getPath($employee->company->logo) }}" class="h-10 w-auto object-contain">
            </div>
        @endif
        <p class="text-[10px] font-black uppercase tracking-[0.25em] text-white drop-shadow-sm">
            {{ $employee->company->name }}
        </p>
    </div>

    <div class="flex-grow flex flex-col items-center justify-center w-full px-6 text-center z-10 mt-4">
        <div class="bg-white p-5 rounded-[2.5rem] shadow-2xl mb-8 border-[8px] border-white">
            {!! QrCode::size(160)->margin(1)->generate($employee->matricule) !!}
        </div>

        <div class="space-y-1">
            <h1 class="text-2xl font-black uppercase tracking-tight text-gray-900 leading-none">
                {{ $employee->first_name }}
            </h1>
            <h1 class="text-3xl font-black uppercase tracking-tighter leading-tight" style="color: {{ $mainColor }}">
                {{ $employee->last_name }}
            </h1>
        </div>
        
        <div class="w-20 h-1.5 my-6 rounded-full mx-auto" style="background-color: {{ $mainColor }}; opacity: 0.3;"></div>
        
        <p class="text-[14px] font-black text-gray-800 uppercase tracking-widest">
            {{ $employee->function }}
        </p>
        <p class="text-[10px] font-bold uppercase italic mt-1" style="color: {{ $mainColor }}">
            {{ $employee->department ?? 'SANS DÉPARTEMENT' }}
        </p>
    </div>

    <div class="w-full p-5 flex justify-between items-center flex-none bg-gray-50 border-t border-gray-100">
        <div class="border-l-4 pl-4" style="border-color: {{ $mainColor }}">
            <span class="text-[8px] text-gray-400 font-bold uppercase tracking-widest block">ID Number</span>
            <span class="text-xs font-mono font-black text-gray-800 uppercase leading-none">{{ $employee->matricule }}</span>
        </div>
        <span class="text-[10px] font-bold text-gray-700">{{ $employee->email }}</span>
    </div>
</div>
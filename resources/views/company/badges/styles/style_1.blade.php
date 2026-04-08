@php $mainColor = $employee->company->badge_color ?? '#059669'; @endphp
<div class="badge-fixed-container relative bg-white flex flex-col items-center overflow-hidden w-full h-full border border-gray-100 shadow-lg">
    <div class="w-full h-4 flex-none" style="background-color: {{ $mainColor }}"></div>
    
    <div class="w-full pt-8 flex flex-col items-center flex-none px-4">
        @if($employee->company && $employee->company->logo)
            <img src="{{ $getPath($employee->company->logo) }}" class="h-12 w-auto object-contain mb-2">
        @endif
        <p class="text-[11px] font-black uppercase tracking-[0.3em] text-gray-400">
            {{ $employee->company->name }}
        </p>
    </div>

    <div class="flex-grow flex flex-col items-center justify-center w-full px-8 text-center">
        <div class="mb-8 p-4 border-4 rounded-[2rem]" style="border-color: {{ $mainColor }}22">
             {!! QrCode::size(140)->margin(1)->generate($employee->matricule) !!}
        </div>

        <div class="mb-6">
            <h1 class="text-3xl font-black uppercase leading-tight text-gray-900 tracking-tighter">
                {{ $employee->last_name }}
            </h1>
            <h1 class="text-2xl font-bold uppercase leading-none mt-1" style="color: {{ $mainColor }}">
                {{ $employee->first_name }}
            </h1>
        </div>

        <div class="space-y-2">
            <p class="text-[14px] font-extrabold text-gray-700 uppercase tracking-wide">
                {{ $employee->function }}
            </p>
            <div class="inline-block px-4 py-1.5 rounded-full text-[11px] font-bold text-white uppercase mt-2" style="background-color: {{ $mainColor }}">
                {{ $employee->department ?? 'GÉNÉRAL' }}
            </div>
        </div>
    </div>

    <div class="w-full p-6 flex justify-between items-center flex-none border-t border-gray-100 bg-gray-50/80">
        <div class="flex flex-col text-left">
            <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Matricule</span>
            <span class="text-sm font-black text-gray-800 font-mono">{{ $employee->matricule }}</span>
        </div>
        <div class="text-right">
            <span class="text-[9px] font-bold text-gray-400 uppercase tracking-widest block">Contact</span>
            <span class="text-[10px] font-semibold text-gray-600">{{ $employee->email }}</span>
        </div>
    </div>
</div>
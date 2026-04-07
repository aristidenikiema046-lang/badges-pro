@php $mainColor = $employee->badge_color ?? '#059669'; @endphp
<div class="badge-fixed-container relative bg-white flex flex-col items-center overflow-hidden w-full h-full border border-gray-100">
    <div class="w-full h-2 flex-none" style="background-color: {{ $mainColor }}"></div>
    
    {{-- Header compacté --}}
    <div class="w-full pt-2 flex justify-center flex-none px-4">
        @if($employee->company && $employee->company->logo)
            <img src="{{ $getPath($employee->company->logo) }}" class="h-9 w-auto object-contain">
        @endif
    </div>

    <div class="flex-grow flex flex-col items-center justify-center w-full px-4 text-center">
        {{-- Photo Ultra : w-52 h-52 --}}
        <div class="w-52 h-52 rounded-[2.5rem] overflow-hidden border-[4px] bg-white shadow-2xl mb-4 flex-none" style="border-color: {{ $mainColor }}">
            <img src="{{ $getPath($employee->photo) }}" class="w-full h-full object-cover scale-105">
        </div>

        {{-- Texte Identité --}}
        <div class="mb-2">
            <h1 class="text-xl font-black uppercase leading-tight break-words w-full text-gray-900">
                {{ $employee->last_name }}
            </h1>
            <h1 class="text-lg font-bold uppercase leading-none" style="color: {{ $mainColor }}">
                {{ $employee->first_name }}
            </h1>
        </div>
        
        {{-- Poste et Département regroupés pour gagner de la place --}}
        <div class="space-y-0.5">
            <p class="text-[11px] font-extrabold text-gray-700 uppercase tracking-tight">{{ $employee->function }}</p>
            <p class="text-[9px] font-bold text-gray-400 uppercase italic">
                {{ $employee->department ?? '' }}
            </p>
        </div>
    </div>

    {{-- Footer optimisé --}}
    <div class="w-full p-4 flex justify-between items-center flex-none border-t border-gray-100 bg-gray-50/50">
        <div class="flex flex-col text-left leading-none">
            <span class="text-[7px] font-bold text-gray-400 uppercase tracking-widest">Matricule</span>
            <span class="text-[11px] font-black text-gray-800 tracking-tighter">{{ $employee->badge_number }}</span>
        </div>
        <div class="bg-white p-1 rounded-xl border border-gray-100 shadow-sm">
            <img src="{{ $getPath($employee->qr_code) }}" class="w-10 h-10">
        </div>
    </div>
</div>
@php $mainColor = $employee->badge_color ?? '#059669'; @endphp
<div class="badge-fixed-container relative bg-white flex flex-col items-center overflow-hidden w-full h-full border border-gray-100">
    <div class="w-full h-2 flex-none" style="background-color: {{ $mainColor }}"></div>
    
    {{-- Logo un peu plus haut --}}
    <div class="w-full pt-3 flex justify-center flex-none px-4">
        @if($employee->company && $employee->company->logo)
            <img src="{{ $getPath($employee->company->logo) }}" class="h-10 w-auto object-contain">
        @endif
    </div>

    <div class="flex-grow flex flex-col items-center justify-center w-full px-4 text-center">
        {{-- Photo agrandie : w-40 h-40 (environ 160px au lieu de 112px) --}}
        <div class="w-40 h-40 rounded-3xl overflow-hidden border-[3px] bg-white shadow-xl mb-4 flex-none" style="border-color: {{ $mainColor }}">
            <img src="{{ $getPath($employee->photo) }}" class="w-full h-full object-cover">
        </div>

        {{-- Texte ajusté pour laisser la place à la photo --}}
        <h1 class="text-xl font-black uppercase leading-none break-words w-full" style="color: {{ $mainColor }}">
            {{ $employee->first_name }} <br> {{ $employee->last_name }}
        </h1>
        
        <p class="text-[11px] font-extrabold text-gray-700 uppercase mt-2 tracking-wide">{{ $employee->function }}</p>
        
        {{-- Badge de département plus discret pour gagner de l'espace --}}
        <p class="text-[9px] font-bold text-gray-400 uppercase italic mt-1 border-t border-gray-100 pt-1 w-2/3 mx-auto">
            {{ $employee->department ?? '' }}
        </p>
    </div>

    <div class="w-full p-4 flex justify-between items-center flex-none border-t border-gray-100 bg-gray-50/30">
        <div class="flex flex-col text-left leading-none">
            <span class="text-[7px] font-bold text-gray-400 uppercase tracking-widest">Matricule</span>
            <span class="text-[11px] font-black text-gray-800">{{ $employee->badge_number }}</span>
        </div>
        <div class="bg-white p-1 rounded-lg border border-gray-200 shadow-sm">
            <img src="{{ $getPath($employee->qr_code) }}" class="w-9 h-9">
        </div>
    </div>
</div>
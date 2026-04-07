@php $mainColor = $employee->badge_color ?? '#059669'; @endphp
<div class="badge-fixed-container relative bg-[#f8fafc] flex flex-col items-center overflow-hidden w-full h-full border border-gray-200">
    {{-- Header avec Logo --}}
    <div class="w-full pt-6 flex-none flex justify-center px-4">
        @if($employee->company && $employee->company->logo)
            <img src="{{ $getPath($employee->company->logo) }}" class="h-10 w-auto object-contain">
        @endif
    </div>

    {{-- Corps du badge --}}
    <div class="flex-grow flex flex-col items-center justify-center w-full px-4 text-center">
        {{-- Photo avec effet d'ombre porté --}}
        <div class="w-28 h-36 rounded-xl overflow-hidden border-[3px] border-white shadow-xl mb-3 flex-none">
            <img src="{{ $getPath($employee->photo) }}" class="w-full h-full object-cover">
        </div>

        {{-- Infos Employé --}}
        <h1 class="text-lg font-black uppercase break-words w-full leading-tight" style="color: {{ $mainColor }}">
            {{ $employee->first_name }} <br> {{ $employee->last_name }}
        </h1>
        
        <p class="text-[10px] font-bold text-gray-700 uppercase tracking-widest mt-1">{{ $employee->function }}</p>
        
        {{-- Ajout du Département (Élément manquant) --}}
        <div class="mt-2">
            <span class="text-[8px] bg-gray-200 px-3 py-1 rounded-full text-gray-600 font-bold uppercase tracking-tighter">
                {{ $employee->department ?? 'SANS DÉPARTEMENT' }}
            </span>
        </div>
    </div>

    {{-- Footer avec ID et QR Code --}}
    <div class="w-full p-4 flex justify-between items-center flex-none bg-white border-t border-gray-100">
        <div class="flex flex-col">
            <span class="text-[7px] text-gray-400 font-bold uppercase">Matricule</span>
            <span class="text-[10px] font-mono font-black text-gray-800 uppercase">{{ $employee->badge_number }}</span>
        </div>
        <div class="p-1 bg-white border border-gray-100 rounded-lg shadow-sm">
            <img src="{{ $getPath($employee->qr_code) }}" class="w-10 h-10">
        </div>
    </div>
</div>
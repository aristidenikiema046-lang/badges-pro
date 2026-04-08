@php 
    $mainColor = $employee->badge_color ?? '#059669'; 
@endphp

<div class="badge-fixed-container relative bg-white flex flex-col items-center overflow-hidden w-full h-full border border-gray-200">
    
    {{-- Background Design --}}
    <div class="absolute top-0 left-0 w-full h-40 flex-none" style="background-color: {{ $mainColor }}; clip-path: polygon(0 0, 100% 0, 100% 60%, 0% 100%);"></div>

    {{-- Header avec Logo et Nom de l'entreprise --}}
    <div class="w-full pt-4 flex-none flex flex-col items-center px-4 z-10">
        @if($employee->company && $employee->company->logo)
            <div class="bg-white/95 p-1.5 rounded-xl backdrop-blur-sm shadow-md mb-1">
                <img src="{{ asset('storage/' . $employee->company->logo) }}" class="h-8 w-auto object-contain">
            </div>
        @endif
        <p class="text-[9px] font-black uppercase tracking-[0.2em] text-white/90 drop-shadow-sm">
            {{ $employee->company->name }}
        </p>
    </div>

    {{-- Corps du badge --}}
    <div class="flex-grow flex flex-col items-center justify-center w-full px-4 text-center z-10 mt-1">
        
        {{-- QR CODE à la place de la photo --}}
        <div class="w-48 h-48 rounded-full bg-white shadow-2xl mb-4 flex items-center justify-center border-[6px] border-white relative overflow-hidden">
             <div class="p-3">
                {!! QrCode::size(120)->margin(1)->generate($employee->matricule) !!}
             </div>
        </div>

        {{-- Infos Employé --}}
        <div class="mt-2">
            <h1 class="text-xl font-black uppercase tracking-tight text-gray-900 leading-none">
                {{ $employee->first_name }}
            </h1>
            <h1 class="text-2xl font-black uppercase tracking-tighter leading-tight" style="color: {{ $mainColor }}">
                {{ $employee->last_name }}
            </h1>
        </div>
        
        {{-- Séparateur --}}
        <div class="w-16 h-1.5 my-3 rounded-full mx-auto" style="background-color: {{ $mainColor }}; opacity: 0.2;"></div>
        
        <div class="space-y-1">
            <p class="text-[12px] font-black text-gray-800 uppercase tracking-wide">
                {{ $employee->function }}
            </p>
            
            <p class="text-[9px] font-bold uppercase italic tracking-widest" style="color: {{ $mainColor }}">
                {{ $employee->department ?? 'SANS DÉPARTEMENT' }}
            </p>
        </div>
    </div>

    {{-- Footer avec Matricule et Email --}}
    <div class="w-full p-4 flex justify-between items-center flex-none bg-gray-50/90 border-t border-gray-100">
        <div class="flex flex-col border-l-4 pl-3" style="border-color: {{ $mainColor }}">
            <span class="text-[7px] text-gray-400 font-bold uppercase tracking-widest">Matricule</span>
            <span class="text-[11px] font-mono font-black text-gray-800 uppercase leading-none">{{ $employee->matricule }}</span>
        </div>
        <div class="text-right flex flex-col">
            <span class="text-[7px] text-gray-400 font-bold uppercase tracking-widest">Contact Pro</span>
            <span class="text-[9px] font-bold text-gray-700 truncate max-w-[130px]">{{ $employee->email }}</span>
        </div>
    </div>
</div>
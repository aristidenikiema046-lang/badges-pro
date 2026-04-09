@php 
    // Sécurité : récupération de la couleur principale
    $mainColor = $mainColor ?? ($employee->company->badge_color ?? '#000000'); 
@endphp

<div class="badge-card bg-white shadow-xl overflow-hidden flex relative border-2 mx-auto" 
     style="width: 600px; height: 350px; border-radius: 1.5rem; border-color: {{ $mainColor }}">
    
    <div class="w-2/5 relative flex items-center justify-center" style="background-color: {{ $mainColor }}">
        {{-- Motif décoratif discret --}}
        <div class="absolute inset-0 opacity-20" 
             style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');">
        </div>

        {{-- Photo de l'employé --}}
        <div class="z-10 relative">
            @if($employee->photo)
                <img src="{{ asset('storage/' . $employee->photo) }}" 
                     class="w-44 h-56 rounded-full object-cover shadow-2xl border-4 border-white">
            @else
                <div class="w-44 h-56 rounded-full bg-white flex items-center justify-center text-gray-400 font-bold border-2 border-dashed border-gray-200">
                    SANS PHOTO
                </div>
            @endif
        </div>
        
        {{-- Décoration géométrique (le cercle bleu de ta capture) --}}
        <div class="absolute -bottom-10 -left-10 w-32 h-32 rounded-full opacity-50 bg-white"></div>
    </div>

    <div class="w-3/5 flex flex-col p-6 justify-between bg-white">
        
        {{-- Header : Logo + Nom Entreprise --}}
        <div class="flex items-center gap-3 justify-end border-b pb-3">
            <div class="text-right">
                <p class="font-black text-2xl uppercase leading-none" style="color: {{ $mainColor }}">
                    {{ $employee->company->name ?? 'YA CONSULTING' }}
                </p>
                <p class="text-[10px] text-gray-400 font-bold tracking-[0.2em]">CARTE PROFESSIONNELLE</p>
            </div>
            @if($employee->company && $employee->company->logo)
                <img src="{{ asset('storage/' . $employee->company->logo) }}" class="h-12 w-12 object-contain">
            @endif
        </div>

        {{-- Corps : Identité --}}
        <div class="py-2">
            <div class="mb-3">
                <p class="text-gray-400 text-[10px] font-black uppercase tracking-widest">Nom & Prénoms</p>
                <p class="text-2xl font-extrabold text-slate-900">{{ $employee->first_name }} {{ $employee->last_name }}</p>
            </div>
            
            <div class="grid grid-cols-1 gap-2">
                <div>
                    <p class="text-gray-400 text-[9px] font-black uppercase">Fonction</p>
                    <p class="text-md font-bold uppercase" style="color: {{ $mainColor }}">
                        {{ $employee->function ?? 'Collaborateur' }}
                    </p>
                </div>
                <div>
                    <p class="text-gray-400 text-[9px] font-black uppercase">Matricule</p>
                    <p class="text-md font-mono font-bold text-slate-700">{{ $employee->matricule }}</p>
                </div>
            </div>
        </div>

        {{-- Footer : QR Code --}}
        <div class="flex justify-end items-end">
            <div class="p-1 border-2 rounded-lg" style="border-color: {{ $mainColor }}">
                {!! QrCode::size(65)->margin(0)->generate($employee->matricule ?? '0000') !!}
            </div>
        </div>
    </div>
</div>
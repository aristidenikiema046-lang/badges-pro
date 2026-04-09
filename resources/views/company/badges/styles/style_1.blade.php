{{-- On ne garde que la DIV principale du badge --}}
<div class="badge-card bg-white shadow-xl overflow-hidden flex relative border-2 mx-auto" 
     style="width: 600px; height: 350px; border-radius: 1.5rem; border-color: {{ $mainColor }}">
    
    <div class="w-2/5 relative flex items-center justify-center border-r border-gray-50">
        <div class="absolute inset-0 opacity-10" 
             style="background-image: url('https://www.transparenttextures.com/patterns/circuit-board.png'); background-color: #f8fafc;">
        </div>

        {{-- Photo de l'employé --}}
        @if($employee->photo)
            <img src="{{ asset('storage/' . $employee->photo) }}" 
                 class="z-10 w-40 h-52 rounded-2xl object-cover shadow-lg border-2 border-white">
        @else
            <div class="z-10 w-40 h-52 rounded-2xl bg-gray-200 flex items-center justify-center text-gray-400 font-bold border-2 border-dashed border-gray-300">
                SANS PHOTO
            </div>
        @endif
    </div>

    <div class="w-3/5 flex flex-col p-6 justify-between">
        
        <div class="flex items-center gap-3 justify-end border-b pb-3">
            <div class="text-right">
                {{-- NOM DE L'ENTREPRISE --}}
                <p class="font-black text-2xl uppercase leading-none" style="color: {{ $mainColor }}">
                    {{ $employee->company->name ?? 'ENTREPRISE DÉMO' }}
                </p>
                <p class="text-[10px] text-gray-400 font-bold tracking-[0.2em]">IDENTITÉ PROFESSIONNELLE</p>
            </div>
            @if($employee->company && $employee->company->logo)
                <img src="{{ asset('storage/' . $employee->company->logo) }}" class="h-12 w-12 object-contain">
            @endif
        </div>

        <div class="py-2">
            <div class="mb-3">
                <p class="text-gray-400 text-[10px] font-black uppercase tracking-widest">Collaborateur</p>
                <p class="text-xl font-bold text-slate-800">{{ $employee->first_name }} {{ $employee->last_name }}</p>
            </div>

            <div class="grid grid-cols-1 gap-2">
                <div>
                    <p class="text-gray-400 text-[9px] font-black uppercase">Poste occupé</p>
                    <p class="text-sm font-bold uppercase" style="color: {{ $mainColor }}">
                        {{ $employee->function ?? 'Poste non défini' }}
                    </p>
                </div>
                <div>
                    <p class="text-gray-400 text-[9px] font-black uppercase">Matricule</p>
                    <p class="text-sm font-mono font-bold text-slate-700">{{ $employee->matricule }}</p>
                </div>
            </div>
        </div>

        <div class="flex justify-end items-end">
            {{-- QR CODE DYNAMIQUE --}}
            <div class="p-1 border rounded-lg" style="border-color: {{ $mainColor }}33">
                {!! QrCode::size(70)->margin(0)->generate($employee->matricule ?? '0000') !!}
            </div>
        </div>
    </div>
</div>
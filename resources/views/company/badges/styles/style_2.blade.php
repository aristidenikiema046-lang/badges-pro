<div class="badge-container bg-white rounded-[2.5rem] shadow-2xl overflow-hidden border border-gray-100 relative mx-auto" style="width: 350px; height: 550px;">
    
    {{-- Fond coloré dynamique en haut --}}
    <div class="absolute top-0 left-0 w-full h-52 flex-none z-0" 
         style="background-color: {{ $mainColor }}; clip-path: polygon(0 0, 100% 0, 100% 85%, 0% 100%);">
    </div>

    <div class="relative w-full h-full flex flex-col items-center">
        
        {{-- Logo et Nom de l'entreprise --}}
        <div class="w-full pt-6 flex-none flex flex-col items-center px-4 z-10">
            @if($employee->company && $employee->company->logo)
                <div class="bg-white p-2 rounded-lg shadow-sm mb-2">
                    <img src="{{ asset('storage/' . $employee->company->logo) }}" class="h-8 w-auto object-contain">
                </div>
            @endif
            <p class="text-[10px] font-black uppercase tracking-[0.3em] text-white/90 text-center drop-shadow-sm">
                {{ $employee->company->name ?? 'ENTREPRISE' }}
            </p>
        </div>

        {{-- Photo de l'employé --}}
        <div class="relative mt-8 z-20 flex-none">
            <div class="w-32 h-32 rounded-full border-[6px] border-white shadow-xl overflow-hidden bg-gray-100 flex items-center justify-center">
                @if($employee->photo)
                    <img src="{{ asset('storage/' . $employee->photo) }}" class="w-full h-full object-cover">
                @else
                    <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                @endif
            </div>
        </div>

        {{-- Informations Collaborateur --}}
        <div class="flex-grow flex flex-col items-center justify-center w-full px-6 text-center mt-2 z-10">
            <div class="space-y-0 w-full mb-3">
                <h2 class="text-xl font-bold uppercase tracking-tight text-gray-700 leading-none">
                    {{ $employee->first_name }}
                </h2>
                <h1 class="text-3xl font-black uppercase tracking-tighter leading-none" style="color: {{ $mainColor }}">
                    {{ $employee->last_name }}
                </h1>
            </div>
            
            <div class="w-full bg-gray-50 py-2 px-3 rounded-xl border border-gray-100 mb-4">
                <p class="text-[12px] font-black text-gray-800 uppercase tracking-wider truncate">
                    {{ $employee->function ?? 'Poste non défini' }}
                </p>
                <p class="text-[10px] font-bold uppercase italic truncate" style="color: {{ $mainColor }}">
                    {{ $employee->department ?? 'SANS DÉPARTEMENT' }}
                </p>
            </div>

            {{-- QR Code dynamique --}}
            <div class="bg-white p-2 rounded-lg shadow-sm border border-gray-100">
                {!! QrCode::size(70)->margin(0)->generate($employee->matricule ?? '0000') !!}
            </div>
        </div>

        {{-- Bas du badge (Footer) --}}
        <div class="w-full p-4 flex justify-between items-center flex-none bg-white border-t border-dashed border-gray-200 z-10 mt-auto">
            <div class="flex flex-col text-left">
                <span class="text-[7px] text-gray-400 font-bold uppercase tracking-widest">Matricule</span>
                <span class="text-[11px] font-mono font-black text-gray-800 tracking-tighter">
                    {{ $employee->matricule }}
                </span>
            </div>
            <div class="h-8 w-[1px] bg-gray-200"></div>
            <div class="flex flex-col text-right">
                <span class="text-[7px] text-gray-400 font-bold uppercase tracking-widest">Contact</span>
                <span class="text-[9px] font-bold text-gray-700 truncate max-w-[120px]">
                    {{ $employee->email }}
                </span>
            </div>
        </div>
    </div>
</div>
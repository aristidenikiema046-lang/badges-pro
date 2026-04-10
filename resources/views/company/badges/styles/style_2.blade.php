@php 
    // Sécurité : si le formulaire n'envoie pas de couleur, on prend celle de l'entreprise ou du vert
    $mainColor = $mainColor ?? ($employee->company->badge_color ?? '#059669'); 
@endphp

{{-- Conteneur responsive : largeur max 350px, hauteur adaptative --}}
<div class="badge-container bg-white rounded-[2rem] shadow-2xl overflow-hidden border border-gray-100 relative mx-auto w-full max-w-[350px] aspect-[7/11]">
    
    {{-- Header background avec clip-path --}}
    <div class="absolute top-0 left-0 w-full h-[40%] flex-none z-0" 
         style="background-color: {{ $mainColor }}; clip-path: polygon(0 0, 100% 0, 100% 85%, 0% 100%);">
    </div>

    <div class="relative w-full h-full flex flex-col items-center">
        {{-- En-tête : Logo et Nom Entreprise --}}
        <div class="w-full pt-6 flex-none flex flex-col items-center px-4 z-10">
            @if($employee->company && $employee->company->logo)
                <div class="bg-white p-1.5 rounded-lg shadow-sm mb-2">
                    <img src="{{ asset('storage/' . $employee->company->logo) }}" class="h-6 w-auto object-contain">
                </div>
            @endif
            <p class="text-[9px] font-black uppercase tracking-[0.2em] text-white/90 text-center drop-shadow-sm px-2">
                {{ $employee->company->name ?? 'ENTREPRISE' }}
            </p>
        </div>

        {{-- Photo Profile --}}
        <div class="relative mt-6 z-20 flex-none">
            <div class="w-28 h-28 sm:w-32 sm:h-32 rounded-full border-[5px] border-white shadow-xl overflow-hidden bg-gray-100 flex items-center justify-center">
                @if($employee->photo)
                    <img src="{{ asset('storage/' . $employee->photo) }}" class="w-full h-full object-cover">
                @else
                    <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                @endif
            </div>
        </div>

        {{-- Infos Employé --}}
        <div class="flex-grow flex flex-col items-center justify-center w-full px-6 text-center mt-2 z-10">
            <div class="space-y-0 w-full mb-3">
                <h2 class="text-lg sm:text-xl font-bold uppercase tracking-tight text-gray-700 leading-none">{{ $employee->first_name }}</h2>
                <h1 class="text-2xl sm:text-3xl font-black uppercase tracking-tighter leading-none" style="color: {{ $mainColor }}">{{ $employee->last_name }}</h1>
            </div>
            
            <div class="w-full bg-gray-50 py-2 px-3 rounded-xl border border-gray-100 mb-4">
                <p class="text-[11px] sm:text-[12px] font-black text-gray-800 uppercase tracking-wider truncate">{{ $employee->function }}</p>
                <p class="text-[9px] sm:text-[10px] font-bold uppercase italic truncate" style="color: {{ $mainColor }}">{{ $employee->department ?? 'DÉPARTEMENT PRO' }}</p>
            </div>

            <div class="bg-white p-1.5 rounded-lg shadow-sm border border-gray-100">
                {!! QrCode::size(60)->margin(0)->generate($employee->matricule ?? '0000') !!}
            </div>
        </div>

        {{-- Footer --}}
        <div class="w-full p-3 sm:p-4 flex justify-between items-center flex-none bg-white border-t border-dashed border-gray-200 z-10 mt-auto">
            <div class="flex flex-col text-left">
                <span class="text-[7px] text-gray-400 font-bold uppercase tracking-widest">Matricule</span>
                <span class="text-[10px] font-mono font-black text-gray-800 tracking-tighter">{{ $employee->matricule }}</span>
            </div>
            <div class="h-6 w-[1px] bg-gray-200"></div>
            <div class="flex flex-col text-right">
                <span class="text-[7px] text-gray-400 font-bold uppercase tracking-widest">Contact</span>
                <span class="text-[8px] sm:text-[9px] font-bold text-gray-700 truncate max-w-[100px]">{{ $employee->email }}</span>
            </div>
        </div>
    </div>
</div>
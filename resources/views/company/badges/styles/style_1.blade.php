@php 
    $mainColor = $employee->company->badge_color ?? '#1e293b'; 
    $qrData = "NOM: {$employee->last_name}\n"
            . "PRENOM: {$employee->first_name}\n"
            . "POSTE: {$employee->function}\n"
            . "ID: {$employee->matricule}";
@endphp

<div class="flex justify-center items-center min-h-screen bg-gray-200 p-4">
    <div class="bg-white shadow-2xl overflow-hidden flex relative border border-gray-100" 
         style="width: 600px; height: 350px; border-radius: 1.5rem;">
        
        <div class="w-[40%] relative flex items-center justify-center bg-slate-50 border-r border-gray-100 overflow-hidden">
            <div class="absolute inset-0 opacity-10" 
                 style="background-image: url('https://www.transparenttextures.com/patterns/circuit-board.png');">
            </div>

            <div class="absolute inset-0 opacity-30 pointer-events-none">
                <svg width="100%" height="100%" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <path d="M0 20 L35 20 L55 45" stroke="{{ $mainColor }}" stroke-width="1.5" fill="none" />
                    <circle cx="35" cy="20" r="1.5" fill="{{ $mainColor }}" />
                    <path d="M0 80 L45 80 L65 100" stroke="{{ $mainColor }}" stroke-width="1.5" fill="none" />
                </svg>
            </div>

            <div class="z-10 w-44 h-56 rounded-[2rem] overflow-hidden shadow-xl border-4 border-white bg-white">
                @if($employee->photo)
                    <img src="{{ asset('storage/' . $employee->photo) }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-400">
                        <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path></svg>
                    </div>
                @endif
            </div>
        </div>

        <div class="w-[60%] flex flex-col p-8 justify-between bg-white">
            
            <div class="flex items-center justify-end gap-3">
                <div class="text-right">
                    <p class="font-black text-lg uppercase leading-none" style="color: {{ $mainColor }}">
                        {{ $employee->company->name ?? 'YA CONSULTING' }}
                    </p>
                    <p class="text-[8px] text-gray-400 font-bold tracking-[0.2em] mt-1">CARTE PROFESSIONNELLE</p>
                </div>
                @if($employee->company && $employee->company->logo)
                    <img src="{{ asset('storage/' . $employee->company->logo) }}" class="h-10 w-auto object-contain">
                @endif
            </div>

            <div class="mt-4">
                <h1 class="text-3xl font-black text-slate-900 uppercase tracking-tighter leading-none">
                    {{ $employee->last_name }}
                </h1>
                <h2 class="text-2xl font-bold uppercase mt-1" style="color: {{ $mainColor }}">
                    {{ $employee->first_name }}
                </h2>
                
                <div class="mt-4 flex flex-col gap-1">
                    <div class="flex items-center gap-2">
                        <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Poste:</span>
                        <span class="text-xs font-bold text-slate-700 uppercase">{{ $employee->function }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Matricule:</span>
                        <span class="text-xs font-mono font-black" style="color: {{ $mainColor }}">{{ $employee->matricule }}</span>
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-end">
                <div class="text-left">
                    <p class="text-[7px] font-black text-slate-300 uppercase tracking-[0.3em]">Digital Security ID</p>
                    <p class="text-[9px] font-bold text-slate-400 italic lowercase">{{ $employee->department ?? 'direction générale' }}</p>
                </div>
                
                <div class="p-1.5 bg-white border border-gray-100 rounded-xl shadow-sm">
                    {!! QrCode::size(70)->margin(0)->generate($qrData) !!}
                </div>
            </div>
        </div>
    </div>
</div>
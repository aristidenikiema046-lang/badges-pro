@php 
    $mainColor = $employee->company->badge_color ?? '#1e293b'; 
    
    $qrData = "NOM: {$employee->last_name}\n"
            . "PRENOM: {$employee->first_name}\n"
            . "POSTE: {$employee->function}\n"
            . "ID: {$employee->matricule}\n"
            . "ENTREPRISE: " . ($employee->company->name ?? 'YA CONSULTING');
@endphp

<div class="relative bg-white flex flex-row overflow-hidden w-full h-full font-sans shadow-lg rounded-xl border border-gray-100" style="min-width: 600px; min-height: 350px;">
    <div class="absolute left-0 top-0 bottom-0 w-3 z-20" style="background-color: {{ $mainColor }}"></div>

    <div class="w-[45%] flex flex-col items-center justify-center p-8 flex-none bg-slate-50 relative border-r-2 border-dashed border-gray-200">
        <div class="bg-white p-4 rounded-[1.5rem] shadow-xl z-10 border border-gray-100">
            {!! QrCode::size(150)->margin(1)->generate($qrData) !!}
        </div>
        
        <div class="mt-6 flex flex-col items-center">
            <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">Digital Security</span>
            <div class="h-1 w-12 rounded-full mt-1" style="background-color: {{ $mainColor }}44"></div>
        </div>
    </div>

    <div class="w-[55%] flex flex-col justify-between p-10 relative bg-white">
        
        <div class="flex items-center justify-end gap-3">
            <span class="font-black text-xs uppercase tracking-widest text-right leading-tight" style="color: {{ $mainColor }}">
                {{ $employee->company->name ?? 'YA CONSULTING' }}
            </h3>
            @if($employee->company && $employee->company->logo)
                <img src="{{ $getPath($employee->company->logo) }}" class="h-10 w-auto object-contain">
            @endif
        </div>

        <div class="text-right mt-4">
            <h1 class="text-3xl font-black uppercase text-slate-900 leading-none tracking-tighter truncate">
                {{ $employee->last_name }}
            </h1>
            <h2 class="text-2xl font-bold uppercase mt-2 truncate" style="color: {{ $mainColor }}">
                {{ $employee->first_name }}
            </h2>
            
            <div class="mt-4 flex justify-end">
                <div class="bg-slate-100 px-4 py-1.5 rounded-lg border-r-4" style="border-color: {{ $mainColor }}">
                    <p class="text-[11px] font-black text-slate-600 uppercase tracking-widest">
                        {{ $employee->function }}
                    </p>
                </div>
            </div>
        </div>

        <div class="flex items-end justify-between mt-auto">
            <div class="text-left">
                <p class="text-[9px] font-bold text-slate-300 uppercase tracking-widest mb-1">Département</p>
                <p class="text-xs font-bold text-slate-700 uppercase italic">
                    {{ $employee->department ?? 'DIRECTION GÉNÉRALE' }}
                </p>
            </div>

            <div class="flex flex-col items-end">
                <span class="text-[8px] font-bold text-slate-400 uppercase tracking-widest mb-1">Identifiant Unique</span>
                <div class="bg-slate-900 text-white px-6 py-2 rounded-xl text-lg font-mono font-black shadow-lg">
                    {{ $employee->matricule }}
                </div>
            </div>
        </div>
    </div>
</div>
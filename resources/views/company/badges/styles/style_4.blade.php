@php $mainColor = $employee->company->badge_color ?? '#059669'; @endphp
<div class="badge-fixed-container relative bg-white flex overflow-hidden w-full h-full border border-gray-200">
    <div class="absolute left-0 top-0 bottom-0 w-4 z-20" style="background-color: {{ $mainColor }}"></div>

    <div class="w-1/2 flex items-center justify-center p-10 flex-none bg-gray-50/50 relative border-r border-gray-100">
        <div class="bg-white p-6 rounded-[2rem] shadow-2xl z-10 border border-gray-100">
            {!! QrCode::size(180)->margin(1)->generate($employee->matricule) !!}
        </div>
    </div>

    <div class="flex-1 flex flex-col justify-center p-10 text-right relative">
        <div class="absolute top-8 right-10">
            @if($employee->company && $employee->company->logo)
                <img src="{{ $getPath($employee->company->logo) }}" class="h-10 w-auto object-contain">
            @endif
        </div>

        <div class="mt-4">
            <h1 class="text-4xl font-black uppercase text-gray-900 leading-none tracking-tighter">
                {{ $employee->last_name }}
            </h1>
            <h1 class="text-2xl font-bold uppercase leading-none mt-3" style="color: {{ $mainColor }}">
                {{ $employee->first_name }}
            </h1>
        </div>

        <div class="mt-8 pt-6 border-t-2 border-gray-100">
            <p class="text-lg font-black text-gray-800 uppercase leading-none">
                {{ $employee->function }}
            </p>
            <p class="text-xs font-bold uppercase italic mt-2" style="color: {{ $mainColor }}">
                {{ $employee->department ?? 'DIRECTION GÉNÉRALE' }}
            </p>
        </div>

        <div class="mt-auto flex justify-end gap-6 items-end">
            <div class="flex flex-col">
                <span class="text-[9px] font-bold text-gray-300 uppercase tracking-widest">Matricule</span>
                <span class="text-sm font-mono font-black text-gray-800">{{ $employee->matricule }}</span>
            </div>
        </div>
    </div>
</div>
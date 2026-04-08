@php $mainColor = $employee->company->badge_color ?? '#059669'; @endphp
<div class="badge-fixed-container relative bg-white overflow-hidden w-full h-full border border-gray-100 flex items-center">
    
    <div class="absolute top-0 right-0 w-32 h-32 opacity-10 rounded-bl-full" style="background-color: {{ $mainColor }}"></div>

    <div class="flex-1 pl-12 pr-6 z-10">
        @if($employee->company && $employee->company->logo)
            <img src="{{ $getPath($employee->company->logo) }}" class="h-10 w-auto object-contain mb-8">
        @endif

        <h1 class="text-5xl font-black uppercase text-gray-900 leading-[0.8] tracking-tighter mb-2">
            {{ $employee->last_name }}
        </h1>
        <h1 class="text-2xl font-bold uppercase mb-6" style="color: {{ $mainColor }}">
            {{ $employee->first_name }}
        </h1>
        
        <div class="flex items-center gap-4">
            <div class="px-4 py-2 rounded-xl bg-gray-900 text-white text-xs font-black uppercase tracking-widest">
                {{ $employee->function }}
            </div>
            <span class="text-xs font-mono text-gray-400 font-bold tracking-widest">{{ $employee->matricule }}</span>
        </div>
    </div>

    <div class="w-1/3 flex justify-center items-center pr-12 z-10">
        <div class="bg-white p-4 rounded-3xl shadow-2xl border-2" style="border-color: {{ $mainColor }}">
            {!! QrCode::size(140)->margin(1)->generate($employee->matricule) !!}
        </div>
    </div>

    <div class="absolute bottom-0 left-12 w-48 h-2 rounded-t-full" style="background-color: {{ $mainColor }}"></div>
</div>
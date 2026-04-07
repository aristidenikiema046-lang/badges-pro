@php $mainColor = $employee->badge_color ?? '#059669'; @endphp
<div class="badge-fixed-container relative bg-white overflow-hidden w-full h-full border border-gray-100">
    
    {{-- MOTIFS DE FOND (Cercles) --}}
    <div class="absolute -top-10 -right-10 w-32 h-32 rounded-full opacity-10" style="background-color: {{ $mainColor }}"></div>
    <div class="absolute -bottom-10 -left-10 w-24 h-24 rounded-full opacity-10" style="background-color: {{ $mainColor }}"></div>

    {{-- 1. LOGO (Positionné en haut à gauche) --}}
    <div class="absolute top-4 left-6 z-20">
        @if($employee->company && $employee->company->logo)
            <img src="{{ $getPath($employee->company->logo) }}" class="h-7 w-auto object-contain">
        @endif
    </div>

    {{-- 2. MATRICULE (Positionné en haut à droite) --}}
    <div class="absolute top-4 right-6 text-right z-20">
        <span class="block text-[6px] font-bold text-gray-400 uppercase tracking-widest">ID Number</span>
        <span class="text-[9px] font-mono font-black text-gray-700 uppercase">{{ $employee->badge_number }}</span>
    </div>

    {{-- 3. ZONE CENTRALE (Photo et Nom) --}}
    <div class="absolute inset-0 flex items-center justify-center px-6 mt-2">
        <div class="flex items-center gap-6">
            {{-- Photo inclinée --}}
            <div class="w-28 h-28 rounded-3xl rotate-3 overflow-hidden border-2 bg-white shadow-xl flex-none" style="border-color: {{ $mainColor }}">
                <img src="{{ $getPath($employee->photo) }}" class="w-full h-full object-cover -rotate-3 scale-110">
            </div>

            {{-- Texte d'identité --}}
            <div class="text-left">
                <h1 class="text-lg font-black uppercase text-gray-900 leading-none">
                    {{ $employee->last_name }}
                </h1>
                <h1 class="text-md font-bold uppercase leading-tight mb-2" style="color: {{ $mainColor }}">
                    {{ $employee->first_name }}
                </h1>
                <p class="text-[10px] font-black text-gray-600 uppercase tracking-tighter">
                    {{ $employee->function }}
                </p>
                <div class="inline-block mt-1 px-2 py-0.5 rounded bg-gray-100 border border-gray-200 text-[8px] font-bold text-gray-500 uppercase">
                    {{ $employee->department ?? 'General' }}
                </div>
            </div>
        </div>
    </div>

    {{-- 4. FOOTER / QR CODE (En bas à droite) --}}
    <div class="absolute bottom-4 right-6 z-20">
        <div class="bg-white p-1 rounded-lg shadow-sm border border-gray-100">
            <img src="{{ $getPath($employee->qr_code) }}" class="w-8 h-8">
        </div>
    </div>

    {{-- BARRE DÉCORATIVE BASSE --}}
    <div class="absolute bottom-0 left-0 w-1/2 h-1" style="background-color: {{ $mainColor }}"></div>
</div>
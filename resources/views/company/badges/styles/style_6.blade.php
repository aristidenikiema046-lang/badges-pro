@php $mainColor = $employee->badge_color ?? '#059669'; @endphp
<div class="badge-fixed-container relative bg-white overflow-hidden w-full h-full border border-gray-100">
    
    {{-- MOTIFS DE FOND (Cercles agrandis pour équilibrer) --}}
    <div class="absolute -top-12 -right-12 w-48 h-48 rounded-full opacity-10" style="background-color: {{ $mainColor }}"></div>
    <div class="absolute -bottom-10 -left-10 w-32 h-32 rounded-full opacity-10" style="background-color: {{ $mainColor }}"></div>

    {{-- 1. LOGO --}}
    <div class="absolute top-5 left-6 z-20">
        @if($employee->company && $employee->company->logo)
            <img src="{{ $getPath($employee->company->logo) }}" class="h-8 w-auto object-contain">
        @endif
    </div>

    {{-- 2. MATRICULE --}}
    <div class="absolute top-5 right-6 text-right z-20">
        <span class="block text-[7px] font-bold text-gray-400 uppercase tracking-widest">ID Number</span>
        <span class="text-[11px] font-mono font-black text-gray-800 uppercase tracking-tighter">{{ $employee->badge_number }}</span>
    </div>

    {{-- 3. ZONE CENTRALE --}}
    <div class="absolute inset-0 flex items-center justify-start px-8 mt-4">
        <div class="flex items-center gap-8">
            {{-- PHOTO ULTRA TAILLE : w-44 h-44 avec rotation stylisée --}}
            <div class="w-44 h-44 rounded-[2.5rem] rotate-3 overflow-hidden border-[4px] bg-white shadow-2xl flex-none relative" style="border-color: {{ $mainColor }}">
                <img src="{{ $getPath($employee->photo) }}" class="w-full h-full object-cover -rotate-3 scale-110">
            </div>

            {{-- Texte d'identité --}}
            <div class="text-left z-20">
                <h1 class="text-3xl font-black uppercase text-gray-900 leading-[0.8] tracking-tighter mb-1">
                    {{ $employee->last_name }}
                </h1>
                <h1 class="text-xl font-bold uppercase leading-none mb-4" style="color: {{ $mainColor }}">
                    {{ $employee->first_name }}
                </h1>
                
                <div class="space-y-1.5">
                    <p class="text-[13px] font-black text-gray-700 uppercase tracking-tight">
                        {{ $employee->function }}
                    </p>
                    <div class="inline-block px-3 py-1 rounded-lg bg-gray-50 border border-gray-100 text-[10px] font-extrabold text-gray-500 uppercase">
                        {{ $employee->department ?? 'General' }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 4. QR CODE --}}
    <div class="absolute bottom-5 right-6 z-20">
        <div class="bg-white p-1.5 rounded-xl shadow-lg border border-gray-100">
            <img src="{{ $getPath($employee->qr_code) }}" class="w-10 h-10">
        </div>
    </div>

    {{-- BARRE DÉCORATIVE BASSE --}}
    <div class="absolute bottom-0 left-0 w-1/3 h-1.5 rounded-r-full" style="background-color: {{ $mainColor }}"></div>
</div>
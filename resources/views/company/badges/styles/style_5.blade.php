@php $mainColor = $employee->badge_color ?? '#059669'; @endphp
<div class="badge-fixed-container relative bg-white flex flex-col items-center overflow-hidden w-full h-full border border-gray-100">
    
    {{-- Background Design SVG --}}
    <div class="absolute inset-0 opacity-30 pointer-events-none">
        <svg width="100%" height="100%" viewBox="0 0 100 120" preserveAspectRatio="none" fill="none" stroke="{{ $mainColor }}" stroke-width="0.3">
            <path d="M5 15 L5 5 L15 5 M5 10 L10 10" />
            <circle cx="15" cy="5" r="0.8" fill="{{ $mainColor }}" />
            <path d="M5 30 L5 80 M5 45 L8 45 L8 55 L5 55" />
            <path d="M95 15 L95 5 L85 5" />
            <rect x="94" y="10" width="2" height="2" fill="{{ $mainColor }}" />
            <path d="M95 30 L95 80 M95 60 L92 60 L92 70 L95 70" />
            <circle cx="92" cy="65" r="0.8" fill="{{ $mainColor }}" />
            <path d="M5 90 L5 95 L15 95 M95 90 L95 95 L85 95" />
        </svg>
    </div>

    {{-- 1. HEADER : Logo --}}
    <div class="w-full pt-6 flex-none flex justify-center z-10 px-6">
        @if($employee->company && $employee->company->logo)
            <img src="{{ $getPath($employee->company->logo) }}" class="h-8 w-auto object-contain">
        @endif
    </div>

    {{-- 2. CORPS CENTRAL : Toutes les informations remontées ici --}}
    <div class="flex-grow flex flex-col items-center justify-start w-full px-6 text-center z-10 mt-4 pb-4">
        {{-- PHOTO --}}
        <div class="w-52 h-56 rounded-3xl overflow-hidden border-[3px] border-white shadow-xl mb-4 bg-gray-50 flex-none relative">
            <img src="{{ $getPath($employee->photo) }}" class="w-full h-full object-cover scale-105">
        </div>

        {{-- Identité --}}
        <div class="mb-2">
            <h1 class="text-xl font-black uppercase tracking-tight text-gray-900 leading-none">
                {{ $employee->last_name }}
            </h1>
            <h1 class="text-lg font-bold uppercase leading-tight" style="color: {{ $mainColor }}">
                {{ $employee->first_name }}
            </h1>
        </div>
        
        <div class="h-[2.5px] w-10 my-2.5 rounded-full mx-auto" style="background-color: {{ $mainColor }}"></div>
        
        {{-- Zone compacte : Fonction, Département, QR et ID --}}
        <div class="flex flex-col items-center gap-3.5 w-full">
            {{-- Groupe Fonction / Département --}}
            <div class="leading-tight">
                <p class="text-[12px] font-black text-gray-700 uppercase tracking-widest leading-none">
                    {{ $employee->function }}
                </p>
                <p class="text-[9px] font-extrabold uppercase mt-1 leading-none" style="color: {{ $mainColor }}">
                    {{ $employee->department ?? 'DÉPARTEMENT' }}
                </p>
            </div>

            {{-- SÉPARATEUR SUBTIL --}}
            <div class="h-[1px] w-full bg-gray-100/50"></div>

            {{-- NOUVEAU BLOC : QR Code et Matricule Côte à côte --}}
            <div class="flex items-center justify-center gap-4 w-full pt-1">
                {{-- QR Code remonté --}}
                <div class="bg-white p-1 rounded-lg border border-gray-100/50 shadow-inner flex-none">
                    <img src="{{ $getPath($employee->qr_code) }}" class="w-9 h-9">
                </div>
                {{-- Matricule remonté --}}
                <div class="text-left flex flex-col leading-none">
                    <span class="text-[7px] font-bold text-gray-400 uppercase tracking-widest">Matricule Officiel</span>
                    <span class="text-[11px] font-mono font-black text-gray-800 uppercase tracking-tight">{{ $employee->badge_number }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- 3. FOOTER : Affiné pour ne pas couvrir le texte --}}
    <div class="w-full h-14 flex-none relative mt-auto">
        {{-- Fond coloré biseauté (pur décoratif) --}}
        <div class="absolute inset-0 z-0" style="background-color: {{ $mainColor }}; clip-path: polygon(0 40%, 100% 0, 100% 100%, 0% 100%);"></div>
    </div>
</div>
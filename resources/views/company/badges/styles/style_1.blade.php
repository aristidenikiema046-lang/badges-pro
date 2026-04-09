<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none; }
            body { background: white; padding: 0; margin: 0; }
        }
        .badge-card {
            width: 600px;
            height: 350px;
            border-radius: 1.5rem;
        }
        .circuit-bg {
            background-image: url('https://www.transparenttextures.com/patterns/circuit-board.png');
            background-color: #f8fafc;
            opacity: 0.1;
        }
    </style>
</head>
<body class="bg-slate-100 flex flex-col items-center py-10 font-sans">

    <div class="no-print mb-6">
        <button onclick="window.print()" class="bg-blue-600 text-white px-8 py-2 rounded font-bold hover:bg-blue-700 transition uppercase text-sm">
            🖨️ IMPRIMER LE BADGE
        </button>
    </div>

    {{-- Ajout d'une bordure de la couleur choisie --}}
    <div class="badge-card bg-white shadow-xl overflow-hidden flex relative border-2" style="border-color: {{ $employee->company->badge_color }}">
        
        <div class="w-2/5 relative flex items-center justify-center border-r border-gray-50">
            <div class="absolute inset-0 circuit-bg"></div>
            {{-- On vérifie si la photo existe pour éviter la 404 --}}
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
                    {{-- NOM DE L'ENTREPRISE EN COULEUR DYNAMIQUE --}}
                    <p class="font-black text-2xl uppercase leading-none" style="color: {{ $employee->company->badge_color }}">
                        {{ $employee->company->name }}
                    </p>
                    <p class="text-[10px] text-gray-400 font-bold tracking-[0.2em]">IDENTITÉ PROFESSIONNELLE</p>
                </div>
                @if($employee->company->logo)
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
                        {{-- POSTE EN COULEUR DYNAMIQUE --}}
                        <p class="text-sm font-bold uppercase" style="color: {{ $employee->company->badge_color }}">
                            {{ $employee->function }}
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-[9px] font-black uppercase">Matricule</p>
                        <p class="text-sm font-mono font-bold text-slate-700">{{ $employee->matricule }}</p>
                    </div>
                </div>
            </div>

            <div class="flex justify-end items-end">
                {{-- PETIT RAPPEL DE COULEUR SUR LE QR CODE --}}
                <div class="p-1 border rounded-lg" style="border-color: {{ $employee->company->badge_color }}33"> {{-- 33 ajoute de la transparence --}}
                    {!! QrCode::size(70)->generate($employee->matricule) !!}
                </div>
            </div>
        </div>
    </div>

</body>
</html>
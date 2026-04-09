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

    <div class="badge-card bg-white shadow-xl overflow-hidden flex relative border border-gray-200">
        
        <div class="w-2/5 relative flex items-center justify-center border-r border-gray-50">
            <div class="absolute inset-0 circuit-bg"></div>
            <img src="{{ asset('storage/' . $employee->photo) }}" 
                 class="z-10 w-40 h-52 rounded-2xl object-cover shadow-lg border-2 border-white">
        </div>

        <div class="w-3/5 flex flex-col p-6 justify-between">
            
            <div class="flex items-center gap-3 justify-end border-b pb-3">
                <div class="text-right">
                    <p class="text-blue-800 font-black text-2xl uppercase leading-none">{{ $employee->company->name }}</p>
                    <p class="text-[10px] text-gray-400 font-bold tracking-[0.2em]">IDENTITÉ PROFESSIONNELLE</p>
                </div>
                <img src="{{ asset('storage/' . $employee->company->logo) }}" class="h-12 w-12 object-contain">
            </div>

            <div class="py-2">
                <div class="mb-3">
                    <p class="text-gray-400 text-[10px] font-black uppercase tracking-widest">Collaborateur</p>
                    <p class="text-xl font-bold text-slate-800">{{ $employee->first_name }} {{ $employee->last_name }}</p>
                </div>

                <div class="grid grid-cols-1 gap-2">
                    <div>
                        <p class="text-gray-400 text-[9px] font-black uppercase">Poste occupé</p>
                        <p class="text-sm font-bold text-blue-600 uppercase">{{ $employee->function }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 text-[9px] font-black uppercase">Matricule</p>
                        <p class="text-sm font-mono font-bold text-slate-700">{{ $employee->matricule }}</p>
                    </div>
                </div>
            </div>

            <div class="flex justify-end items-end">
                <div class="p-1 border border-gray-100 rounded-lg">
                    {!! QrCode::size(70)->generate($employee->matricule) !!}
                </div>
            </div>
        </div>
    </div>

</body>
</html>
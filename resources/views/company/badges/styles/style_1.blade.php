<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none; }
            body { background: white; padding: 0; }
        }
        /* Format Horizontal Type Carte de Crédit */
        .badge-card {
            width: 600px;
            height: 380px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        /* Motif circuit sur la gauche (comme entouré sur ton image) */
        .circuit-bg {
            background-image: url('https://www.transparenttextures.com/patterns/circuit-board.png');
            background-color: #f8fafc;
            opacity: 0.1;
        }
    </style>
</head>
<body class="bg-slate-100 flex flex-col items-center py-10">

    <div class="no-print mb-6">
        <button onclick="window.print()" class="bg-blue-600 text-white px-8 py-3 rounded-lg font-bold shadow-lg hover:bg-blue-700 transition uppercase tracking-widest">
            🖨️ IMPRIMER LE BADGE
        </button>
    </div>

    <div class="badge-card bg-white rounded-[2.5rem] shadow-2xl overflow-hidden flex relative border border-gray-200">
        
        <div class="w-2/5 relative flex items-center justify-end pr-4">
            <div class="absolute inset-0 w-3/4 circuit-bg border-r border-blue-100"></div>
            
            <img src="{{ asset('storage/' . $employee->photo) }}" 
                 class="z-10 w-48 h-60 rounded-[2rem] object-cover shadow-xl border-4 border-white">
        </div>

        <div class="w-3/5 flex flex-col p-8 justify-between">
            
            <div class="flex justify-end items-center gap-3">
                <span class="text-blue-600 font-black text-2xl tracking-tighter">{{ $employee->company->name }}</span>
                <img src="{{ asset('storage/' . $employee->company->logo) }}" class="h-10 w-10 object-contain">
            </div>

            <div class="mt-4">
                <h1 class="text-4xl font-black text-slate-800 uppercase leading-none">
                    {{ $employee->first_name }} {{ $employee->last_name }}
                </h1>
                <p class="text-xl font-bold text-blue-500 mt-1">
                    {{ $employee->function ?? 'Analyste Financier' }}
                </p>
                <p class="text-lg font-medium text-slate-500 mt-1">
                    Matricule : <span class="font-bold">{{ $employee->matricule }}</span>
                </p>
                <p class="text-sm text-slate-400">
                    Département : {{ $employee->department ?? 'Général' }}
                </p>
            </div>

            <div class="flex justify-end items-end">
                <div class="p-2 border-2 border-slate-100 rounded-2xl">
                     {!! QrCode::size(100)->generate($employee->matricule) !!}
                </div>
            </div>
        </div>

    </div>

</body>
</html>
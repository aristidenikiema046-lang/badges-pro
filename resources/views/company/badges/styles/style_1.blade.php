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
            .badge-card { shadow: none; border: 1px solid #eee; }
        }
        .badge-card {
            width: 650px;
            height: 380px;
        }
        /* Motif circuit discret sur la gauche */
        .circuit-bg {
            background-image: url('https://www.transparenttextures.com/patterns/circuit-board.png');
            background-color: #f8fafc;
            opacity: 0.15;
        }
    </style>
</head>
<body class="bg-slate-100 flex flex-col items-center py-10">

    <div class="no-print mb-8">
        <button onclick="window.print()" class="bg-blue-600 text-white px-10 py-3 rounded-full font-black shadow-xl hover:bg-blue-700 transition uppercase tracking-widest">
            🖨️ IMPRIMER LE BADGE
        </button>
    </div>

    <div class="badge-card bg-white rounded-[3rem] shadow-2xl overflow-hidden flex relative border border-gray-100">
        
        <div class="w-[40%] relative flex items-center justify-center">
            <div class="absolute inset-0 w-full circuit-bg border-r border-slate-50"></div>
            
            <img src="{{ asset('storage/' . $employee->photo) }}" 
                 class="z-10 w-44 h-56 rounded-[2.5rem] object-cover shadow-2xl border-4 border-white">
        </div>

        <div class="w-[60%] flex flex-col p-10 justify-between">
            
            <div class="flex justify-end items-center gap-3">
                <span class="text-blue-700 font-black text-2xl tracking-tighter">{{ $employee->company->name }}</span>
                <img src="{{ asset('storage/' . $employee->company->logo) }}" class="h-10 w-10 object-contain">
            </div>

            <div class="mt-2">
                <h1 class="text-4xl font-black text-slate-900 uppercase leading-none">
                    {{ $employee->last_name }}
                </h1>
                <h2 class="text-3xl font-bold text-slate-700 uppercase mb-2">
                    {{ $employee->first_name }}
                </h2>
                
                <p class="text-xl font-bold text-blue-600 italic">
                    {{ $employee->function ?? 'Collaborateur' }}
                </p>
                
                <div class="mt-4 space-y-1">
                    <p class="text-lg font-semibold text-slate-600">
                        Matricule : <span class="text-slate-900">{{ $employee->matricule }}</span>
                    </p>
                    <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">
                        Département : {{ $employee->department ?? 'Général' }}
                    </p>
                </div>
            </div>

            <div class="flex justify-end items-end mt-4">
                <div class="p-2 bg-slate-50 border border-slate-100 rounded-2xl shadow-inner">
                    {!! QrCode::size(90)->generate($employee->matricule) !!}
                </div>
            </div>
        </div>

    </div>

</body>
</html>
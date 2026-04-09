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
            .badge-container { shadow: none; border: 1px solid #ccc; }
        }
        .badge-container {
            width: 380px;
            height: 550px;
        }
    </style>
</head>
<body class="bg-slate-200 flex flex-col items-center py-10">

    <div class="no-print mb-6">
        <button onclick="window.print()" class="bg-orange-600 text-white px-8 py-3 rounded-xl font-black shadow-lg hover:bg-orange-700 transition uppercase tracking-widest">
            🖨️ Imprimer mon Badge
        </button>
    </div>

    <div class="badge-container bg-white rounded-[2rem] shadow-2xl overflow-hidden flex flex-col items-center relative border border-gray-100">
        
        <div class="w-full bg-green-700 h-28 flex items-center justify-center p-4 relative">
            <div class="bg-white p-2 rounded-full shadow-md">
                 <img src="{{ asset('storage/' . $employee->company->logo) }}" class="h-16 w-16 object-contain">
            </div>
        </div>

        <div class="flex-grow flex flex-col items-center w-full px-6 pt-4 text-center">
            <h2 class="text-green-800 font-black text-xl uppercase tracking-tighter mb-4">
                {{ $employee->company->name }}
            </h2>
            
            <div class="mb-4">
                <img src="{{ asset('storage/' . $employee->photo) }}" class="w-32 h-32 rounded-2xl border-4 border-orange-500 object-cover shadow-lg">
            </div>

            <div class="mb-2">
                <p class="text-3xl font-black text-slate-900 uppercase leading-none">{{ $employee->last_name }}</p>
                <p class="text-xl font-bold text-orange-600 uppercase">{{ $employee->first_name }}</p>
            </div>

            <div class="flex flex-col gap-1 mb-4">
                <span class="bg-slate-900 text-white text-[11px] px-4 py-1 rounded-full font-black uppercase tracking-widest">
                    {{ $employee->function ?? 'Poste non défini' }}
                </span>
                <span class="text-slate-500 text-[10px] font-bold uppercase italic">
                    Département : {{ $employee->department ?? 'N/A' }}
                </span>
            </div>

            <div class="mt-auto mb-6">
                {{-- Remplace par ta logique QR Code si différente --}}
                <div class="p-2 bg-white border-2 border-slate-100 rounded-xl shadow-inner">
                    {!! QrCode::size(90)->generate($employee->matricule) !!}
                </div>
                <p class="text-[10px] font-mono font-bold text-slate-400 mt-1">ID: {{ $employee->matricule }}</p>
            </div>
        </div>

        <div class="w-full bg-orange-500 h-3"></div>
    </div>

</body>
</html>
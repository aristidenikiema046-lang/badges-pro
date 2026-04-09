<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none; }
            body { background: white; }
        }
        .badge-container {
            width: 350px;
            height: 500px;
            border: 2px solid #e2e8f0;
        }
    </style>
</head>
<body class="bg-gray-100 flex flex-col items-center py-10">

    <div class="no-print mb-6">
        <button onclick="window.print()" class="bg-orange-600 text-white px-6 py-2 rounded-full font-bold shadow-lg hover:bg-orange-700 transition">
            🖨️ IMPRIMER MON BADGE
        </button>
    </div>

    <div class="badge-container bg-white rounded-2xl shadow-2xl overflow-hidden flex flex-col items-center relative">
        
        <div class="w-full bg-green-700 h-24 flex items-center justify-center p-4">
            <img src="{{ $getPath($employee->company->logo) }}" class="h-16 w-16 object-contain bg-white rounded-full p-1 border-2 border-white shadow-sm">
        </div>

        <div class="flex-grow flex flex-col items-center w-full px-6 pt-6">
            <h2 class="text-green-800 font-black text-xl uppercase text-center leading-tight">
                {{ $employee->company->name }}
            </h2>
            
            <div class="mt-4 mb-4">
                <img src="{{ $getPath($employee->photo) }}" class="w-32 h-32 rounded-xl border-4 border-orange-500 object-cover shadow-md">
            </div>

            <div class="text-center">
                <p class="text-2xl font-black text-slate-800 uppercase leading-none">{{ $employee->last_name }}</p>
                <p class="text-xl font-bold text-orange-600 leading-none mb-2">{{ $employee->first_name }}</p>
                
                <span class="inline-block bg-slate-900 text-white text-[10px] px-3 py-1 rounded font-black uppercase tracking-widest mb-4">
                    {{ $employee->function ?? 'COLLABORATEUR' }}
                </span>
            </div>

            <div class="mt-auto mb-4 bg-gray-50 p-2 border rounded-lg">
                {{-- Si vous utilisez une lib QR code comme SimpleQRCode --}}
                {!! QrCode::size(80)->generate($employee->matricule) !!}
                {{-- Sinon, remettez votre balise QR Code actuelle ici --}}
            </div>
        </div>

        <div class="w-full bg-orange-500 py-2 px-4 text-center">
            <p class="text-white text-[10px] font-bold uppercase tracking-tighter">
                Matricule: {{ $employee->matricule }} | Service: {{ $employee->department ?? 'Général' }}
            </p>
        </div>
    </div>

</body>
</html>
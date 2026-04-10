@php 
    $mainColor = $employee->company->badge_color ?? '#1e3a8a'; 
    $qrData = "NOM: {$employee->last_name}\n"
            . "PRENOM: {$employee->first_name}\n"
            . "POSTE: {$employee->function}\n"
            . "ID: {$employee->matricule}";
@endphp

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .badge-card {
            width: 100%;
            max-width: 650px;
            aspect-ratio: 1.6 / 1;
            background: white;
            border-radius: 1rem;
            display: flex;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            margin: 20px auto;
            overflow: hidden;
            border: 1px solid #e0e0e0;
            position: relative;
        }

        .circuit-pattern {
            position: absolute;
            left: 0;
            top: 0;
            width: 15%;
            height: 100%;
            background-color: #f8fbff;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 100 600' xmlns='http://www.w3.org/2000/svg'%3E%3Cdefs%3E%3ClinearGradient id='circuitGradient' x1='0%25' y1='0%25' x2='0%25' y2='100%25'%3E%3Cstop offset='0%25' style='stop-color:%234a90e2'/%3E%3Cstop offset='100%25' style='stop-color:%23{{ str_replace('#', '', $mainColor) }}'/%3E%3C/linearGradient%3E%3C/defs%3E%3Cg stroke='url(%23circuitGradient)' fill='none' stroke-width='1.8'%3E%3Cpath d='M10 0 L10 50 L40 80 L40 150 L10 180 L10 250 L50 280 L50 300'/%3E%3C/g%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-size: 100% 100%;
            z-index: 1;
        }

        @media print {
            .no-print { display: none; }
            body { background: white; }
            .badge-card { box-shadow: none; border: 1px solid #ddd; }
        }
    </style>
</head>
<body class="bg-slate-100 flex flex-col items-center min-h-screen p-4 sm:p-8">

    <button onclick="window.print()" class="no-print mb-8 bg-blue-600 text-white px-8 py-3 rounded-xl font-bold shadow-lg hover:bg-blue-700 transition">
        IMPRIMER LE BADGE
    </button>

    <div class="badge-card">
        <div class="circuit-pattern"></div>
        
        {{-- Photo --}}
        <div class="w-[30%] flex items-center justify-center z-10 pl-2">
            @if($employee->photo)
                <img src="{{ asset('storage/' . $employee->photo) }}" class="w-[85%] aspect-[4/5] rounded-lg object-cover shadow-md">
            @else
                <div class="w-[85%] aspect-[4/5] bg-gray-200 flex items-center justify-center text-[8px] sm:text-xs text-gray-400 rounded-lg">Photo</div>
            @endif
        </div>

        {{-- Infos --}}
        <div class="w-[70%] p-4 sm:p-8 flex flex-col justify-between z-10">
            <div class="flex items-center justify-end gap-2">
                <span class="text-xs sm:text-lg font-bold truncate" style="color: {{ $mainColor }}">
                    {{ $employee->company->name ?? 'PAYMETRUST' }}
                </span>
                @if($employee->company && $employee->company->logo)
                    <img src="{{ asset('storage/' . $employee->company->logo) }}" class="h-6 sm:h-8 w-auto">
                @endif
            </div>

            <div class="flex flex-col justify-center">
                <h1 class="text-sm sm:text-3xl font-bold text-slate-900 uppercase leading-tight">
                    {{ strtoupper($employee->last_name) }}<br>{{ strtoupper($employee->first_name) }}
                </h1>
                <p class="text-[10px] sm:text-lg font-medium mt-1" style="color: {{ $mainColor }}">
                    {{ $employee->function ?? 'Analyste Financier' }}
                </p>
                <p class="text-[9px] sm:text-base text-slate-600 mt-1">
                    Matricule : {{ $employee->matricule }}
                </p>
            </div>

            <div class="flex justify-end">
                <div class="p-1 border border-slate-200 rounded-lg scale-75 sm:scale-100 origin-bottom-right">
                    {!! QrCode::size(60)->margin(0)->generate($qrData) !!}
                </div>
            </div>
        </div>
    </div>

</body>
</html>
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
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .badge-card {
            width: 700px;
            height: 450px;
            background: white;
            border-radius: 20px;
            display: flex;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            margin: 50px auto;
            overflow: hidden;
            border: 1px solid #e0e0e0;
            position: relative;
        }

        .circuit-pattern {
            position: absolute;
            left: 0;
            top: 0;
            width: 100px;
            height: 100%;
            background-color: #f8fbff;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 100 600' xmlns='http://www.w3.org/2000/svg'%3E%3Cdefs%3E%3ClinearGradient id='circuitGradient' x1='0%25' y1='0%25' x2='0%25' y2='100%25'%3E%3Cstop offset='0%25' style='stop-color:%234a90e2'/%3E%3Cstop offset='100%25' style='stop-color:%23{{ str_replace('#', '', $mainColor) }}'/%3E%3C/linearGradient%3E%3C/defs%3E%3Cg stroke='url(%23circuitGradient)' fill='none' stroke-width='1.8'%3E%3Cpath d='M10 0 L10 50 L40 80 L40 150 L10 180 L10 250 L50 280 L50 300'/%3E%3Cpath d='M30 0 L30 40 L60 70 L60 130 L30 160 L30 220 L60 250 L60 300' stroke-width='1.5'/%3E%3Cpath d='M50 0 L50 60 L80 90 L80 140 L50 170 L50 210 L80 240 L80 300' stroke-width='1.2'/%3E%3Cpath d='M20 0 L20 30 L50 30 L50 120 L20 120 L20 300' stroke-width='1.3' opacity='0.7'/%3E%3Cpath d='M70 0 L70 50 L95 50 L95 300' stroke-width='1' opacity='0.5'/%3E%3Cpath d='M10 50 L30 50' stroke-width='1.2'/%3E%3Cpath d='M40 100 L60 100' stroke-width='1.2'/%3E%3Cpath d='M30 200 L50 200' stroke-width='1.2'/%3E%3Cpath d='M20 70 L50 70' stroke-width='1'/%3E%3Cpath d='M70 250 L90 250' stroke-width='1'/%3E%3Cg transform='translate(0, 300)' stroke='url(%23circuitGradient)'%3E%3Cpath d='M10 0 L10 50 L40 80 L40 150 L10 180 L10 250 L50 280 L50 300'/%3E%3Cpath d='M30 0 L30 40 L60 70 L60 130 L30 160 L30 220 L60 250 L60 300' stroke-width='1.5'/%3E%3Cpath d='M50 0 L50 60 L80 90 L80 140 L50 170 L50 210 L80 240 L80 300' stroke-width='1.2'/%3E%3Cpath d='M20 0 L20 30 L50 30 L50 120 L20 120 L20 300' stroke-width='1.3' opacity='0.7'/%3E%3Cpath d='M70 0 L70 50 L95 50 L95 300' stroke-width='1' opacity='0.5'/%3E%3Cpath d='M10 50 L30 50' stroke-width='1.2'/%3E%3Cpath d='M40 100 L60 100' stroke-width='1.2'/%3E%3Cpath d='M30 200 L50 200' stroke-width='1.2'/%3E%3Cpath d='M20 70 L50 70' stroke-width='1'/%3E%3Cpath d='M70 250 L90 250' stroke-width='1'/%3E%3C/g%3E%3Cg stroke='%23{{ str_replace('#', '', $mainColor) }}' stroke-width='1.5' fill='none'%3E%3Ccircle cx='10' cy='50' r='4'/%3E%3Ccircle cx='40' cy='80' r='4'/%3E%3Ccircle cx='40' cy='150' r='4'/%3E%3Ccircle cx='30' cy='160' r='4'/%3E%3Ccircle cx='50' cy='170' r='4'/%3E%3Ccircle cx='50' cy='210' r='4'/%3E%3Ccircle cx='50' cy='280' r='4'/%3E%3Ccircle cx='80' cy='240' r='4'/%3E%3Ccircle cx='60' cy='250' r='4'/%3E%3Ccircle cx='20' cy='30' r='4'/%3E%3Ccircle cx='50' cy='120' r='4'/%3E%3Ccircle cx='70' cy='50' r='4'/%3E%3Ccircle cx='95' cy='300' r='4'/%3E%3Ccircle cx='10' cy='350' r='4'/%3E%3Ccircle cx='40' cy='380' r='4'/%3E%3Ccircle cx='40' cy='450' r='4'/%3E%3Ccircle cx='30' cy='460' r='4'/%3E%3Ccircle cx='50' cy='470' r='4'/%3E%3Ccircle cx='50' cy='510' r='4'/%3E%3Ccircle cx='50' cy='580' r='4'/%3E%3Ccircle cx='80' cy='540' r='4'/%3E%3Ccircle cx='60' cy='550' r='4'/%3E%3Ccircle cx='20' cy='330' r='4'/%3E%3Ccircle cx='50' cy='420' r='4'/%3E%3Ccircle cx='70' cy='350' r='4'/%3E%3Ccircle cx='95' cy='600' r='4'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-size: 100% 100%; 
            z-index: 1;
        }
        .photo-container {
            width: 200px;
            height: 250px;
            border-radius: 15px;
            object-fit: cover;
            z-index: 2;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        @media print {
            .no-print { display: none; }
            body { background: white; }
            .badge-card { box-shadow: none; border: 1px solid #ddd; }
        }
    </style>
</head>
<body class="bg-slate-100 flex flex-col items-center justify-center min-h-screen p-4">

    <button onclick="window.print()" class="no-print mb-8 bg-blue-600 text-white px-8 py-3 rounded-xl font-bold shadow-lg hover:bg-blue-700 transition">
        IMPRIMER LE BADGE
    </button>

    <div class="badge-card">
        <div class="circuit-pattern"></div>
        
        <div class="w-[35%] flex items-center justify-center z-10 ml-8">
            @if($employee->photo)
                <img src="{{ asset('storage/' . $employee->photo) }}" class="photo-container">
            @else
                <div class="photo-container bg-gray-200 flex items-center justify-center text-gray-400">Photo</div>
            @endif
        </div>

        <div class="w-[65%] p-10 flex flex-col justify-between z-10">
            <div class="flex items-center justify-end gap-3">
                @if(!isset($hideCompanyName) || !$hideCompanyName)
                    <span class="text-2xl font-bold" style="color: {{ $mainColor }}">
                        {{ $employee->company->name ?? 'PAYMETRUST' }}
                    </span>
                @endif
                @if($employee->company && $employee->company->logo)
                    <img src="{{ asset('storage/' . $employee->company->logo) }}" class="h-10 w-auto">
                @endif
            </div>

            <div class="flex flex-col justify-center">
                <h1 class="text-4xl font-bold text-slate-900 uppercase">
                    {{ strtoupper($employee->last_name) }} {{ strtoupper($employee->first_name) }}
                </h1>
                <p class="text-xl font-medium mt-1" style="color: {{ $mainColor }}">
                    {{ $employee->function ?? 'Analyste Financier' }}
                </p>
                <p class="text-lg text-slate-600 mt-2">
                    Matricule : {{ $employee->matricule }}
                </p>
            </div>

            <div class="flex justify-end">
                <div class="p-1 border border-slate-200 rounded-lg">
                    {!! QrCode::size(100)->margin(0)->generate($qrData) !!}
                </div>
            </div>
        </div>
    </div>

</body>
</html>
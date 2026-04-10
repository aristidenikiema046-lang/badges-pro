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
            width: 35%;
            height: 100%;
            background-color: #f8fbff;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 200'%3E%3Cg fill='none' stroke='%23{{ str_replace('#', '', $mainColor) }}' stroke-width='0.6' opacity='0.3'%3E%3Cpath d='M-5 5 h20 l10 10 v10 l10 10 h70'/%3E%3Cpath d='M-5 45 h30 l15 15 v20 l10 10 h55'/%3E%3Cpath d='M-5 90 h15 l10 10 v30 l10 10 h75'/%3E%3C/g%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-size: cover;
            z-index: 1;
        }

        /* Photo centrée dans la zone gauche */
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
        
        <div class="w-[35%] flex items-center justify-center z-10">
            @if($employee->photo)
                <img src="{{ asset('storage/' . $employee->photo) }}" class="photo-container">
            @else
                <div class="photo-container bg-gray-200 flex items-center justify-center text-gray-400">Photo</div>
            @endif
        </div>

        <div class="w-[65%] p-10 flex flex-col justify-between z-10">
            
            <div class="flex items-center justify-end gap-3">
                <span class="text-2xl font-bold" style="color: {{ $mainColor }}">
                    {{ $employee->company->name ?? 'PAYMETRUST' }}
                </span>
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
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
        /* Dimensions CR80 réelles */
        .badge-card {
            width: 86mm;
            height: 54mm;
            background: white;
            border-radius: 3.18mm; /* Border-radius standard CR80 */
            display: flex;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
            margin: 20px auto;
            overflow: hidden;
            border: 0.5px solid #e0e0e0;
            position: relative;
            flex-shrink: 0;
        }

        .circuit-pattern {
            position: absolute;
            left: 0;
            top: 0;
            width: 15mm; /* Ajusté pour la taille réelle */
            height: 100%;
            background-color: #f8fbff;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 100 600' xmlns='http://www.w3.org/2000/svg'%3E%3Cdefs%3E%3ClinearGradient id='circuitGradient' x1='0%25' y1='0%25' x2='0%25' y2='100%25'%3E%3Cstop offset='0%25' style='stop-color:%234a90e2'/%3E%3Cstop offset='100%25' style='stop-color:%23{{ str_replace('#', '', $mainColor) }}'/%3E%3C/linearGradient%3E%3C/defs%3E%3Cg stroke='url(%23circuitGradient)' fill='none' stroke-width='1.8'%3E%3Cpath d='M10 0 L10 50 L40 80 L40 150 L10 180 L10 250 L50 280 L50 300'/%3E%3Cpath d='M30 0 L30 40 L60 70 L60 130 L30 160 L30 220 L60 250 L60 300' stroke-width='1.5'/%3E%3Cpath d='M50 0 L50 60 L80 90 L80 140 L50 170 L50 210 L80 240 L80 300' stroke-width='1.2'/%3E%3Cpath d='M20 0 L20 30 L50 30 L50 120 L20 120 L20 300' stroke-width='1.3' opacity='0.7'/%3E%3Cpath d='M70 0 L70 50 L95 50 L95 300' stroke-width='1' opacity='0.5'/%3E%3Cpath d='M10 50 L30 50' stroke-width='1.2'/%3E%3Cpath d='M40 100 L60 100' stroke-width='1.2'/%3E%3Cpath d='M30 200 L50 200' stroke-width='1.2'/%3E%3Cpath d='M20 70 L50 70' stroke-width='1'/%3E%3Cpath d='M70 250 L90 250' stroke-width='1'/%3E%3Cg transform='translate(0, 300)' stroke='url(%23circuitGradient)'%3E%3Cpath d='M10 0 L10 50 L40 80 L40 150 L10 180 L10 250 L50 280 L50 300'/%3E%3Cpath d='M30 0 L30 40 L60 70 L60 130 L30 160 L30 220 L60 250 L60 300' stroke-width='1.5'/%3E%3Cpath d='M50 0 L50 60 L80 90 L80 140 L50 170 L50 210 L80 240 L80 300' stroke-width='1.2'/%3E%3Cpath d='M20 0 L20 30 L50 30 L50 120 L20 120 L20 300' stroke-width='1.3' opacity='0.7'/%3E%3Cpath d='M70 0 L70 50 L95 50 L95 300' stroke-width='1' opacity='0.5'/%3E%3Cpath d='M10 50 L30 50' stroke-width='1.2'/%3E%3Cpath d='M40 100 L60 100' stroke-width='1.2'/%3E%3Cpath d='M30 200 L50 200' stroke-width='1.2'/%3E%3Cpath d='M20 70 L50 70' stroke-width='1'/%3E%3Cpath d='M70 250 L90 250' stroke-width='1'/%3E%3C/g%3E%3Cg stroke='%23{{ str_replace('#', '', $mainColor) }}' stroke-width='1.5' fill='none'%3E%3Ccircle cx='10' cy='50' r='4'/%3E%3Ccircle cx='40' cy='80' r='4'/%3E%3Ccircle cx='40' cy='150' r='4'/%3E%3Ccircle cx='30' cy='160' r='4'/%3E%3Ccircle cx='50' cy='170' r='4'/%3E%3Ccircle cx='50' cy='210' r='4'/%3E%3Ccircle cx='50' cy='280' r='4'/%3E%3Ccircle cx='80' cy='240' r='4'/%3E%3Ccircle cx='60' cy='250' r='4'/%3E%3Ccircle cx='20' cy='30' r='4'/%3E%3Ccircle cx='50' cy='120' r='4'/%3E%3Ccircle cx='70' cy='50' r='4'/%3E%3Ccircle cx='95' cy='300' r='4'/%3E%3Ccircle cx='10' cy='350' r='4'/%3E%3Ccircle cx='40' cy='380' r='4'/%3E%3Ccircle cx='40' cy='450' r='4'/%3E%3Ccircle cx='30' cy='460' r='4'/%3E%3Ccircle cx='50' cy='470' r='4'/%3E%3Ccircle cx='50' cy='510' r='4'/%3E%3Ccircle cx='50' cy='580' r='4'/%3E%3Ccircle cx='80' cy='540' r='4'/%3E%3Ccircle cx='60' cy='550' r='4'/%3E%3Ccircle cx='20' cy='330' r='4'/%3E%3Ccircle cx='50' cy='420' r='4'/%3E%3Ccircle cx='70' cy='350' r='4'/%3E%3Ccircle cx='95' cy='600' r='4'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-size: 100% 100%; 
            z-index: 1;
        }

        .photo-container {
            width: 24mm;
            height: 30mm;
            border-radius: 2mm;
            object-fit: cover;
            z-index: 2;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        @media print {
            .no-print { display: none !important; }
            body { background: white; padding: 0; margin: 0; }
            .badge-card { 
                box-shadow: none; 
                border: 0.2mm solid #ddd; 
                page-break-after: always;
                margin: 0;
            }
        }
    </style>
</head>
<body class="bg-slate-100 flex flex-col items-center justify-center min-h-screen p-4">

    <button onclick="window.print()" class="no-print mb-8 bg-blue-600 text-white px-8 py-3 rounded-xl font-bold shadow-lg hover:bg-blue-700 transition">
        IMPRIMER LE BADGE
    </button>

    {{-- RECTO --}}
    <div class="badge-card">
        <div class="circuit-pattern"></div>
        
        <div class="w-[38%] flex items-center justify-center z-10 ml-4">
            @if($employee->photo)
                <img src="{{ asset('storage/' . $employee->photo) }}" class="photo-container">
            @else
                <div class="photo-container bg-gray-200 flex items-center justify-center text-gray-400 text-[10px]">Photo</div>
            @endif
        </div>

        <div class="w-[62%] p-4 flex flex-col justify-between z-10">
            {{-- Header Logo/Nom --}}
            <div class="flex items-center justify-end gap-2">
                <span class="text-[10pt] font-bold" style="color: {{ $mainColor }}">
                    {{ $employee->company->name ?? 'PAYMETRUST' }}
                </span>
                @if($employee->company && $employee->company->logo)
                    <img src="{{ asset('storage/' . $employee->company->logo) }}" class="h-5 w-auto object-contain">
                @endif
            </div>

            {{-- Infos Employé --}}
            <div class="flex flex-col">
                <h1 class="text-[12pt] font-black text-slate-900 uppercase leading-tight">
                    {{ strtoupper($employee->last_name) }}<br>
                    {{ strtoupper($employee->first_name) }}
                </h1>
                <p class="text-[9pt] font-bold mt-1" style="color: {{ $mainColor }}">
                    {{ $employee->function ?? 'Analyste Financier' }}
                </p>
                <p class="text-[7pt] text-slate-600">
                    ID : {{ $employee->matricule }}
                </p>
            </div>

            {{-- QR Code --}}
            <div class="flex justify-end">
                <div class="p-0.5 border border-slate-200 rounded-sm bg-white">
                    {!! QrCode::size(45)->margin(0)->encoding('UTF-8')->generate($qrData) !!}
                </div>
            </div>
        </div>
    </div>

    {{-- VERSO --}}
    @if(strtoupper($employee->company->name) === 'PAYMETRUST')
    <div class="badge-card">
        <img src="{{ url('storage/badges/verso_paymetrust.png') }}" class="w-full h-full object-cover" alt="Verso">
    </div>
    @endif

</body>
</html>
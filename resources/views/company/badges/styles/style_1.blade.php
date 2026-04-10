@php 
    $mainColor = $employee->company->badge_color ?? '#1e3a8a';
    $hexColor = str_replace('#', '', $mainColor);
    
    // Votre SVG avec transformation (translate 373, scale -1) pour inverser le haut/bas
    $svgContent = <<<SVG
<svg viewBox='0 0 100 373' xmlns='http://www.w3.org/2000/svg'>
    <defs>
        <linearGradient id='grad' x1='0%' y1='0%' x2='0%' y2='100%'>
            <stop offset='0%' stop-color='%234a90e2'/>
            <stop offset='100%' stop-color='%23$hexColor'/>
        </linearGradient>
    </defs>
    <g transform='translate(0, 373) scale(1, -1)' stroke='url(%23grad)' fill='none' stroke-width='1.8'>
        <path d='M10 0 L10 50 L40 80 L40 150 L10 180 L10 250 L50 280 L50 373' />
        <path d='M30 0 L30 40 L60 70 L60 130 L30 160 L30 220 L60 250 L60 373' stroke-width='1.5' />
        <path d='M50 0 L50 60 L80 90 L80 140 L50 170 L50 210 L80 240 L80 373' stroke-width='1.2' />
        <path d='M20 0 L20 30 L50 30 L50 120 L20 120 L20 373' stroke-width='1.3' opacity='0.7' />
        <path d='M70 0 L70 50 L95 50 L95 373' stroke-width='1' opacity='0.5' />
        <g stroke='%23$hexColor' stroke-width='1.5' fill='none'>
            <circle cx='10' cy='50' r='4'/><circle cx='40' cy='80' r='4'/><circle cx='40' cy='150' r='4'/>
            <circle cx='30' cy='160' r='4'/><circle cx='50' cy='170' r='4'/><circle cx='50' cy='210' r='4'/>
            <circle cx='50' cy='280' r='4'/><circle cx='80' cy='240' r='4'/><circle cx='60' cy='250' r='4'/>
            <circle cx='20' cy='30' r='4'/><circle cx='50' cy='120' r='4'/><circle cx='70' cy='50' r='4'/>
        </g>
    </g>
</svg>
SVG;

    $encodedSvg = 'data:image/svg+xml,' . rawurlencode($svgContent);
    $qrData = "NOM: {$employee->last_name}\nPRENOM: {$employee->first_name}\nPOSTE: {$employee->function}\nID: {$employee->matricule}";
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
            background-image: url("{{ $encodedSvg }}");
            background-repeat: no-repeat;
            background-size: cover;
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
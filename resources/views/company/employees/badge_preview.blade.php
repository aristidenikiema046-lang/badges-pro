<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aperçu du Badge - {{ $employee->first_name }} {{ $employee->last_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { 
                background: white !important; 
                margin: 0 !important; 
                padding: 0 !important; 
                display: block !important;
            }
            /* Centre le badge sur la feuille A4 lors de l'impression */
            .print-container {
                display: flex !important;
                justify-content: center;
                align-items: center;
                height: 100vh;
            }
        }

        /* Taille ID-1 (Standard Badge) Landscape */
        .badge-wrapper {
            width: 125mm;
            height: 85.6mm;
            margin: 0 auto;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            box-sizing: border-box;
            overflow: hidden;
        }
    </style>
</head>
<body class="bg-slate-200 min-h-screen flex flex-col items-center justify-center p-4">

    <div class="badge-container shadow-2xl rounded-[2.5rem] overflow-hidden bg-white mb-10 no-print">
        <div class="badge-wrapper">
            @include('company.badges.styles.' . ($employee->badge_style ?? 'style_1'), ['employee' => $employee])
        </div>
    </div>

    <div class="hidden print:block print-container">
        <div class="badge-wrapper shadow-none border border-gray-100">
            @include('company.badges.styles.' . ($employee->badge_style ?? 'style_1'), ['employee' => $employee])
        </div>
    </div>

    <div class="no-print flex flex-col sm:flex-row gap-4 items-center">
        <button onclick="window.print()" 
                class="flex items-center text-white px-10 py-4 rounded-2xl font-bold shadow-lg transition-all hover:scale-105 active:scale-95" 
                style="background-color: {{ $employee->badge_color ?? '#059669' }};">
            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
            </svg>
            Imprimer mon badge
        </button>

        <a href="{{ route('inscription.tenant', ['slug' => $employee->company->slug]) }}" 
           class="bg-white text-slate-600 px-10 py-4 rounded-2xl font-bold border border-slate-200 hover:bg-slate-50 transition-all shadow-sm">
            Modifier les infos
        </a>
    </div>

</body>
</html>
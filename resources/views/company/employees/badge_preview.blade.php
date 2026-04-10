<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aperçu du Badge - {{ $employee->first_name }} {{ $employee->last_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Conteneur physique du badge pour l'impression */
        .badge-wrapper {
            width: 125mm;
            height: 85.6mm;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            box-sizing: border-box;
            overflow: hidden;
            background: white;
            flex-shrink: 0;
            transform-origin: center top;
        }

        /* Responsive : Gestion de l'échelle */
        .badge-container-responsive {
            display: flex;
            justify-content: center;
            width: 100%;
            padding: 20px 10px;
        }

        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
            .badge-container-responsive { padding: 0; }
            .badge-wrapper { transform: scale(1) !important; box-shadow: none !important; border: 1px solid #eee; }
        }
    </style>
</head>
<body class="bg-slate-200 min-h-screen flex flex-col items-center p-4">

    <div id="container" class="badge-container-responsive mb-8">
        <div id="badge-inner" class="badge-wrapper shadow-2xl rounded-[2.5rem]">
            @include('company.badges.styles.' . ($employee->badge_style ?? 'style_1'), ['employee' => $employee])
        </div>
    </div>

    <div class="no-print flex flex-col sm:flex-row gap-4 items-center mb-8">
        <button onclick="window.print()" 
                class="flex items-center text-white px-8 py-3 rounded-2xl font-bold shadow-lg transition-all hover:scale-105 active:scale-95" 
                style="background-color: {{ $employee->badge_color ?? '#059669' }};">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
            </svg>
            Imprimer le badge
        </button>

        <a href="{{ route('inscription.tenant', ['slug' => $employee->company->slug]) }}" 
           class="bg-white text-slate-600 px-8 py-3 rounded-2xl font-bold border border-slate-200 hover:bg-slate-50 transition-all shadow-sm">
            Modifier les infos
        </a>
    </div>

    <script>
        // Ajustement automatique de la taille pour les petits écrans
        function resizeBadge() {
            const container = document.getElementById('container');
            const badge = document.getElementById('badge-inner');
            const containerWidth = container.offsetWidth - 40; // Marge de sécurité
            const badgeWidth = 472; // 125mm en pixels approx (96dpi)

            if (containerWidth < badgeWidth) {
                const scale = containerWidth / badgeWidth;
                badge.style.transform = `scale(${scale})`;
            } else {
                badge.style.transform = `scale(1)`;
            }
        }

        window.addEventListener('resize', resizeBadge);
        window.addEventListener('load', resizeBadge);
    </script>
</body>
</html>
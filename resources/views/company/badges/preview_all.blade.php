<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Mon Badge - {{ $employee->first_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    @php 
        $is_export = isset($isPdf) && $isPdf;
        $getPath = function($path) use ($is_export) {
            if (empty($path)) return '';
            $cleanPath = str_replace('storage/', '', $path);
            return $is_export ? public_path('storage/' . $cleanPath) : asset('storage/' . $cleanPath);
        };

        $selectedStyle = $employee->company->badge_style ?? 'style_1';
        $landscapeStyles = ['style_4', 'style_6']; 
        $isLandscape = in_array($selectedStyle, $landscapeStyles);
    @endphp

    <style>
        /* Conteneur de mise à l'échelle pour le responsive */
        .badge-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            overflow: hidden;
            padding: 20px 0;
        }

        .badge-card {
            background: white;
            border-radius: 1.5rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            border: 2px solid {{ $employee->company->badge_color }}20;
            position: relative;
            transform-origin: center center;
            flex-shrink: 0;
        }

        .portrait-card { width: 85mm; height: 125mm; }
        .landscape-card { width: 125mm; height: 85mm; }

        @media print {
            .no-print { display: none !important; }
            body { background: white; padding: 0; }
            .badge-wrapper { padding: 0; }
            .badge-card { transform: scale(1) !important; box-shadow: none; border: 1px solid #eee; border-radius: 0; }
        }
    </style>
</head>
<body class="bg-slate-50 min-h-screen p-4 flex flex-col items-center">

    <div class="max-w-2xl text-center mb-6 no-print">
        <h1 class="text-2xl sm:text-3xl font-black uppercase tracking-tight" style="color: {{ $employee->company->badge_color }}">
            Félicitations !
        </h1>
        <p class="text-slate-500 mt-2 text-sm sm:text-base">
            Le badge de <strong>{{ $employee->first_name }} {{ $employee->last_name }}</strong> est prêt.
        </p>
    </div>

    <div id="container" class="badge-wrapper">
        <div id="badge-final" class="badge-card {{ $isLandscape ? 'landscape-card' : 'portrait-card' }}">
            <div class="w-full h-full overflow-hidden rounded-[1.4rem]">
                @include('company.badges.styles.' . $selectedStyle, [
                    'employee' => $employee,
                    'getPath' => $getPath
                ])
            </div>
        </div>
    </div>

    <div class="mt-8 flex flex-col w-full max-w-sm sm:flex-row gap-4 no-print">
        <button onclick="window.print()" 
                class="flex-1 text-white px-6 py-3 rounded-2xl font-bold hover:opacity-90 transition shadow-lg flex items-center justify-center gap-2" 
                style="background-color: {{ $employee->company->badge_color }}">
            Imprimer
        </button>
        <a href="{{ route('badge.export.single', ['id' => $employee->id, 'style' => $selectedStyle, 'format' => 'pdf']) }}" 
           class="flex-1 bg-white border-2 px-6 py-3 rounded-2xl font-bold text-slate-700 hover:bg-slate-50 transition flex items-center justify-center gap-2"
           style="border-color: {{ $employee->company->badge_color }}60">
            PDF
        </a>
    </div>

    <script>
        // Script pour réduire le badge si l'écran est trop petit
        function adjustBadgeScale() {
            const container = document.getElementById('container');
            const badge = document.getElementById('badge-final');
            const containerWidth = container.offsetWidth - 40;
            const badgeWidth = badge.offsetWidth;

            if (badgeWidth > containerWidth) {
                const scale = containerWidth / badgeWidth;
                badge.style.transform = `scale(${scale})`;
            } else {
                badge.style.transform = `scale(1)`;
            }
        }

        window.addEventListener('resize', adjustBadgeScale);
        window.addEventListener('load', adjustBadgeScale);
    </script>
</body>
</html>
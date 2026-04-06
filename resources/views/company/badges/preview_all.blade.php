<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sélecteur de Badge - {{ $employee->first_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    
    <style>
        /* CONFIGURATION IMPRESSION */
        @media print {
            .no-print { display: none !important; }
            .print-only { display: block !important; }
            body { background: white; margin: 0; padding: 0; }
            
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            .badge-selected { 
                width: 85.6mm; 
                height: 54mm;
                margin: 0 auto;
                page-break-after: always;
                display: flex;
                align-items: center;
                justify-content: center;
            }
        }

        /* STYLE ÉCRAN */
        .badge-card {
            width: 125mm;
            height: 85.6mm;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            background: white;
        }

        .badge-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.3);
        }

        .badge-card::after {
            content: 'Aperçu Impression';
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            opacity: 0;
            transition: opacity 0.3s;
            border-radius: 2.5rem;
        }

        .badge-card:hover::after {
            opacity: 1;
        }
    </style>
</head>
<body class="bg-slate-100 p-4 md:p-8">

    <div class="max-w-7xl mx-auto no-print">
        <header class="mb-12 text-center">
            <h1 class="text-4xl font-black text-slate-800 tracking-tight">Générateur de Badges</h1>
            <p class="text-slate-500 mt-2 text-lg">
                Employé : <span class="font-bold text-slate-900">{{ $employee->first_name }} {{ $employee->last_name }}</span>
            </p>
            
            <div class="flex justify-center gap-4 mt-8">
                <button onclick="window.print()" class="bg-slate-900 text-white px-8 py-3 rounded-2xl font-bold shadow-xl hover:bg-slate-800 transition flex items-center gap-2">
                    <span>🖨️</span> Imprimer tous les modèles
                </button>
            </div>
        </header>

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-16 justify-items-center">
            @foreach(range(1, 6) as $styleIndex)
                <div class="flex flex-col items-center w-full max-w-[125mm]">
                    <div class="flex justify-between w-full mb-4 px-2">
                        <span class="font-black text-slate-400 uppercase text-xs tracking-[0.2em]">Modèle #0{{ $styleIndex }}</span>
                    </div>
                    
                    <div id="badge-capture-{{ $styleIndex }}" 
                         class="badge-card shadow-2xl rounded-[2.5rem] overflow-hidden border-4 border-transparent hover:border-emerald-500"
                         onclick="printThisStyle({{ $styleIndex }})">
                        @include('company.badges.styles.style_' . $styleIndex, ['employee' => $employee])
                    </div>

                    <div class="mt-6 flex flex-col items-center gap-3 w-full">
                        <div class="flex gap-3">
                            <button onclick="printThisStyle({{ $styleIndex }})" 
                                    class="bg-emerald-500 hover:bg-emerald-600 text-white px-6 py-2 rounded-full font-bold text-sm shadow-md transition">
                                Imprimer
                            </button>
                            
                            <div class="flex bg-white rounded-full shadow-md border overflow-hidden">
                                <a href="{{ route('badge.export.single', ['id' => $employee->id, 'style' => $styleIndex, 'format' => 'pdf']) }}" 
                                   class="px-4 py-2 hover:bg-slate-50 border-r text-sm font-bold text-slate-600 transition">
                                   PDF
                                </a>
                                <button onclick="downloadPNG({{ $styleIndex }}, '{{ $employee->last_name }}')" 
                                        class="px-4 py-2 hover:bg-slate-50 text-sm font-bold text-slate-600 transition">
                                   PNG
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <footer class="mt-20 py-10 border-t border-slate-200 text-center text-slate-400 text-sm">
            Format standard : 85.6mm x 54mm (CR80)
        </footer>
    </div>

    <div id="print-zone" class="hidden print-only">
        @foreach(range(1, 6) as $styleIndex)
            <div class="badge-selected">
                @include('company.badges.styles.style_' . $styleIndex, ['employee' => $employee])
            </div>
        @endforeach
    </div>

    <script>
        /**
         * Impression d'un style unique
         */
        function printThisStyle(index) {
            const printZone = document.getElementById('print-zone');
            const badges = document.querySelectorAll('.badge-card');
            const selectedContent = badges[index - 1].innerHTML;
            
            const originalContent = printZone.innerHTML;
            printZone.innerHTML = `<div class="badge-selected">${selectedContent}</div>`;
            
            window.print();

            setTimeout(() => {
                printZone.innerHTML = originalContent;
            }, 1000);
        }

        /**
         * Export PNG via html2canvas (Côté client)
         */
        function downloadPNG(index, lastName) {
            const element = document.getElementById('badge-capture-' + index);
            
            // On utilise html2canvas pour transformer le HTML en image
            html2canvas(element, {
                scale: 3, // Améliore la résolution
                useCORS: true, // Autorise les images venant de ton serveur
                backgroundColor: null,
                logging: false,
            }).then(canvas => {
                const link = document.createElement('a');
                link.download = `badge-${lastName}-style${index}.png`;
                link.href = canvas.toDataURL("image/png");
                link.click();
            });
        }
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuration de l'Entreprise</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Correction du container de rendu */
        #style-render-container {
            /* On réduit un peu moins l'échelle pour une meilleure lisibilité */
            transform: scale(0.65); 
            transform-origin: center top;
            width: 100%;
            min-width: 450px; /* Force une largeur minimale pour éviter les coupures sur les styles horizontaux */
            display: flex;
            justify-content: center;
            transition: all 0.3s ease;
        }

        /* Conteneur parent pour gérer le scroll horizontal si le badge est trop large */
        .preview-wrapper {
            width: 100%;
            overflow-x: auto;
            overflow-y: hidden;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 20px 0;
        }

        /* Scrollbar personnalisée pour la zone d'aperçu */
        .preview-wrapper::-webkit-scrollbar {
            height: 4px;
        }
        .preview-wrapper::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
    </style>
</head>
<body class="bg-gray-100 p-4 md:p-8 font-sans">

    <div class="max-w-6xl mx-auto"> <!-- Augmenté de 4xl à 6xl pour donner plus d'espace -->
        <div class="flex justify-between items-center mb-6">
            <a href="{{ route('home') }}" class="text-orange-600 font-bold hover:underline">← Accueil</a>
            <a href="{{ route('companies.index') }}" class="text-teal-700 font-bold hover:underline">Gérer les entreprises →</a>
        </div>

        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border-t-8 border-orange-500">
            <div class="p-6 md:p-10">
                <h2 class="text-2xl font-black text-slate-800 uppercase mb-8">Configuration de l'Entreprise</h2>

                <form action="{{ route('companies.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Nom de l'entreprise *</label>
                            <input type="text" name="name" required class="w-full border-gray-200 rounded-xl p-3 bg-gray-50 outline-none focus:ring-2 focus:ring-orange-500">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Email Professionnel *</label>
                            <input type="email" name="email" required class="w-full border-gray-200 rounded-xl p-3 bg-gray-50 outline-none focus:ring-2 focus:ring-orange-500">
                        </div>
                    </div>

                    <div class="bg-slate-50 p-4 rounded-xl border border-dashed border-slate-300">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Logo de l'entreprise</label>
                        <input type="file" name="logo" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-orange-100 file:text-orange-700">
                    </div>

                    <div class="border-2 border-orange-100 rounded-2xl p-6 bg-orange-50/30">
                        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                            
                            <!-- Formulaire (40% de l'espace) -->
                            <div class="lg:col-span-5 space-y-6">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Modèle de Badge *</label>
                                    <select name="badge_style" id="badge_style" required class="w-full border-gray-200 rounded-xl p-3 bg-white shadow-sm focus:ring-2 focus:ring-orange-500">
                                        <option value="style_1">Style 1 - Classique Vertical</option>
                                        <option value="style_2">Style 2 - Moderne Géométrique</option>
                                        <option value="style_3">Style 3 - Épuré Minimaliste</option>
                                        <option value="style_4">Style 4 - Portrait Focus</option>
                                        <option value="style_5">Style 5 - Corporate Dark</option>
                                        <option value="style_6">Style 6 - Horizontal Pro</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Couleur de l'entreprise *</label>
                                    <input type="color" name="badge_color" id="badge_color" value="#f97316" class="h-14 w-full p-1 rounded-lg border-2 border-white shadow-md cursor-pointer">
                                </div>
                            </div>

                            <!-- Zone d'aperçu (60% de l'espace) -->
                            <div class="lg:col-span-7 flex flex-col items-center justify-start bg-white p-4 rounded-xl border border-orange-100 shadow-inner min-h-[450px]">
                                <span class="text-[10px] font-bold text-slate-400 uppercase mb-4 italic tracking-widest">Prévisualisation du rendu</span>
                                
                                <div id="preview-loader" class="hidden animate-spin rounded-full h-8 w-8 border-b-2 border-orange-500 mb-4"></div>
                                
                                <div class="preview-wrapper">
                                    <div id="style-render-container" class="transition-all duration-300">
                                        {{-- Le HTML du badge injecté ici --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-black py-5 rounded-xl shadow-lg transition-all uppercase tracking-widest text-lg">
                        Enregistrer et Générer le lien
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        const styleSelect = document.getElementById('badge_style');
        const colorInput = document.getElementById('badge_color');
        const renderContainer = document.getElementById('style-render-container');
        const loader = document.getElementById('preview-loader');

        function updateLivePreview() {
            const style = styleSelect.value;
            const color = encodeURIComponent(colorInput.value);
            
            loader.classList.remove('hidden');
            renderContainer.style.opacity = '0.3';

            fetch(`{{ url('/admin/preview-style') }}/${style}?color=${color}`)
                .then(response => {
                    if (!response.ok) throw new Error('Erreur');
                    return response.text();
                })
                .then(html => {
                    renderContainer.innerHTML = html;
                    renderContainer.style.opacity = '1';
                    loader.classList.add('hidden');
                })
                .catch(err => {
                    renderContainer.innerHTML = "<p class='text-red-400 text-xs'>Erreur de chargement de l'aperçu.</p>";
                    loader.classList.add('hidden');
                });
        }

        styleSelect.addEventListener('change', updateLivePreview);
        colorInput.addEventListener('input', updateLivePreview);
        document.addEventListener('DOMContentLoaded', updateLivePreview);

        @if(session('generated_slug'))
            Swal.fire({
                title: 'Succès !',
                html: `
                    <p class="text-sm mb-4 font-bold text-slate-600">L'entreprise {{ session('company_name') }} a été créée.</p>
                    <p class="text-[11px] mb-2 text-slate-400 uppercase tracking-wider text-left">Lien d'inscription des employés :</p>
                    <div class="bg-slate-100 p-3 rounded font-mono text-xs mb-4 break-all border border-orange-200 text-orange-700">
                        {{ url('/register/' . session('generated_slug')) }}
                    </div>
                    <button onclick="copyToClipboard('{{ url('/register/' . session('generated_slug')) }}')" class="w-full bg-teal-600 text-white px-4 py-3 rounded-lg font-bold text-sm hover:bg-teal-700 transition-colors">Copier le lien</button>
                `,
                icon: 'success',
                showConfirmButton: false,
                showCloseButton: true
            });
        @endif

        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Lien copié !',
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        }
    </script>
</body>
</html>
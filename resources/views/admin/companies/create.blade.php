<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuration de l'Entreprise</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Ajustement pour que le badge ne déborde pas dans la preview */
        #style-render-container {
            max-width: 100%;
            display: flex;
            justify-content: center;
        }
        #style-render-container > div {
            transform: scale(0.8);
            transform-origin: top center;
        }
    </style>
</head>
<body class="bg-gray-100 p-4 md:p-8 font-sans">

    <div class="max-w-4xl mx-auto">
        {{-- Navigation --}}
        <div class="flex justify-between items-center mb-6">
            <a href="{{ route('home') }}" class="text-orange-600 font-bold hover:underline">← Retour à l'accueil</a>
            <a href="{{ route('companies.index') }}" class="text-teal-700 font-bold hover:underline">Gérer les entreprises →</a>
        </div>

        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden border-t-8 border-orange-500">
            <div class="p-8">
                <h2 class="text-2xl font-black text-slate-800 uppercase tracking-tight mb-8">Configuration de l'Entreprise</h2>

                <form action="{{ route('companies.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf

                    {{-- Section 1 : Infos de base --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Nom de l'entreprise *</label>
                            <input type="text" name="name" placeholder="Ex: AgroNova SA" required class="w-full border-gray-200 rounded-xl p-3 bg-gray-50 focus:ring-2 focus:ring-orange-500 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Email Professionnel *</label>
                            <input type="email" name="email" placeholder="contact@entreprise.com" required class="w-full border-gray-200 rounded-xl p-3 bg-gray-50 focus:ring-2 focus:ring-orange-500 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Responsable</label>
                            <input type="text" name="manager_name" placeholder="Nom du gérant" class="w-full border-gray-200 rounded-xl p-3 bg-gray-50 focus:ring-2 focus:ring-orange-500 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Téléphone</label>
                            <input type="text" name="phone" placeholder="+225..." class="w-full border-gray-200 rounded-xl p-3 bg-gray-50 focus:ring-2 focus:ring-orange-500 outline-none transition-all">
                        </div>
                    </div>

                    {{-- Section 2 : Logo --}}
                    <div class="bg-slate-50 p-4 rounded-xl border border-dashed border-slate-300">
                        <label class="block text-sm font-bold text-slate-700 mb-2">Logo de l'entreprise</label>
                        <input type="file" name="logo" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-orange-100 file:text-orange-700 hover:file:bg-orange-200 cursor-pointer">
                    </div>

                    {{-- Section 3 : Design & Preview --}}
                    <div class="border-2 border-orange-100 rounded-2xl p-6 bg-orange-50/30">
                        <h3 class="text-orange-600 font-black uppercase text-sm mb-6 tracking-widest">Identité Visuelle des Badges</h3>
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            {{-- Contrôles --}}
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-sm font-bold text-slate-700 mb-2">Modèle de Badge *</label>
                                    <select name="badge_style" id="badge_style" required class="w-full border-gray-200 rounded-xl p-3 bg-white shadow-sm focus:ring-2 focus:ring-orange-500 outline-none transition-all">
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
                                    <div class="flex items-center gap-4">
                                        <input type="color" name="badge_color" id="badge_color" value="#f97316" class="h-14 w-24 p-1 rounded-lg border-2 border-white shadow-md cursor-pointer">
                                        <p class="text-xs text-slate-500 italic leading-snug">Cette couleur sera appliquée aux titres et bordures des badges.</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Preview Dynamique via Blade --}}
                            <div class="flex flex-col items-center justify-center bg-white p-4 rounded-xl border border-orange-100 shadow-inner min-h-[300px] overflow-hidden">
                                <span class="text-[10px] font-bold text-slate-400 uppercase mb-4 italic">Prévisualisation du rendu</span>
                                <div id="preview-loader" class="hidden animate-spin rounded-full h-8 w-8 border-b-2 border-orange-500 mb-4"></div>
                                <div id="style-render-container" class="w-full transition-all duration-300">
                                    {{-- Le HTML du badge sera injecté ici --}}
                                    <p class="text-slate-300 text-xs text-center">Chargement de l'aperçu...</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-orange-500 hover:bg-orange-600 text-white font-black py-5 rounded-xl shadow-lg shadow-orange-200 transition-all transform hover:-translate-y-1 uppercase tracking-widest text-lg">
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

        // Fonction pour charger la vue Blade du style
        function updateLivePreview() {
            const style = styleSelect.value;
            const color = encodeURIComponent(colorInput.value);
            
            loader.classList.remove('hidden');
            renderContainer.style.opacity = '0.3';

            fetch(`/admin/preview-style/${style}?color=${color}`)
                .then(response => response.text())
                .then(html => {
                    renderContainer.innerHTML = html;
                    renderContainer.style.opacity = '1';
                    loader.classList.add('hidden');
                })
                .catch(err => {
                    renderContainer.innerHTML = "<p class='text-red-400 text-xs'>Erreur de chargement du style</p>";
                    loader.classList.add('hidden');
                });
        }

        // Écouteurs d'événements
        styleSelect.addEventListener('change', updateLivePreview);
        colorInput.addEventListener('change', updateLivePreview);

        // Chargement initial
        document.addEventListener('DOMContentLoaded', updateLivePreview);

        // Affichage du succès avec le lien généré
        @if(session('generated_slug'))
            Swal.fire({
                title: 'Entreprise Enregistrée !',
                html: `
                    <p class="text-sm mb-4 text-gray-600">Le lien d'inscription pour les employés est prêt :</p>
                    <div class="bg-gray-100 p-3 rounded-lg border border-dashed border-orange-500 break-all font-mono text-xs mb-4">
                        {{ url('/register/' . session('generated_slug')) }}
                    </div>
                    <button onclick="copyLink('{{ url('/register/' . session('generated_slug')) }}')" class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg text-sm font-bold transition-colors">
                        Copier le lien
                    </button>
                `,
                icon: 'success',
                confirmButtonText: 'Terminer',
                confirmButtonColor: '#f97316'
            });
        @endif

        function copyLink(text) {
            navigator.clipboard.writeText(text).then(() => {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Lien copié !',
                    showConfirmButton: false,
                    timer: 2000
                });
            });
        }
    </script>
</body>
</html>
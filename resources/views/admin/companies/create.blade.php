<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuration de l'Entreprise</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

                            {{-- Preview Dynamique --}}
                            <div class="flex flex-col items-center justify-center bg-white p-4 rounded-xl border border-orange-100 shadow-inner min-h-[250px]">
                                <span class="text-[10px] font-bold text-slate-400 uppercase mb-4">Aperçu en direct</span>
                                <div id="preview-container" class="relative transition-all duration-300 transform scale-90">
                                    {{-- L'image de preview changera ici via JS --}}
                                    <img id="style-preview-img" src="{{ asset('images/previews/style_1.png') }}" alt="Preview" class="rounded shadow-lg max-h-48">
                                    <div id="color-bar" class="absolute top-0 left-0 w-full h-2 rounded-t" style="background-color: #f97316;"></div>
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

    {{-- Script pour la prévisualisation et l'affichage du lien généré --}}
    <script>
        // 1. Gestion de la prévisualisation
        const styleSelect = document.getElementById('badge_style');
        const colorInput = document.getElementById('badge_color');
        const previewImg = document.getElementById('style-preview-img');
        const colorBar = document.getElementById('color-bar');

        function updatePreview() {
            // Change l'image selon le style (Assure-toi d'avoir ces images dans public/images/previews/)
            const style = styleSelect.value;
            previewImg.src = `/images/previews/${style}.png`;
            
            // Applique la couleur sur la petite barre d'accent
            colorBar.style.backgroundColor = colorInput.value;
        }

        styleSelect.addEventListener('change', updatePreview);
        colorInput.addEventListener('input', updatePreview);

        // 2. Affichage du lien après succès (SweetAlert)
        @if(session('generated_slug'))
            Swal.fire({
                title: 'Entreprise Enregistrée !',
                html: `
                    <p class="mb-4">Le lien d'inscription pour vos employés est prêt :</p>
                    <div class="bg-gray-100 p-3 rounded-lg border border-dashed border-orange-500 break-all font-mono text-sm mb-4">
                        {{ url('/register/' . session('generated_slug')) }}
                    </div>
                    <button onclick="copyLink('{{ url('/register/' . session('generated_slug')) }}')" class="bg-teal-600 text-white px-4 py-2 rounded-lg text-sm font-bold">
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
                alert('Lien copié dans le presse-papier !');
            });
        }
    </script>
</body>
</html>
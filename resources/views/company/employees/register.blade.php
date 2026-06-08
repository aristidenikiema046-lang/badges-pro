<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accès Système - {{ $company->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght=300;400;700;900&display=swap');
        body { font-family: 'Inter', sans-serif; background: #f0f4f8; }
        .split-card { display: grid; grid-template-columns: 1fr 1fr; border: 1px solid #e2e8f0; }
        .blue-side { background: #2563eb; color: white; }
        @media (max-width: 768px) {
            .split-card { grid-template-columns: 1fr; }
            .blue-side { padding: 2rem 1.5rem; }
        }
    </style>
</head>
<body class="min-h-screen flex flex-col items-center justify-center p-4">

    <div class="w-full max-w-4xl bg-white rounded-3xl shadow-2xl overflow-hidden split-card">
        
        <div class="blue-side p-12 flex flex-col justify-between">
            <div>
                @if($company->logo)
                    <img src="{{ asset('storage/' . $company->logo) }}" alt="Logo {{ $company->name }}" class="h-20 w-20 bg-white p-2 rounded-2xl mb-8 object-contain">
                @endif
                <h1 class="text-4xl font-black uppercase tracking-tighter">Badges<br>Pro</h1>
                <div class="w-16 h-1 bg-blue-400 mt-6"></div>
                <p class="mt-8 text-blue-100 text-sm leading-relaxed opacity-80 font-light">
                    Plateforme sécurisée pour l'enregistrement et la génération autonome des badges professionnels de l'entreprise **{{ $company->name }}**.
                </p>
            </div>
            <div class="text-[10px] uppercase tracking-[0.2em] opacity-50 mt-8 md:mt-0">Protocole sécurisé v2026</div>
        </div>

        <div class="p-12 bg-white">
            <div id="error-box" class="hidden mb-6 bg-red-50 border border-red-200 text-red-600 text-xs p-3 rounded-xl font-medium"></div>

            <form id="ajax-register-form" class="space-y-4">
                @csrf
                <input type="hidden" name="company_id" value="{{ $company->id }}">

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest ml-1">Prénom</label>
                        <input type="text" id="first_name" name="first_name" required class="w-full bg-slate-50 border-b-2 border-slate-200 p-2 focus:border-blue-600 outline-none transition-all text-sm rounded-t-md">
                    </div>
                    <div>
                        <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest ml-1">Nom</label>
                        <input type="text" id="last_name" name="last_name" required class="w-full bg-slate-50 border-b-2 border-slate-200 p-2 focus:border-blue-600 outline-none transition-all text-sm rounded-t-md">
                    </div>
                </div>

                <div>
                    <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest ml-1">Adresse Email</label>
                    <input type="email" id="email" name="email" required class="w-full bg-slate-50 border-b-2 border-slate-200 p-2 focus:border-blue-600 outline-none transition-all text-sm rounded-t-md">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest ml-1">Poste occupé</label>
                        <input type="text" id="function" name="function" required class="w-full bg-slate-50 border-b-2 border-slate-200 p-2 focus:border-blue-600 outline-none transition-all text-sm rounded-t-md">
                    </div>
                    <div>
                        <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest ml-1">Matricule</label>
                        <input type="text" id="matricule" name="matricule" required class="w-full bg-slate-50 border-b-2 border-slate-200 p-2 focus:border-blue-600 outline-none transition-all text-sm rounded-t-md">
                    </div>
                </div>

                <div>
                    <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest ml-1">Département (Optionnel)</label>
                    <input type="text" id="department" name="department" class="w-full bg-slate-50 border-b-2 border-slate-200 p-2 focus:border-blue-600 outline-none transition-all text-sm rounded-t-md">
                </div>

                <div>
                    <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest ml-1">Photo d'identité</label>
                    <input type="file" id="photo" accept="image/jpeg,image/png,image/jpg" required class="w-full mt-2 text-[10px] text-slate-400 file:bg-blue-600 file:text-white file:border-0 file:px-4 file:py-2 file:rounded-full file:cursor-pointer file:hover:bg-blue-700 file:transition-all">
                </div>

                <button type="submit" id="submit-btn" class="w-full bg-blue-600 text-white font-black py-4 rounded-xl mt-6 hover:bg-blue-700 transition-all uppercase tracking-[0.2em] text-xs shadow-md shadow-blue-200">
                    Générer mon badge
                </button>
            </form>
        </div>
    </div>

    <div class="mt-8 text-[10px] text-slate-400 uppercase tracking-widest">
        © {{ date('Y') }} YaConsulting. Tous droits réservés.
    </div>

    <script>
        document.getElementById('ajax-register-form').addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const submitBtn = document.getElementById('submit-btn');
            const errorBox = document.getElementById('error-box');
            
            submitBtn.disabled = true;
            submitBtn.innerText = "TRAITEMENT...";
            errorBox.classList.add('hidden');

            const fileInput = document.getElementById('photo');
            let base64Photo = null;

            // Conversion sécurisée de l'image en Base64
            if (fileInput.files.length > 0) {
                const file = fileInput.files[0];
                
                // Vérification rapide de la taille côté client (Max 2Mo pour correspondre à Laravel)
                if (file.size > 2048 * 1024) {
                    errorBox.innerText = "La photo est trop lourde. Taille maximale autorisée : 2 Mo.";
                    errorBox.classList.remove('hidden');
                    submitBtn.disabled = false;
                    submitBtn.innerText = "GÉNÉRER MON BADGE";
                    return;
                }

                base64Photo = await new Promise((resolve) => {
                    const reader = new FileReader();
                    reader.onloadend = () => resolve(reader.result);
                    reader.readAsDataURL(file);
                });
            }

            // Construction propre de l'objet de données
            const payload = {
                _token: document.querySelector('input[name="_token"]').value,
                first_name: document.getElementById('first_name').value,
                last_name: document.getElementById('last_name').value,
                email: document.getElementById('email').value,
                function: document.getElementById('function').value,
                matricule: document.getElementById('matricule').value,
                department: document.getElementById('department').value,
                photo_base64: base64Photo
            };

            try {
                // Résolution dynamique et absolue de l'URL par le moteur Blade de Laravel
                const targetUrl = "{{ route('employee.store', ['slug' => $company->slug]) }}";

                const response = await fetch(targetUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                });

                const result = await response.json();

                if (response.ok && result.redirect) {
                    // Redirection globale explicite combinant l'origine et le chemin retourné
                    window.location.href = window.location.origin + result.redirect;
                } else {
                    // Capture des erreurs de validation (ex: email déjà pris, matricule existant)
                    throw new Error(result.message || "Une erreur de validation est survenue. Veuillez vérifier vos informations.");
                }
            } catch (error) {
                errorBox.innerText = error.message;
                errorBox.classList.remove('hidden');
                submitBtn.disabled = false;
                submitBtn.innerText = "GÉNÉRER MON BADGE";
            }
        });
    </script>
</body>
</html>
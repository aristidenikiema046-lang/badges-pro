<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accès Système - {{ $company->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght=300;700;900&display=swap');
        body { font-family: 'Inter', sans-serif; background: #f0f4f8; }
        .split-card { display: grid; grid-template-columns: 1fr 1fr; border: 1px solid #e2e8f0; }
        .blue-side { background: #2563eb; color: white; }
    </style>
</head>
<body class="min-h-screen flex flex-col items-center justify-center p-4">

    <div class="w-full max-w-4xl bg-white rounded-3xl shadow-2xl overflow-hidden split-card">
        
        <div class="blue-side p-12 flex flex-col justify-between">
            <div>
                @if($company->logo)
                    <img src="{{ asset('storage/' . $company->logo) }}" alt="Logo" class="h-20 w-20 bg-white p-2 rounded-2xl mb-8 object-contain">
                @endif
                <h1 class="text-4xl font-black uppercase tracking-tighter">Badges<br>Pro</h1>
                <div class="w-16 h-1 bg-blue-400 mt-6"></div>
                <p class="mt-8 text-blue-100 text-sm leading-relaxed opacity-80 font-light">
                    Plateforme sécurisée pour l'enregistrement et la gestion des badges professionnels {{ $company->name }}.
                </p>
            </div>
            <div class="text-[10px] uppercase tracking-[0.2em] opacity-50">Protocole sécurisé v2026</div>
        </div>

        <div class="p-12 bg-white">
            <div id="error-box" class="hidden mb-4 bg-red-50 border border-red-200 text-red-600 text-xs p-3 rounded-xl"></div>

            <form id="ajax-register-form">
                @csrf
                <input type="hidden" name="company_id" value="{{ $company->id }}">

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest ml-1">Prénom</label>
                        <input type="text" id="first_name" name="first_name" required class="w-full bg-slate-50 border-b-2 border-slate-200 p-2 focus:border-blue-600 outline-none transition-all">
                    </div>
                    <div>
                        <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest ml-1">Nom</label>
                        <input type="text" id="last_name" name="last_name" required class="w-full bg-slate-50 border-b-2 border-slate-200 p-2 focus:border-blue-600 outline-none transition-all">
                    </div>
                </div>

                <div>
                    <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest ml-1">Email</label>
                    <input type="email" id="email" name="email" required class="w-full bg-slate-50 border-b-2 border-slate-200 p-2 focus:border-blue-600 outline-none transition-all">
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest ml-1">Poste</label>
                        <input type="text" id="function" name="function" required class="w-full bg-slate-50 border-b-2 border-slate-200 p-2 focus:border-blue-600 outline-none transition-all">
                    </div>
                    <div>
                        <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest ml-1">Matricule</label>
                        <input type="text" id="matricule" name="matricule" required class="w-full bg-slate-50 border-b-2 border-slate-200 p-2 focus:border-blue-600 outline-none transition-all">
                    </div>
                </div>

                <div>
                    <label class="text-[9px] font-bold text-slate-400 uppercase tracking-widest ml-1">Photo</label>
                    <input type="file" id="photo" accept="image/*" required class="w-full mt-2 text-[10px] text-slate-400 file:bg-blue-600 file:text-white file:border-0 file:px-4 file:py-2 file:rounded-full">
                </div>

                <button type="submit" id="submit-btn" class="w-full bg-blue-600 text-white font-black py-4 rounded-xl mt-4 hover:bg-blue-700 transition-all uppercase tracking-[0.2em] text-xs">
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

            // Conversion de l'image en Base64 pour contourner le blocage cPanel
            if (fileInput.files.length > 0) {
                const file = fileInput.files[0];
                base64Photo = await new Promise((resolve) => {
                    const reader = new FileReader();
                    reader.onloadend = () => resolve(reader.result);
                    reader.readAsDataURL(file);
                });
            }

            const payload = {
                _token: document.querySelector('input[name="_token"]').value,
                first_name: document.getElementById('first_name').value,
                last_name: document.getElementById('last_name').value,
                email: document.getElementById('email').value,
                function: document.getElementById('function').value,
                matricule: document.getElementById('matricule').value,
                photo_base64: base64Photo
            };

            try {
                const response = await fetch(window.location.href + '/save', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                });

                const result = await response.json();

                if (response.ok && result.redirect) {
                    window.location.href = result.redirect;
                } else {
                    throw new Error(result.message || "Une erreur de validation est survenue.");
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
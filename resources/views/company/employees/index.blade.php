<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - {{ Auth::user()->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

    <nav class="bg-green-700 p-6 text-white shadow-lg">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold uppercase italic">Gestion des Badges</h1>
                <p class="text-green-100 text-xs tracking-widest uppercase font-bold">Espace Entreprise</p>
            </div>
            <a href="{{ route('home') }}" class="bg-white text-green-700 px-4 py-2 rounded font-black text-sm hover:bg-gray-100 transition">ACCUEIL</a>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto p-8">

        <div class="mb-10 bg-orange-50 border-2 border-orange-500 p-8 rounded-2xl shadow-xl border-dashed">
            <div class="flex items-center mb-4">
                <span class="text-3xl mr-3">🔗</span>
                <h2 class="text-orange-900 font-black text-xl uppercase italic">Votre lien d'enregistrement permanent</h2>
            </div>
            <p class="text-orange-800 mb-6 font-semibold">Partagez ce lien avec vos employés pour qu'ils remplissent leurs informations à tout moment :</p>
            
            <div class="flex flex-col md:flex-row items-center gap-4 bg-white p-5 rounded-xl border border-orange-200 shadow-inner">
                <code id="share-link" class="text-orange-600 font-mono font-bold flex-grow text-lg">
                    {{ url('/register/' . Auth::user()->company->slug) }}
                </code>
                <button onclick="copyLink()" id="btn-copy" class="w-full md:w-auto bg-orange-600 hover:bg-orange-700 text-white px-8 py-3 rounded-lg transition font-black uppercase shadow-md">
                    Copier le lien
                </button>
            </div>
            <p id="msg-copy" class="text-center text-emerald-600 font-bold mt-3 hidden italic">✓ Copié dans le presse-papier !</p>
        </div>

        <script>
            function copyLink() {
                const link = document.getElementById('share-link').innerText.trim();
                const btn = document.getElementById('btn-copy');
                const msg = document.getElementById('msg-copy');

                navigator.clipboard.writeText(link).then(() => {
                    // Feedback visuel
                    msg.classList.remove('hidden');
                    btn.innerText = "COPIÉ !";
                    btn.classList.replace('bg-orange-600', 'bg-slate-800');

                    setTimeout(() => {
                        msg.classList.add('hidden');
                        btn.innerText = "COPIER LE LIEN";
                        btn.classList.replace('bg-slate-800', 'bg-orange-600');
                    }, 3000);
                });
            }
        </script>

        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="p-6 border-b bg-gray-50 flex justify-between items-center">
                <h3 class="font-black text-gray-700 uppercase tracking-tighter">Collaborateurs Enregistrés</h3>
            </div>
            <table class="w-full text-left">
                <thead class="bg-slate-900 text-white text-[11px] uppercase tracking-widest font-bold">
                    <tr>
                        <th class="p-4">Nom & Prénom</th>
                        <th class="p-4 text-center">Statut</th>
                        <th class="p-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($employees as $emp)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4 font-bold text-gray-800">{{ $emp->first_name }} {{ $emp->last_name }}</td>
                        <td class="p-4 text-center">
                            @if($emp->is_validated)
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-[10px] font-black uppercase">Validé</span>
                            @else
                                <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-[10px] font-black uppercase italic">En attente</span>
                            @endif
                        </td>
                        <td class="p-4 text-right">
                            <a href="{{ route('badge.preview', $emp->id) }}" class="text-blue-600 font-bold text-xs hover:underline uppercase">Voir Badge</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="p-10 text-center text-gray-400 italic font-medium">Aucun employé inscrit via le lien pour le moment.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
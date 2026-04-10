<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - {{ $company->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

    <nav class="bg-green-700 p-6 text-white shadow-lg">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold uppercase italic">Gestion des Badges</h1>
                <p class="text-green-100 text-xs tracking-widest uppercase font-bold">{{ $company->name }}</p>
            </div>
            
            {{-- Bouton de déconnexion à la place de "Espace Partenaire" --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition font-black uppercase text-[11px] tracking-widest shadow-md border border-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Déconnexion
                </button>
            </form>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto p-8">

        {{-- Section Lien de Partage --}}
        <div class="mb-10 bg-orange-50 border-2 border-orange-500 p-8 rounded-2xl shadow-xl border-dashed">
            <div class="flex items-center mb-4">
                <span class="text-3xl mr-3">🔗</span>
                <h2 class="text-orange-900 font-black text-xl uppercase italic">Votre lien d'enregistrement permanent</h2>
            </div>
            <p class="text-orange-800 mb-6 font-semibold">Partagez ce lien avec vos employés pour qu'ils remplissent leurs informations :</p>
            
            <div class="flex flex-col md:flex-row items-center gap-4 bg-white p-5 rounded-xl border border-orange-200 shadow-inner">
                <code id="share-link" class="text-orange-600 font-mono font-bold flex-grow text-lg">
                    {{ url('/register/' . $company->slug) }}
                </code>
                <button onclick="copyLink()" id="btn-copy" class="w-full md:w-auto bg-orange-600 hover:bg-orange-700 text-white px-8 py-3 rounded-lg transition font-black uppercase shadow-md">
                    Copier le lien
                </button>
            </div>
            <p id="msg-copy" class="text-center text-emerald-600 font-bold mt-3 hidden italic">✓ Copié dans le presse-papier !</p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-500 text-white font-bold rounded shadow-lg">
                {{ session('success') }}
            </div>
        @endif

        {{-- Tableau des Employés --}}
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="p-6 border-b bg-gray-50">
                <h3 class="font-black text-gray-700 uppercase tracking-tighter">Collaborateurs Enregistrés</h3>
            </div>
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-900 text-white text-[11px] uppercase tracking-widest font-bold">
                    <tr>
                        <th class="p-4">Photo</th>
                        <th class="p-4">Nom & Prénom</th>
                        <th class="p-4">Poste / Service</th>
                        <th class="p-4 text-center">Statut</th>
                        <th class="p-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($employees as $emp)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4">
                            @if($emp->photo)
                                <img src="{{ asset('storage/' . $emp->photo) }}" class="w-10 h-10 rounded-full object-cover border border-gray-200">
                            @else
                                <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-[10px] text-gray-400">N/A</div>
                            @endif
                        </td>
                        <td class="p-4 font-bold text-gray-800">
                            {{ $emp->first_name }} {{ $emp->last_name }}
                            <div class="text-[9px] text-gray-400 font-mono">MAT: {{ $emp->matricule }}</div>
                        </td>
                        <td class="p-4 text-sm text-gray-600">
                            <span class="font-bold">{{ $emp->function }}</span> <br>
                            <span class="text-[10px] uppercase text-gray-400">{{ $emp->department }}</span>
                        </td>
                        <td class="p-4 text-center">
                            @if($emp->is_validated)
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-tighter border border-green-200">Validé</span>
                            @else
                                <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-[10px] font-black uppercase italic border border-orange-200">En attente</span>
                            @endif
                        </td>
                        <td class="p-4 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('badge.preview', $emp->id) }}" target="_blank" class="bg-blue-100 text-blue-600 p-2 rounded hover:bg-blue-600 hover:text-white transition shadow-sm" title="Voir Badge">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>

                                <a href="{{ route('employees.edit', ['slug' => $company->slug, 'id' => $emp->id]) }}" class="bg-gray-100 text-gray-600 p-2 rounded hover:bg-gray-800 hover:text-white transition shadow-sm" title="Modifier">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>

                                <form action="{{ route('employees.destroy', ['slug' => $company->slug, 'id' => $emp->id]) }}" method="POST" onsubmit="return confirm('Supprimer cet employé ?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="bg-red-50 text-red-600 p-2 rounded hover:bg-red-600 hover:text-white transition shadow-sm">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-10 text-center text-gray-400 italic font-medium">Aucun employé inscrit pour le moment.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function copyLink() {
            const link = document.getElementById('share-link').innerText.trim();
            const btn = document.getElementById('btn-copy');
            const msg = document.getElementById('msg-copy');

            navigator.clipboard.writeText(link).then(() => {
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
</body>
</html>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - {{ $company->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

    <nav class="bg-green-700 p-4 sm:p-6 text-white shadow-lg">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-4">
            <div class="text-center sm:text-left">
                <h1 class="text-xl sm:text-2xl font-bold uppercase italic">Gestion des Badges</h1>
                <p class="text-green-100 text-[10px] sm:text-xs tracking-widest uppercase font-bold">{{ $company->name }}</p>
            </div>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition font-black uppercase text-[10px] tracking-widest shadow-md border border-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Déconnexion
                </button>
            </form>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto p-4 sm:p-8">

        {{-- Section Lien de Partage --}}
        <div class="mb-10 bg-orange-50 border-2 border-orange-500 p-4 sm:p-8 rounded-2xl shadow-xl border-dashed">
            <div class="flex items-center mb-4">
                <span class="text-2xl sm:text-3xl mr-3">🔗</span>
                <h2 class="text-orange-900 font-black text-lg sm:text-xl uppercase italic">Lien d'enregistrement</h2>
            </div>
            <p class="text-orange-800 mb-6 font-semibold text-sm">Partagez ce lien avec vos employés :</p>
            
            <div class="flex flex-col md:flex-row items-center gap-4 bg-white p-4 sm:p-5 rounded-xl border border-orange-200 shadow-inner">
                <code id="share-link" class="text-orange-600 font-mono font-bold flex-grow text-xs sm:text-lg break-all text-center md:text-left">
                    {{ url('/register/' . $company->slug) }}
                </code>
                <button onclick="copyLink()" id="btn-copy" class="w-full md:w-auto bg-orange-600 hover:bg-orange-700 text-white px-6 py-3 rounded-lg transition font-black uppercase shadow-md text-sm whitespace-nowrap">
                    Copier le lien
                </button>
            </div>
            <p id="msg-copy" class="text-center text-emerald-600 font-bold mt-3 hidden italic">✓ Copié !</p>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-500 text-white font-bold rounded shadow-lg text-sm sm:text-base">
                {{ session('success') }}
            </div>
        @endif

        {{-- Tableau des Employés --}}
        <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="p-4 sm:p-6 border-b bg-gray-50">
                <h3 class="font-black text-gray-700 uppercase tracking-tighter">Collaborateurs Enregistrés</h3>
            </div>

            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-900 text-white text-[10px] uppercase tracking-widest font-bold">
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
                                @if($emp->photo)<img src="{{ asset('storage/' . $emp->photo) }}" class="w-10 h-10 rounded-full object-cover">
                                @else<div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-[10px]">N/A</div>@endif
                            </td>
                            <td class="p-4 font-bold text-sm">{{ $emp->first_name }} {{ $emp->last_name }}<br><span class="text-[9px] text-gray-400 font-mono">MAT: {{ $emp->matricule }}</span></td>
                            <td class="p-4 text-sm">{{ $emp->function }}<br><span class="text-[10px] uppercase text-gray-400">{{ $emp->department }}</span></td>
                            <td class="p-4 text-center"><span class="{{ $emp->is_validated ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }} px-3 py-1 rounded-full text-[10px] font-black uppercase">{{ $emp->is_validated ? 'Validé' : 'Attente' }}</span></td>
                            <td class="p-4 text-right">
                                <div class="flex justify-end gap-2 items-center">
                                    <a href="{{ route('badge.preview', $emp->id) }}" target="_blank" class="p-2">👁️</a>
                                    <a href="{{ route('employees.edit', ['slug' => $company->slug, 'id' => $emp->id]) }}" class="p-2">✏️</a>
                                    <form action="{{ route('employees.destroy', [$company->slug, $emp->id]) }}" method="POST" onsubmit="return confirm('Supprimer cet employé ?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 text-red-500 hover:text-red-700">🗑️</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="p-10 text-center text-gray-400 italic">Aucun employé inscrit.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="md:hidden divide-y divide-gray-100">
                @forelse($employees as $emp)
                <div class="p-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        @if($emp->photo)<img src="{{ asset('storage/' . $emp->photo) }}" class="w-10 h-10 rounded-full object-cover">@endif
                        <div>
                            <p class="font-bold text-sm">{{ $emp->first_name }} {{ $emp->last_name }}</p>
                            <p class="text-[10px] text-gray-500">{{ $emp->function }}</p>
                        </div>
                    </div>
                    <div class="flex gap-1 items-center">
                        <a href="{{ route('badge.preview', $emp->id) }}" class="p-2 bg-blue-50 text-blue-600 rounded">👁️</a>
                        <a href="{{ route('employees.edit', ['slug' => $company->slug, 'id' => $emp->id]) }}" class="p-2 bg-gray-100 text-gray-600 rounded">✏️</a>
                        <form action="{{ route('employees.destroy', [$company->slug, $emp->id]) }}" method="POST" onsubmit="return confirm('Supprimer ?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-2 bg-red-50 text-red-600 rounded">🗑️</button>
                        </form>
                    </div>
                </div>
                @empty
                <p class="p-6 text-center text-gray-400">Aucun employé.</p>
                @endforelse
            </div>
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
                setTimeout(() => { msg.classList.add('hidden'); btn.innerText = "COPIER LE LIEN"; }, 3000);
            });
        }
    </script>
</body>
</html>
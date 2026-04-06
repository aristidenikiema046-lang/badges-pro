<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Employés - {{ $company->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">

    <div class="bg-green-700 p-6 text-white shadow-lg">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold">Gestion des Badges : {{ $company->name }}</h1>
                <p class="text-green-100 text-sm">Tableau de bord de l'entreprise</p>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-sm bg-green-800 px-4 py-2 rounded border border-green-600">
                    Mode : {{ strtoupper($company->validation_mode ?? 'MANUEL') }}
                </div>
                <a href="{{ route('home') }}" class="text-sm bg-white text-green-700 px-4 py-2 rounded font-bold hover:bg-gray-100 transition">
                    Accueil
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto p-8">
        
        @if(session('generated_link'))
            <div class="mb-8 bg-orange-50 border-2 border-orange-500 p-6 rounded-xl shadow-md border-dashed animate-pulse-once">
                <div class="flex items-center mb-3">
                    <span class="text-2xl mr-2">🚀</span>
                    <h3 class="text-orange-800 font-bold text-lg uppercase">Votre lien d'inscription est prêt !</h3>
                </div>
                <p class="text-sm text-orange-700 mb-4">Envoyez ce lien à vos employés pour qu'ils puissent s'enregistrer :</p>
                
                <div class="flex items-center gap-2 bg-white p-4 rounded-lg border border-orange-200 shadow-inner">
                    <code id="share-link" class="text-orange-600 font-mono font-bold flex-grow text-sm md:text-base">
                        {{ session('generated_link') }}
                    </code>
                    <button onclick="copyToClipboard()" class="bg-orange-500 text-white px-6 py-2 rounded-lg hover:bg-orange-600 transition font-bold uppercase text-xs">
                        Copier
                    </button>
                </div>
                <p id="copy-msg" class="text-xs text-orange-600 mt-2 font-bold hidden italic text-center text-emerald-600">Lien copié avec succès !</p>
            </div>

            <script>
                function copyToClipboard() {
                    const text = document.getElementById('share-link').innerText;
                    navigator.clipboard.writeText(text).then(() => {
                        const msg = document.getElementById('copy-msg');
                        msg.classList.remove('hidden');
                        setTimeout(() => msg.classList.add('hidden'), 3000);
                    });
                }
            </script>
        @endif

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 font-medium rounded shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="p-4 font-bold text-gray-700 uppercase text-xs tracking-wider">Employé</th>
                        <th class="p-4 font-bold text-gray-700 uppercase text-xs tracking-wider">Matricule</th>
                        <th class="p-4 font-bold text-gray-700 uppercase text-xs tracking-wider">Fonction</th>
                        <th class="p-4 font-bold text-gray-700 uppercase text-xs tracking-wider text-center">Statut</th>
                        <th class="p-4 font-bold text-gray-700 uppercase text-xs tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($employees as $employee)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-4 text-sm font-bold text-gray-900">
                            {{ $employee->first_name }} {{ $employee->last_name }}
                        </td>
                        <td class="p-4 text-gray-600 font-mono text-sm uppercase">
                            {{ $employee->badge_number ?? '---' }}
                        </td>
                        <td class="p-4 text-gray-600 text-sm italic">
                            {{ $employee->function }}
                        </td>
                        <td class="p-4 text-center">
                            @if($employee->is_validated)
                                <span class="px-3 py-1 rounded-full text-[10px] font-black bg-green-100 text-green-700 border border-green-200 uppercase">Validé</span>
                            @else
                                <span class="px-3 py-1 rounded-full text-[10px] font-black bg-orange-100 text-orange-700 border border-orange-200 uppercase">En attente</span>
                            @endif
                        </td>
                        <td class="p-4 text-right">
                            @if(!$employee->is_validated)
                                <form action="{{ route('employee.validate', $employee->id) }}" method="POST" class="inline">
                                    @csrf @method('PATCH')
                                    <button class="bg-orange-500 text-white px-3 py-1 rounded text-xs font-bold">Valider</button>
                                </form>
                            @else
                                <a href="{{ route('badge.preview', $employee->id) }}" target="_blank" class="bg-green-600 text-white px-3 py-1 rounded text-xs font-bold">Badge</a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-12 text-center text-gray-400 italic">Aucun employé enregistré.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-6 text-center text-gray-400 text-xs uppercase font-bold tracking-tighter">
            &copy; 2026 - Système de Gestion des Badges - {{ $company->name }}
        </div>
    </div>
</body>
</html>
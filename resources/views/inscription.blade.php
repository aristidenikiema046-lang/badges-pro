<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demande de Badge - {{ $company->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4 md:p-6 font-sans">

    <div class="w-full max-w-2xl bg-white rounded-3xl shadow-2xl overflow-hidden border border-gray-100">
        <div class="p-6 md:p-10 text-center" style="background-color: {{ $company->badge_color }}">
            @if($company->logo)
                <img src="{{ asset('storage/' . $company->logo) }}" alt="Logo" class="h-16 md:h-20 mx-auto mb-4 bg-white p-2 rounded-lg shadow-sm">
            @endif
            <h1 class="text-white text-xl md:text-2xl font-black uppercase tracking-widest">Demande de Badge</h1>
            <p class="text-white opacity-90 font-medium italic mt-1">{{ $company->name }}</p>
        </div>

        <form action="{{ route('employee.store') }}" method="POST" class="p-6 md:p-10 space-y-5">
            @csrf
            <input type="hidden" name="company_id" value="{{ $company->id }}">

            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg">
                    <ul class="list-disc ml-5 text-xs md:text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs md:text-sm font-bold text-gray-700 mb-1">Nom *</label>
                    <input type="text" name="last_name" required class="w-full rounded-xl p-3 border-2 focus:ring-2 outline-none transition-colors" style="border-color: {{ $company->badge_color }}">
                </div>
                <div>
                    <label class="block text-xs md:text-sm font-bold text-gray-700 mb-1">Prénom *</label>
                    <input type="text" name="first_name" required class="w-full rounded-xl p-3 border-2 focus:ring-2 outline-none transition-colors" style="border-color: {{ $company->badge_color }}">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-xs md:text-sm font-bold text-gray-700 mb-1">Email Professionnel *</label>
                    <input type="email" name="email" required class="w-full rounded-xl p-3 border-2 focus:ring-2 outline-none transition-colors" style="border-color: {{ $company->badge_color }}">
                </div>
                <div>
                    <label class="block text-xs md:text-sm font-bold text-gray-700 mb-1">Matricule Interne *</label>
                    <input type="text" name="matricule" required class="w-full rounded-xl p-3 border-2 focus:ring-2 outline-none transition-colors font-mono uppercase" style="border-color: {{ $company->badge_color }}">
                </div>
            </div>

            <div>
                <label class="block text-xs md:text-sm font-bold text-gray-700 mb-1">Fonction / Poste *</label>
                <input type="text" name="function" required class="w-full rounded-xl p-3 border-2 focus:ring-2 outline-none transition-colors" style="border-color: {{ $company->badge_color }}">
            </div>

            <button type="submit" class="w-full text-white font-black py-4 rounded-xl shadow-lg hover:opacity-90 transition-all uppercase tracking-widest text-base md:text-lg mt-2" style="background-color: {{ $company->badge_color }}">
                Générer mon badge
            </button>
        </form>
    </div>
</body>
</html>
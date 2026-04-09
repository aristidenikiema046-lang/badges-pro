@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto p-8">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
        <div class="bg-black p-6 text-white flex justify-between items-center">
            <h2 class="text-xl font-bold uppercase tracking-widest text-orange-500">Détails : {{ $company->name }}</h2>
            <a href="{{ route('companies.index') }}" class="text-sm text-gray-400 hover:text-white">← Retour</a>
        </div>

        <div class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                <div>
                    <h3 class="text-xs font-bold text-gray-400 uppercase mb-4">Informations Générales</h3>
                    <p class="mb-2"><strong>Email :</strong> {{ $company->email }}</p>
                    <p class="mb-2"><strong>Manager :</strong> {{ $company->manager_name ?? 'Non spécifié' }}</p>
                    <p class="mb-2"><strong>Téléphone :</strong> {{ $company->phone ?? 'Non spécifié' }}</p>
                </div>
                <div class="text-center">
                    <h3 class="text-xs font-bold text-gray-400 uppercase mb-4">Logo</h3>
                    @if($company->logo)
                        <img src="{{ asset('storage/' . $company->logo) }}" class="w-32 h-32 mx-auto rounded-lg object-cover border">
                    @else
                        <div class="w-32 h-32 mx-auto bg-gray-100 flex items-center justify-center text-gray-400 italic text-xs border rounded-lg">Aucun logo</div>
                    @endif
                </div>
            </div>

            <div class="border-t pt-8 flex flex-col gap-4">
                <a href="{{ route('company.employees', $company->slug) }}" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white text-center py-4 rounded-lg font-bold shadow-lg transition">
                    👤 VOIR ET GÉRER LES EMPLOYÉS
                </a>
                <a href="{{ route('companies.edit', $company->id) }}" class="w-full border border-gray-300 text-center py-3 rounded-lg font-bold hover:bg-gray-50 transition">
                    Modifier les paramètres de l'entreprise
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
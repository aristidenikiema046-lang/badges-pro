@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gray-100 p-4 sm:p-8">
    <div class="max-w-4xl mx-auto w-full">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
            {{-- Header --}}
            <div class="bg-black p-6 text-white flex flex-col sm:flex-row justify-between items-center gap-4">
                <h2 class="text-lg sm:text-xl font-bold uppercase tracking-widest text-orange-500 text-center sm:text-left">
                    Détails : {{ $company->name }}
                </h2>
                <a href="{{ route('companies.index') }}" class="text-sm text-gray-400 hover:text-white transition">
                    ← Retour
                </a>
            </div>

            <div class="p-6 sm:p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    {{-- Informations Générales --}}
                    <div>
                        <h3 class="text-xs font-bold text-gray-400 uppercase mb-4 tracking-wider">Informations Générales</h3>
                        <div class="space-y-3 text-sm sm:text-base">
                            <p><strong>Email :</strong> <span class="break-all block sm:inline">{{ $company->email }}</span></p>
                            <p><strong>Manager :</strong> {{ $company->manager_name ?? 'Non spécifié' }}</p>
                            <p><strong>Téléphone :</strong> {{ $company->phone ?? 'Non spécifié' }}</p>
                        </div>
                    </div>

                    {{-- Logo --}}
                    <div class="text-center">
                        <h3 class="text-xs font-bold text-gray-400 uppercase mb-4 tracking-wider">Logo</h3>
                        @if($company->logo)
                            <img src="{{ asset('storage/' . $company->logo) }}" class="w-24 h-24 sm:w-32 sm:h-32 mx-auto rounded-lg object-contain border bg-gray-50">
                        @else
                            <div class="w-24 h-24 sm:w-32 sm:h-32 mx-auto bg-gray-100 flex items-center justify-center text-gray-400 italic text-xs border rounded-lg">
                                Aucun logo
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Actions --}}
                <div class="border-t pt-8 flex flex-col gap-4">
                    <a href="{{ route('company.employees', $company->slug) }}" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white text-center py-4 rounded-lg font-bold shadow-lg transition uppercase tracking-widest text-sm sm:text-base">
                        👤 Gérer les employés
                    </a>
                    <a href="{{ route('companies.edit', $company->id) }}" class="w-full border border-gray-300 text-center py-3 rounded-lg font-bold hover:bg-gray-50 transition text-sm sm:text-base">
                        Modifier les paramètres
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
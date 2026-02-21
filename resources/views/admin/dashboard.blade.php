@extends('admin.master')

@section('title', 'Tableau de Bord')

@section('admin_content')
{{-- Le x-data englobe tout pour que le bouton puisse ouvrir le modal --}}
<div x-data="{ showModal: false }" class="space-y-8">
    
    {{-- Messages de succès --}}
    @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-600 px-6 py-4 rounded-2xl flex items-center gap-3">
            <i class="fa-solid fa-circle-check"></i>
            <span class="font-bold">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-600 px-6 py-4 rounded-2xl flex items-center gap-3">
            <i class="fa-solid fa-triangle-exclamation"></i>
            <span class="font-bold">{{ session('error') }}</span>
        </div>
    @endif

    {{-- Header & Action --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900">Tableau de bord</h1>
            <p class="text-slate-500">Bonjour Admin, voici un aperçu de votre parc immobilier.</p>
        </div>
        {{-- Déclencheur du Modal --}}
        <button @click="showModal = true" class="bg-indigo-600 text-white px-6 py-3 rounded-2xl font-bold hover:bg-slate-900 transition-all shadow-lg shadow-indigo-200 flex items-center gap-2">
            <i class="fa-solid fa-plus"></i>
            Ajouter un nouveau bien
        </button>
    </div>

    {{-- Cartes de Statistiques --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 text-indigo-50 opacity-10 group-hover:scale-110 transition-transform">
                <i class="fa-solid fa-house-chimney text-8xl"></i>
            </div>
            <p class="text-slate-500 font-semibold text-sm uppercase tracking-wider">Total Biens</p>
            <h3 class="text-4xl font-extrabold text-slate-900 mt-2">{{ $totalProperties }}</h3>
            <span class="text-emerald-500 text-xs font-bold bg-emerald-50 px-2 py-1 rounded-lg mt-4 inline-block">+{{ $totalProperties }} actif</span>
        </div>

        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100">
            <p class="text-slate-500 font-semibold text-sm uppercase tracking-wider">En Vente</p>
            <h3 class="text-4xl font-extrabold text-slate-900 mt-2">{{ $totalVente }}</h3>
            <div class="w-full bg-slate-100 h-2 rounded-full mt-4">
                <div class="bg-indigo-500 h-2 rounded-full" style="width: 10%"></div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100">
            <p class="text-slate-500 font-semibold text-sm uppercase tracking-wider">Réservations</p>
            <h3 class="text-4xl font-extrabold text-slate-900 mt-2">{{ $totalReservation }}</h3>
            <span class="text-indigo-500 text-xs font-bold bg-indigo-50 px-2 py-1 rounded-lg mt-4 inline-block">{{ $occupancyRate }}% d'occupation</span>
        </div>

        <div class="bg-indigo-600 p-6 rounded-[2rem] shadow-xl shadow-indigo-100 text-white">
            <p class="opacity-80 font-semibold text-sm uppercase tracking-wider">Location</p>
            <h3 class="text-3xl font-extrabold mt-2">{{ $totalRent }}</h3>
            <p class="text-xs mt-4 opacity-70">Catalogue location actif</p>
        </div>
    </div>

    {{-- Tableau & Activités --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-6 border-b border-slate-50 flex justify-between items-center">
                <h2 class="font-bold text-slate-800 text-lg">Dernières Annonces</h2>
                <a href="#" class="text-indigo-600 text-sm font-bold">Voir tout</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50">
                        <tr class="text-slate-400 text-[10px] uppercase tracking-widest">
                            <th class="px-6 py-4">Aperçu</th>
                            <th class="px-6 py-4">Nom du bien</th>
                            <th class="px-6 py-4">Type</th>
                            <th class="px-6 py-4">Prix</th>
                            <th class="px-6 py-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($recentProperties as $property)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                @php $mainImg = $property->images->where('is_main', true)->first(); @endphp
                                <img src="{{ $mainImg ? $mainImg->path : 'https://via.placeholder.com/100' }}" 
                                     class="w-12 h-12 rounded-xl object-cover shadow-sm">
                            </td>
                            <td class="px-6 py-4 font-bold text-slate-700">{{ $property->title }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-[10px] font-bold rounded-full 
                                    {{ $property->offer_type == 'Vente' ? 'bg-amber-50 text-amber-600' : 'bg-indigo-50 text-indigo-600' }}">
                                    {{ strtoupper($property->offer_type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 font-extrabold text-slate-900">
                                {{ number_format($property->price, 0, ',', ' ') }}€
                            </td>
                            <td class="px-6 py-4 flex gap-2">
                                <a href="#" class="p-2 bg-slate-100 rounded-lg hover:bg-indigo-600 hover:text-white transition-all">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                <form action="#" method="POST" onsubmit="return confirm('Supprimer ce bien ?')">
                                    @csrf @method('DELETE')
                                    <button class="p-2 bg-slate-100 rounded-lg hover:bg-red-500 hover:text-white transition-all">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-slate-400 italic">Aucun bien enregistré.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-6">
            <h2 class="font-bold text-slate-800 text-lg mb-6">Activités Récentes</h2>
            <div class="space-y-6 text-sm italic text-slate-400">
                Logique d'activité à venir...
            </div>
        </div>
    </div>

    {{-- MODAL D'AJOUT (Logique Alpine.js) --}}
    <div x-show="showModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         x-cloak 
         class="fixed inset-0 z-50 overflow-y-auto">
        
        {{-- Overlay flou --}}
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

        <div class="flex items-center justify-center min-h-screen p-4">
            {{-- Fenêtre du Modal --}}
            <div @click.away="showModal = false" 
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 class="glass relative bg-white rounded-[2.5rem] shadow-2xl max-w-lg w-full p-8 overflow-hidden border border-white/20">
                
                <div class="mb-8 text-center">
                    <h2 class="text-2xl font-extrabold text-slate-900">Nouveau bien</h2>
                    <p class="text-slate-500 text-sm">Commençons par les informations essentielles.</p>
                </div>

                <form action="{{ route('admin.properties.quickStore') }}" method="POST" class="space-y-5" 
      x-data="{ offer: 'Vente' }"> {{-- On initialise une variable locale au formulaire --}}
    @csrf
    
    {{-- Titre --}}
    <div>
        <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-2 ml-2">Titre du bien</label>
        <input type="text" name="title" placeholder="Ex: Villa Azure Nice" required
               class="w-full px-5 py-4 rounded-2xl bg-slate-50 border border-slate-100 focus:border-indigo-500 outline-none transition">
    </div>

    <div class="grid grid-cols-2 gap-4">
        {{-- Catégorie --}}
        <div>
            <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-2 ml-2">Catégorie</label>
            <select name="category_id" class="w-full px-5 py-4 rounded-2xl bg-slate-50 border border-slate-100 outline-none appearance-none cursor-pointer">
                @foreach(\App\Models\Category::all() as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Type d'offre avec écouteur de changement --}}
        <div>
            <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-2 ml-2">Type d'offre</label>
            <select name="offer_type" x-model="offer" class="w-full px-5 py-4 rounded-2xl bg-slate-50 border border-slate-100 outline-none appearance-none cursor-pointer">
                <option value="Vente">Vente</option>
                <option value="Location">Location</option>
                <option value="Réservation">Réservation (Hôtel)</option>
            </select>
        </div>
    </div>

    {{-- Prix avec Label Dynamique --}}
    <div>
        <label class="block text-[10px] font-bold uppercase tracking-widest text-slate-400 mb-2 ml-2">
            Prix en Euros (Label: 
            <span class="text-indigo-600 font-extrabold" x-text="offer === 'Vente' ? 'Total' : (offer === 'Location' ? 'par mois' : 'par nuit')"></span>)
        </label>
        <div class="relative">
            <input type="number" name="price" placeholder="0.00" step="0.01" required
                   class="w-full px-5 py-4 rounded-2xl bg-slate-50 border border-slate-100 focus:border-indigo-500 outline-none transition">
            <span class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 font-bold">€</span>
        </div>
    </div>

    <div class="flex gap-3 pt-6">
        <button type="button" @click="showModal = false" class="flex-1 px-6 py-4 rounded-2xl font-bold text-slate-500 hover:bg-slate-50 transition-all">Annuler</button>
        <button type="submit" class="flex-1 bg-indigo-600 text-white px-6 py-4 rounded-2xl font-bold hover:bg-slate-900 transition-all shadow-lg shadow-indigo-100">
            Continuer <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
        </button>
    </div>
</form>
            </div>
        </div>
    </div>
</div>
@endsection
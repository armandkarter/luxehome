@extends('admin.master')

@section('title', 'Compléter le bien')

@section('admin_content')

@if ($errors->has('images.*'))
    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-2xl">
        <div class="flex items-center">
            <i class="fa-solid fa-circle-exclamation text-red-500 mr-3"></i>
            <p class="text-sm text-red-700 font-bold">
                Format d'image non supporté ou fichier trop lourd (Max 5Mo).
            </p>
        </div>
    </div>
@endif

<div class="max-w-5xl mx-auto space-y-8 pb-20" x-data="propertyUpload()">
    {{-- Header --}}
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.dashboard') }}" class="p-3 bg-white rounded-2xl border border-slate-100 text-slate-400 hover:text-indigo-600 transition shadow-sm">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">{{ $property->title }}</h1>
            <p class="text-slate-500 text-sm">Étape finale : Détails techniques et Galerie photos</p>
        </div>
    </div>

    <form action="{{ route('admin.properties.updateDetails', $property->id) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        @csrf
        @method('PUT')

        {{-- Colonne Gauche : Détails techniques --}}
        <div class="lg:col-span-2 space-y-6">
            
            {{-- Description & Localisation --}}
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 space-y-6">
                <div class="space-y-4">
                    <h3 class="font-bold text-lg text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-align-left text-indigo-500"></i> Description du bien
                    </h3>
                    <textarea name="description" rows="6" required
                            class="w-full px-5 py-4 rounded-2xl bg-slate-50 border border-slate-100 outline-none focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/5 transition resize-none" 
                            placeholder="Décrivez les points forts du bien...">
                    </textarea>
                </div>
                
                <div class="space-y-4 pt-4">
                    <h3 class="font-bold text-lg text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-location-dot text-indigo-500"></i> Localisation
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <input type="text" name="city" placeholder="Ville (ex: Nice)" required
                                class="w-full px-5 py-4 rounded-2xl bg-slate-50 border border-slate-100 outline-none focus:border-indigo-500 transition">


                        <select name="country_id" id="country-select" required
                                class="w-full px-5 py-4 rounded-2xl bg-slate-50 border border-slate-100 outline-none focus:border-indigo-500 transition">
                            <option value="">Sélectionnez un pays</option>
                            @foreach($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                        <input type="text" name="country_image" id="country-image" placeholder="URL de l'image du pays" required
                                class="w-full px-5 py-4 rounded-2xl bg-slate-50 border border-slate-100 outline-none focus:border-indigo-500 transition">
                        <input type="text" name="address" placeholder="Adresse complète" required
                                class="w-full px-5 py-4 rounded-2xl bg-slate-50 border border-slate-100 outline-none focus:border-indigo-500 transition">
                    </div>
                </div>
            </div>

            {{-- Galerie Photos Dynamique --}}
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="font-bold text-lg text-slate-800 flex items-center gap-2">
                        <i class="fa-solid fa-images text-indigo-500"></i> Galerie Photos
                    </h3>
                    <span class="text-xs font-bold text-slate-400 uppercase tracking-widest" x-text="files.length + ' photos prêtes'"></span>
                </div>

                <input type="file" id="real-file-input" name="images[]" multiple class="hidden">

                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    {{-- Affichage des aperçus cumulés --}}
                    <template x-for="(image, index) in previews" :key="index">
                        <div class="relative aspect-square rounded-2xl overflow-hidden border border-slate-100 group shadow-sm">
                            <img :src="image" class="w-full h-full object-cover">
                            
                            {{-- Badge Photo Principale --}}
                            <div x-show="index === 0" class="absolute top-2 left-2 bg-indigo-600 text-[8px] text-white font-bold px-2 py-1 rounded-lg uppercase">
                                Couverture
                            </div>

                            {{-- Bouton Supprimer --}}
                            <button type="button" @click="removeImage(index)" 
                                    class="absolute top-2 right-2 w-7 h-7 bg-red-500 text-white rounded-full opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center shadow-lg">
                                <i class="fa-solid fa-times text-xs"></i>
                            </button>
                        </div>
                    </template>

                    {{-- Bouton d'ajout --}}
                    <label class="relative aspect-square rounded-2xl border-2 border-dashed border-slate-200 hover:border-indigo-400 hover:bg-indigo-50 transition-all cursor-pointer flex flex-col items-center justify-center gap-2 group">
                        <input type="file" class="hidden" @change="handleFiles($event)" accept="image/*" multiple>
                        <div class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center group-hover:bg-indigo-100 group-hover:text-indigo-600 transition-colors shadow-sm">
                            <i class="fa-solid fa-plus text-lg"></i>
                        </div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Ajouter</span>
                    </label>
                </div>
                <p class="text-xs text-slate-400 mt-4 italic"><i class="fa-solid fa-info-circle mr-1"></i> Cliquez sur "Ajouter" autant de fois que nécessaire.</p>
            </div>
        </div>

        {{-- Colonne Droite --}}
        <div class="space-y-6">
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 space-y-6">
                <h3 class="font-bold text-lg text-slate-800">Caractéristiques</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2 ml-1">Surface (m²)</label>
                        <div class="relative">
                            <input type="number" name="area" class="w-full px-5 py-4 rounded-2xl bg-slate-50 border border-slate-100 outline-none focus:border-indigo-500 transition">
                            <span class="absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 text-xs font-bold">m²</span>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2 ml-1">Chambres</label>
                            <input type="number" name="bedrooms" value="0" class="w-full px-5 py-4 rounded-2xl bg-slate-50 border border-slate-100 outline-none">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2 ml-1">Sdb</label>
                            <input type="number" name="bathrooms" value="0" class="w-full px-5 py-4 rounded-2xl bg-slate-50 border border-slate-100 outline-none">
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
                <h3 class="font-bold text-lg text-slate-800 mb-6">Équipements</h3>
                <div class="grid grid-cols-1 gap-3">
                    @foreach(['Wifi Haute Vitesse', 'Piscine privée', 'Parking sécurisé', 'Climatisation', 'Cuisine équipée', 'Salle de sport', 'Vue mer'] as $amenity)
                        <label class="group flex items-center gap-3 p-4 bg-slate-50 rounded-2xl cursor-pointer hover:bg-indigo-50 transition-all border border-transparent hover:border-indigo-100">
                            <input type="checkbox" name="amenities[]" value="{{ $amenity }}" 
                                   class="w-5 h-5 rounded-lg border-slate-300 text-indigo-600 focus:ring-indigo-500 transition cursor-pointer">
                            <span class="text-sm font-semibold text-slate-600 group-hover:text-indigo-700 transition-colors">{{ $amenity }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="w-full bg-slate-900 text-white p-6 rounded-[2.5rem] font-bold text-lg hover:bg-indigo-600 transition-all shadow-xl shadow-slate-200 flex items-center justify-center gap-3 group">
                Publier l'annonce
                <i class="fa-solid fa-paper-plane text-sm group-hover:translate-x-1 group-hover:-translate-y-1 transition-transform"></i>
            </button>
        </div>
    </form>
</div>

<script>
    function propertyUpload() {
        return {
            previews: [], // Pour l'affichage visuel
            files: [],    // Stockage réel des objets File
            
            handleFiles(event) {
                const newFiles = Array.from(event.target.files);
                
                newFiles.forEach(file => {
                    this.files.push(file); // On accumule les fichiers
                    
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.previews.push(e.target.result);
                    };
                    reader.readAsDataURL(file);
                });
                
                this.syncInput();
            },

            removeImage(index) {
                this.files.splice(index, 1);
                this.previews.splice(index, 1);
                this.syncInput();
            },

            syncInput() {
                // Création d'un container virtuel pour les fichiers
                const dataTransfer = new DataTransfer();
                this.files.forEach(file => dataTransfer.items.add(file));
                
                // On injecte la totalité des fichiers accumulés dans l'input réel
                document.getElementById('real-file-input').files = dataTransfer.files;
            }
        }
    }
</script>

<style>
    [x-cloak] { display: none !important; }
</style>
@endsection
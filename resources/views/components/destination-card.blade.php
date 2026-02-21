@props(['destination', 'index', 'link'])

@php
    // Logique d'affichage : la première carte est plus grande sur PC
    $gridClass = ($index === 0) ? 'md:col-span-2 md:row-span-2' : 'md:col-span-1 md:row-span-1';
    
    // Image par défaut si vide
    $imagePath = $destination->country_image ?? 'https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?q=80&w=800&auto=format&fit=crop';
@endphp

<a href="{{ $link }}" 
   {{ $attributes->merge([
       'class' => "$gridClass flex-shrink-0 w-[75vw] md:w-full snap-center relative group overflow-hidden rounded-[2.5rem] md:rounded-[3rem] shadow-lg bg-slate-900 h-[400px] md:h-full transition-all duration-500"
   ]) }}>
    
    {{-- Image de fond --}}
    <img src="{{ $imagePath }}" 
         class="absolute inset-0 w-full h-full object-cover opacity-70 group-hover:scale-110 transition duration-1000" 
         {{-- Si tes noms de pays en BDD sont en français, on peut les traduire via messages.php si tu y crées des clés --}}
         alt="{{ __('messages.dest_name_' . Str::slug($destination->country)) ?? $destination->country }}">

    {{-- Overlay dégradé --}}
    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/20 to-transparent"></div>

    {{-- Infos --}}
    <div class="absolute bottom-8 left-8 right-8 text-white z-10">
        <h3 class="text-2xl font-black tracking-tight mb-1">
            {{-- Traduction dynamique du nom du pays si disponible --}}
            {{ __('messages.dest_name_' . Str::slug($destination->country)) ?? $destination->country }}
        </h3>
        <div class="flex items-center gap-2">
            {{-- Utilisation de trans_choice pour gérer le pluriel (0 propriété, 1 propriété, 2 propriétés) --}}
            <span class="text-[11px] font-medium text-white/70">
                {{ trans_choice('messages.dest_card_properties_count', $destination->total, ['count' => $destination->total]) }}
            </span>
            <div class="w-1 h-1 rounded-full bg-indigo-500"></div>
            <span class="text-[10px] uppercase font-bold text-indigo-400">
                {{ __('messages.dest_card_explore') }}
            </span>
        </div>
    </div>
</a>
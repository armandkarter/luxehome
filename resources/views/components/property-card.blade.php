@props(['property'])

@php
    // Logique pour l'image principale
    $mainImg = $property->images->where('is_main', true)->first() ?? $property->images->first();
    $imagePath = $mainImg ? asset('uploads/properties/' . $mainImg->path) : 'https://via.placeholder.com/800x600?text=LuxeHabitat';
    
    // CORRECTION : On passe bien les paramètres requis par ton URI : {locale} et {slug_uuid}
    $url = route('properties.show', [
        'locale'    => app()->getLocale(), 
        'slug_uuid' => $property->url_identifier // Assure-toi que url_identifier correspond au slug_uuid attendu
    ]);
@endphp

<div {{ $attributes->merge(['class' => 'snap-start flex-shrink-0 w-[85%] sm:w-[45%] md:w-[30%] lg:w-[23%]']) }}>
    {{-- On utilise directement la variable $url ici --}}
    <a href="{{ $url }}" class="group block bg-white rounded-[2rem] border border-slate-100 overflow-hidden hover:shadow-xl transition-all duration-500">
        
        {{-- Image & Badge --}}
        <div class="relative h-56 overflow-hidden">
            <img src="{{ $imagePath }}" 
                 class="w-full h-full object-cover group-hover:scale-110 transition duration-700"
                 alt="{{ $property->title }}">
            
            <div class="absolute top-3 right-3 bg-white/90 backdrop-blur-md px-2 py-1 rounded-xl flex items-center gap-2 shadow">
                <span class="text-indigo-600 font-black text-xs">8.9</span>
            </div>

            <div class="absolute bottom-3 left-3 bg-slate-900/60 backdrop-blur-sm text-white text-[10px] px-3 py-1 rounded-lg font-bold uppercase tracking-wider">
                {{ __('messages.property_offer_' . Str::slug($property->offer_type)) }}
            </div>
        </div>

        {{-- Contenu --}}
        <div class="p-6">
            <h3 class="text-lg font-bold text-slate-900 mb-1 truncate">{{ $property->title }}</h3>
            
            <p class="text-slate-400 text-xs mb-4 flex items-center">
                <i class="fa-solid fa-location-dot mr-1 text-indigo-500"></i> 
                {{ $property->details->city ?? __('messages.property_location_default') }}
            </p>

            <div class="flex items-center justify-between border-t border-slate-50 pt-4">
                <div>
                    <p class="text-xl font-black text-slate-900">
                        {{ number_format($property->price, 0, '.', ' ') }} <span class="text-xs">€</span>
                        @if(Str::slug($property->offer_type) == 'rent' || Str::slug($property->offer_type) == 'booking')
                            <span class="text-[10px] text-slate-400 font-medium lowercase">/ {{ __('messages.property_price_period') }}</span>
                        @endif
                    </p>
                </div>
                <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </div>
            </div>
        </div>
    </a>
</div>
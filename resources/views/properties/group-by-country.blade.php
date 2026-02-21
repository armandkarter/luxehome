@extends('welcome')

@section('title', __('messages.seo_country_title', ['country' => $countryName]))
@section('meta_description')
    @php
        $seoTitle = __('messages.seo_country_title', ['country' => $countryName]);
        $seoDesc = __('messages.seo_country_desc', ['country' => $countryName]);
    @endphp
    <title>{{ $seoTitle }}</title>
    <meta name="description" content="{{ $seoDesc }}">
    <meta property="og:title" content="{{ $seoTitle }}">
    <meta property="og:description" content="{{ $seoDesc }}">
    <meta property="og:type" content="website">
    <link rel="canonical" href="{{ url()->current() }}">
@endsection

@section('content')
<div class="bg-slate-50 min-h-screen">
    
    {{-- HEADER --}}
    <header class="bg-white border-b border-slate-100 pt-32 pb-16">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <span class="text-indigo-600 font-bold uppercase tracking-[0.3em] text-[10px]">{{ __('messages.country_tag') }}</span>
            <h1 class="text-4xl md:text-7xl font-black text-slate-900 mt-4 tracking-tight">
                {{ __('messages.country_title_prefix') }} <span class="text-indigo-400">{{ $countryName }}</span>
            </h1>
            <p class="text-slate-400 mt-6 max-w-2xl mx-auto font-medium italic px-4">
                {{ __('messages.country_subtitle') }}
            </p>
        </div>
    </header>

    <div class="max-w-7xl mx-auto py-12 px-6">
        @forelse($propertiesGrouped as $categoryName => $properties)
            {{-- UNE RANGÉE PAR CATÉGORIE --}}
            <div class="mb-16">
                <div class="flex items-center justify-between mb-8 border-b border-slate-200 pb-4">
                    <div class="flex items-center gap-4">
                        <h2 class="text-2xl md:text-3xl font-black text-slate-900 tracking-tight">{{ Str::plural($categoryName) }}</h2>
                        <span class="bg-indigo-600 text-white text-[10px] font-black px-3 py-1 rounded-full uppercase">
                            {{ $properties->count() }}
                        </span>
                    </div>
                    {{-- Petit indicateur visuel pour mobile --}}
                    <span class="md:hidden text-[10px] font-bold text-slate-400 flex items-center gap-2">
                        {{ __('messages.country_swipe') }} <i class="fa-solid fa-arrow-right-long animate-pulse"></i>
                    </span>
                </div>

                {{-- CONTENEUR ADAPTATIF --}}
                <div class="flex overflow-x-auto pb-8 snap-x snap-mandatory no-scrollbar gap-6 md:grid md:grid-cols-2 lg:grid-cols-3 md:overflow-visible md:pb-0">
                    @foreach($properties as $property)
                        @php
                            $mainImg = $property->images->where('is_main', true)->first() ?? $property->images->first();
                            $imagePath = $mainImg ? asset('uploads/properties/' . $mainImg->path) : 'https://via.placeholder.com/800x600?text=LuxeHabitat';
                        @endphp

                        <div class="min-w-[85%] sm:min-w-[45%] md:min-w-0 w-full snap-start">
                            <a href="{{ route('properties.show', ['locale' => app()->getLocale(), 'slug_uuid' => $property->url_identifier]) }}" class="group block bg-white rounded-[2.5rem] border border-slate-100 overflow-hidden hover:shadow-2xl transition-all duration-500 h-full">
                                {{-- Image --}}
                                <div class="relative h-60 md:h-64 overflow-hidden">
                                    <img src="{{ $imagePath }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700" alt="{{ $property->title }}">
                                    <div class="absolute bottom-4 left-4 bg-slate-900/60 backdrop-blur-md text-white text-[10px] px-3 py-1.5 rounded-xl font-bold uppercase tracking-widest">
                                        {{ __("messages.offer_" . Str::slug($property->offer_type)) }}
                                    </div>
                                </div>

                                {{-- Contenu --}}
                                <div class="p-6 md:p-8">
                                    <h3 class="text-lg md:text-xl font-bold text-slate-900 mb-2 truncate italic font-serif">{{ $property->title }}</h3>
                                    <p class="text-slate-400 text-[11px] md:text-xs mb-6 flex items-center">
                                        <i class="fa-solid fa-location-dot mr-2 text-indigo-500"></i> {{ $property->details->city ?? __('messages.location_not_specified') }}
                                    </p>

                                    <div class="flex items-center justify-between border-t border-slate-50 pt-4 md:pt-6">
                                        <div>
                                            <p class="text-xl md:text-2xl font-black text-slate-900 italic">
                                                {{ number_format($property->price, 0, '.', ' ') }} 
                                                <span class="text-sm font-bold text-indigo-500">€</span>
                                            </p>
                                        </div>
                                        <span class="text-[10px] uppercase font-black text-slate-400 tracking-tighter leading-none mt-1">
                                            @if($property->price_label === 'total')
                                                {{ __('messages.price_sale') }}
                                            @elseif($property->price_label === 'par mois')
                                                {{ __('messages.label_mois') }}
                                            @elseif($property->price_label === 'par nuit')
                                                {{ __('messages.label_nuit') }}
                                            @else
                                                {{ $property->price_label }}
                                            @endif
                                        </span>
                                        <div class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-slate-900 flex items-center justify-center text-white group-hover:bg-indigo-600 transition-all shadow-lg">
                                            <i class="fa-solid fa-arrow-right text-xs md:text-sm"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="text-center py-32">
                <h3 class="text-2xl font-bold text-slate-400">{{ __('messages.no_properties_country', ['country' => $countryName]) }}</h3>
            </div>
        @endforelse
    </div>
</div>

<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
@endsection
@extends('welcome')

@section('title', __('messages.cat_show_seo_title', ['name' => Str::plural($category->name)]))

@section('meta_description')
    <meta name="description" content="{{ __('messages.cat_show_seo_description', ['name' => Str::lower(Str::plural($category->name))]) }}">
    <meta name="keywords" content="{{ __('messages.cat_show_seo_keywords', ['name' => $category->name]) }}">
    
    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ __('messages.cat_show_seo_og_title', ['name' => Str::plural($category->name)]) }}">
    <meta property="og:description" content="{{ __('messages.cat_show_seo_og_description', ['name' => $category->name]) }}">
    <meta property="og:image" content="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?q=80&w=800&auto=format&fit=crop">

    {{-- Twitter --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ __('messages.cat_show_seo_tw_title', ['name' => Str::plural($category->name)]) }}">
    <meta name="twitter:description" content="{{ __('messages.cat_show_seo_tw_description', ['name' => $category->name]) }}">
    
    <link rel="canonical" href="{{ url()->current() }}">
@endsection

@section('content')
<div class="bg-slate-50 min-h-screen">
    
    {{-- HEADER DYNAMIQUE --}}
    <header class="bg-white border-b border-slate-100 pt-32 pb-16">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <span class="text-indigo-600 font-bold uppercase tracking-[0.3em] text-[10px]">{{ __('messages.cat_show_collection_label') }}</span>
            <h1 class="text-4xl md:text-7xl font-black text-slate-900 mt-4 tracking-tight">
                {{ Str::plural($category->name) }} <span class="text-indigo-400">{{ __('messages.cat_show_world_suffix') }}</span>
            </h1>
            <p class="text-slate-400 mt-6 max-w-2xl mx-auto font-medium italic">
                {{ __('messages.cat_show_description', ['name' => Str::lower(Str::plural($category->name))]) }}
            </p>
        </div>
    </header>

    <div class="max-w-7xl mx-auto py-12 px-6">
        @forelse($propertiesGrouped as $countryName => $properties)
            {{-- UNE SECTION PAR PAYS --}}
            <div class="mb-16">
                <div class="flex items-center justify-between mb-8 border-b border-slate-200 pb-4">
                    <div class="flex items-center gap-4">
                        <h2 class="text-2xl md:text-3xl font-black text-slate-900 tracking-tight">
                            {{ __('messages.cat_show_country_prefix') }} <span class="text-indigo-600">{{ $countryName ?? __('messages.cat_show_unknown_dest') }}</span>
                        </h2>
                        <span class="bg-slate-900 text-white text-[10px] font-black px-3 py-1 rounded-full uppercase italic">
                            {{ $properties->count() }} {{ trans_choice('messages.cat_show_count_label', $properties->count()) }}
                        </span>
                    </div>
                    
                    @php 
                        $countrySlug = Illuminate\Support\Facades\Crypt::encryptString($countryName); 
                    @endphp
                    <a href="{{ route('destinations.show', ['locale' => app()->getLocale(), 'slug' => $countrySlug]) }}" class="text-xs font-bold text-slate-400 hover:text-indigo-600 transition-colors hidden md:block">
                        {{ __('messages.cat_show_view_all_country', ['country' => $countryName]) }} <i class="fa-solid fa-chevron-right ml-1"></i>
                    </a>
                </div>

                {{-- GRID --}}
                <div class="flex overflow-x-auto pb-8 snap-x snap-mandatory no-scrollbar gap-6 md:grid md:grid-cols-2 lg:grid-cols-3 md:overflow-visible md:pb-0">
                    @foreach($properties as $property)
                        @php
                            $mainImg = $property->images->where('is_main', true)->first() ?? $property->images->first();
                            $imagePath = $mainImg ? asset('uploads/properties/' . $mainImg->path) : 'https://via.placeholder.com/800x600?text=LuxeHabitat';
                        @endphp

                        <div class="min-w-[85%] sm:min-w-[45%] md:min-w-0 w-full snap-start">
                            <a href="{{ route('properties.show', ['locale' => app()->getLocale(), 'slug_uuid' => $property->url_identifier]) }}" class="group block bg-white rounded-[2.5rem] border border-slate-100 overflow-hidden hover:shadow-2xl transition-all duration-500 h-full">
                                
                                <div class="relative h-60 md:h-64 overflow-hidden">
                                    <img src="{{ $imagePath }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700" alt="{{ $property->title }}">
                                    
                                    <div class="absolute bottom-4 left-4 bg-slate-900/60 backdrop-blur-md text-white text-[10px] px-3 py-1.5 rounded-xl font-bold uppercase tracking-widest">
                                        {{ $property->offer_type }}
                                    </div>
                                </div>

                                <div class="p-8">
                                    <h3 class="text-xl font-bold text-slate-900 mb-2 truncate italic font-serif">{{ $property->title }}</h3>
                                    
                                    <div class="flex justify-between items-center mt-6 pt-6 border-t border-slate-50">
                                        <div>
                                            <p class="text-2xl font-black text-slate-900 italic leading-none">
                                                {{ number_format($property->price, 0, '.', ' ') }} <span class="text-sm font-bold text-indigo-500">€</span>
                                            </p>
                                            <p class="text-[9px] uppercase font-black text-slate-400 mt-2 tracking-widest">
                                                @if($property->price_label === 'total') 
                                                    {{ __('messages.cat_show_price_sale') }} 
                                                @else 
                                                    {{ __('messages.cat_show_price_per') }} {{ $property->price_label }} 
                                                @endif
                                            </p>
                                        </div>
                                        <div class="w-12 h-12 rounded-full bg-slate-900 text-white flex items-center justify-center group-hover:bg-indigo-600 transition-all shadow-lg">
                                            <i class="fa-solid fa-arrow-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="text-center py-40 bg-white rounded-[4rem] border-2 border-dashed border-slate-100">
                <i class="fa-solid fa-couch text-5xl text-slate-200 mb-6"></i>
                <h3 class="text-2xl font-bold text-slate-400 italic">
                    {{ __('messages.cat_show_empty', ['name' => $category->name]) }}
                </h3>
            </div>
        @endforelse
    </div>
</div>

<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
@endsection
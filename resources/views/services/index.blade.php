@extends('welcome')

{{-- SEO DYNAMIQUE --}}
@section('title', $config['title'] . ' | Luxe Home')

@section('meta_description')
    <meta name="description" content="{{ $config['subtitle'] }} {{ __('messages.seo_service_suffix') }}">
    <meta property="og:title" content="{{ $config['title'] }} | Luxe Home">
    <meta property="og:description" content="{{ $config['subtitle'] }}">
    <meta property="og:type" content="website">
    <meta name="robots" content="index, follow">
@endsection

@section('content')
<div class="bg-slate-50 min-h-screen">
    
    {{-- Header Dynamique --}}
    <header class="bg-white border-b border-slate-100 pt-32 pb-16">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <span class="text-indigo-600 font-bold uppercase tracking-[0.3em] text-[10px]">{{ __('messages.service_index_tag') }}</span>
            <h1 class="text-4xl md:text-6xl font-black text-slate-900 mt-4 tracking-tight">
                {{ $config['title'] }}
            </h1>
            <p class="text-slate-400 mt-6 max-w-2xl mx-auto font-medium italic">
                {{ $config['subtitle'] }}
            </p>
        </div>
    </header>

    <div class="max-w-7xl mx-auto py-12 px-6">
        @if($properties->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                @foreach($properties as $property)
                    @php
                        $mainImg = $property->images->where('is_main', true)->first() ?? $property->images->first();
                        $imagePath = $mainImg ? asset('uploads/properties/' . $mainImg->path) : 'https://via.placeholder.com/800x600';
                        
                        // Route avec locale et slug
                        $url = route('properties.show', [
                            'locale' => app()->getLocale(),
                            'slug_uuid' => $property->url_identifier
                        ]);
                    @endphp

                    <a href="{{ $url }}" class="group block bg-white rounded-[2.5rem] border border-slate-100 overflow-hidden hover:shadow-2xl transition-all duration-500">
                        <div class="relative h-64 overflow-hidden">
                            <img src="{{ $imagePath }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700" alt="{{ $property->title }}">
                            <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm text-indigo-600 text-[10px] px-3 py-1 rounded-full font-bold uppercase">
                                {{ $property->category->name }}
                            </div>
                        </div>

                        <div class="p-8">
                            <h3 class="text-xl font-bold text-slate-900 mb-2 truncate italic font-serif">{{ $property->title }}</h3>
                            <p class="text-slate-400 text-xs mb-6 italic">
                                <i class="fa-solid fa-location-dot mr-1 text-indigo-500"></i> {{ $property->details->city }}, {{ $property->details->country }}
                            </p>

                            <div class="flex items-center justify-between border-t border-slate-50 pt-6">
                                <div>
                                    <p class="text-2xl font-black text-slate-900">
                                        {{ number_format($property->price, 0, '.', ' ') }} <span class="text-sm font-bold text-indigo-500">€</span>
                                    </p>
                                    <p class="text-[10px] uppercase font-black text-slate-400 tracking-widest mt-1">
                                        {{-- Traduction du label de prix --}}
                                        @if($property->price_label === 'total')
                                            {{ __('messages.price_label_net') }}
                                        @else
                                            {{ __('messages.price_label_per') }} {{ __('messages.label_' . Str::slug($property->price_label)) }}
                                        @endif
                                    </p>
                                </div>
                                <div class="w-12 h-12 rounded-full bg-slate-900 flex items-center justify-center text-white group-hover:bg-indigo-600 transition-all">
                                    <i class="fa-solid fa-arrow-right"></i>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $properties->links() }}
            </div>
        @else
            <div class="text-center py-32 bg-white rounded-[3rem] border border-slate-100 shadow-sm">
                <p class="text-slate-400 font-bold text-xl italic">{{ __('messages.service_empty_state') }}</p>
            </div>
        @endif
    </div>
</div>
@endsection
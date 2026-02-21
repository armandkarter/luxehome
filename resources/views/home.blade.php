@extends('welcome')

@section('title', __('messages.home_meta_title'))

@section('meta_description')
    <meta name="description" content="{{ __('messages.home_meta_description') }}">
    <meta property="og:title" content="{{ __('messages.home_meta_title') }}">
    <meta property="og:description" content="{{ __('messages.home_meta_description') }}">
@endsection

@section('content')

{{-- HERO SECTION --}}
<section 
    x-data="{ loaded: false }" 
    x-init="setTimeout(() => loaded = true, 100)"
    class="hero-gradient min-h-screen md:h-[85vh] w-full flex items-center justify-center px-6 overflow-hidden relative"
>
    <div 
        x-show="loaded"
        x-transition:enter="transition ease-out duration-1000"
        x-transition:enter-start="opacity-0 translate-y-10"
        x-transition:enter-end="opacity-100 translate-y-0"
        class="text-center max-w-full md:max-w-5xl"
    >
        <h1 class="text-4xl sm:text-5xl md:text-7xl lg:text-8xl font-extrabold text-white mb-6 leading-[1.1] tracking-tight">
            {!! __('messages.home_hero_title') !!}
        </h1>
        <p class="text-white/80 text-lg md:text-2xl font-light max-w-3xl mx-auto leading-relaxed px-4">
            {{ __('messages.home_hero_subtitle') }}
        </p>
        <div class="mt-12 md:mt-16 animate-bounce">
            <i class="fa-solid fa-chevron-down text-white/30 text-2xl"></i>
        </div>
    </div>
</section>

{{-- CARDS SERVICES --}}
<section class="max-w-7xl mx-auto px-6 relative z-10 -mt-16">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        {{-- Card 1 --}}
        <div class="bg-white/90 backdrop-blur-xl p-8 rounded-[2.5rem] shadow-xl border border-white/50 hover:transform hover:-translate-y-2 transition duration-500">
            <div class="w-14 h-14 bg-amber-100 text-amber-600 rounded-2xl flex items-center justify-center text-2xl mb-6">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-900 mb-2">{{ __('messages.home_card_short_title') }}</h3>
            <p class="text-slate-500 text-sm leading-relaxed">{{ __('messages.home_card_short_desc') }}</p>
        </div>
        {{-- Card 2 --}}
        <div class="bg-white/90 backdrop-blur-xl p-8 rounded-[2.5rem] shadow-xl border border-white/50 hover:transform hover:-translate-y-2 transition duration-500">
            <div class="w-14 h-14 bg-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center text-2xl mb-6">
                <i class="fa-solid fa-couch"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-900 mb-2">{{ __('messages.home_card_rent_title') }}</h3>
            <p class="text-slate-500 text-sm leading-relaxed">{{ __('messages.home_card_rent_desc') }}</p>
        </div>
        {{-- Card 3 --}}
        <div class="bg-white/90 backdrop-blur-xl p-8 rounded-[2.5rem] shadow-xl border border-white/50 hover:transform hover:-translate-y-2 transition duration-500">
            <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl mb-6">
                <i class="fa-solid fa-key"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-900 mb-2">{{ __('messages.home_card_sale_title') }}</h3>
            <p class="text-slate-500 text-sm leading-relaxed">{{ __('messages.home_card_sale_desc') }}</p>
        </div>
    </div>
</section>

@include('partials.search')

{{-- MAIN CONTENT (CATÉGORIES) --}}
<main class="max-w-7xl mx-auto px-4 md:px-6 lg:px-8">
    @foreach($categories as $category)
        @if($category->properties->count() > 0)
        <section x-data="{
            showArrows: false,
            init() {
                this.updateArrows();
                window.addEventListener('resize', () => this.updateArrows());
            },
            updateArrows() {
                const slider = this.$refs.slider;
                this.showArrows = slider.scrollWidth > slider.clientWidth;
            },
            next() { this.$refs.slider.scrollBy({ left: 350, behavior: 'smooth' }) },
            prev() { this.$refs.slider.scrollBy({ left: -350, behavior: 'smooth' }) }
        }" x-init="init()" class="py-12">
            
            <div class="flex justify-between items-end mb-6">
                <div>
                    <div class="flex items-center gap-3 mb-1">
                        <div class="w-8 h-8 bg-indigo-50 rounded-lg flex items-center justify-center text-indigo-600">
                            <i class="fa-solid {{ $category->icon }}"></i>
                        </div>
                        {{-- On suppose ici que le nom de la catégorie est traduit en DB ou via messages --}}
                        <h2 class="text-2xl font-black text-slate-900">{{ $category->name }}</h2>
                    </div>
                    <p class="text-slate-500 text-sm">{{ __('messages.home_category_subtitle') }}</p>
                </div>

                <div class="hidden md:flex gap-2" x-show="showArrows">
                    <button @click="prev()" class="w-10 h-10 rounded-full border border-slate-200 flex items-center justify-center hover:bg-white hover:shadow-lg transition-all"><i class="fa-solid fa-chevron-left text-xs"></i></button>
                    <button @click="next()" class="w-10 h-10 rounded-full border border-slate-200 flex items-center justify-center hover:bg-white hover:shadow-lg transition-all"><i class="fa-solid fa-chevron-right text-xs"></i></button>
                </div>
            </div>

            <div x-ref="slider" class="flex gap-6 overflow-x-auto snap-x snap-mandatory scrollbar-hide pb-4">
                @foreach($category->properties as $property)
                    <x-property-card :property="$property" />
                @endforeach
            </div>
        </section>
        @endif
    @endforeach
</main>

{{-- SECTION RECHERCHE SUR MESURE / OFF-MARKET --}}
<section class="py-24 px-6 bg-slate-900 relative overflow-hidden mt-12">
    {{-- Effet de lumière discret en arrière-plan --}}
    <div class="absolute top-0 left-1/4 w-96 h-96 bg-indigo-500/10 rounded-full blur-[120px]"></div>
    
    <div class="max-w-7xl mx-auto relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            
            {{-- Texte --}}
            <div>
                <span class="text-indigo-400 font-bold uppercase tracking-[0.3em] text-[10px] mb-4 block">{{ __('messages.home_offmarket_tag') }}</span>
                <h2 class="text-4xl md:text-5xl font-black text-white mb-8 leading-tight italic font-serif">
                    {!! __('messages.home_offmarket_title') !!}
                </h2>
                <div class="space-y-6 text-slate-400 text-lg leading-relaxed mb-10">
                    <p>{{ __('messages.home_offmarket_p1') }}</p>
                    <p class="italic">{{ __('messages.home_offmarket_p2') }}</p>
                </div>
                
                <a href="{{ route('contact', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center gap-4 bg-white text-slate-900 px-10 py-5 rounded-2xl font-black uppercase tracking-widest hover:bg-indigo-50 transition-all shadow-xl group">
                    {{ __('messages.home_offmarket_btn') }}
                    <i class="fa-solid fa-arrow-right group-hover:translate-x-2 transition-transform"></i>
                </a>
            </div>

            {{-- Visuel Suggestif --}}
            <div class="relative group">
                <div class="aspect-square rounded-[4rem] overflow-hidden border border-white/10">
                    <img src="https://images.unsplash.com/photo-1510798831971-661eb04b3739?q=80&w=1000" 
                         alt="Luxury Secret Property" 
                         class="w-full h-full object-cover opacity-60 group-hover:scale-110 transition-duration-700">
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent"></div>
                
                <div class="absolute bottom-8 left-8 right-8 bg-white/5 backdrop-blur-md border border-white/10 p-6 rounded-3xl">
                    <p class="text-white font-bold text-sm italic">{{ __('messages.home_offmarket_quote') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- SECTION DESTINATIONS --}}
<section class="max-w-7xl mx-auto py-12 px-6">
    <div class="mb-8 flex justify-between items-end">
        <div>
            <span class="text-indigo-600 font-bold uppercase tracking-[0.3em] text-[10px]">{{ __('messages.home_dest_tag') }}</span>
            <h2 class="text-3xl md:text-4xl font-black text-slate-900 mt-2">
                {!! __('messages.home_dest_title') !!}
            </h2>
        </div>
        <div class="hidden md:block text-slate-400 text-[10px] font-bold uppercase tracking-widest">
            {{ __('messages.home_dest_label') }}
        </div>
    </div>

    <div class="flex md:grid overflow-x-auto md:overflow-visible gap-4 -mx-6 md:mx-0 px-6 md:px-0 scrollbar-hide snap-x snap-mandatory md:grid-cols-4 md:h-[550px]">
        @foreach($destinations as $index => $destination)
            @php 
                $secureSlug = \Illuminate\Support\Facades\Crypt::encryptString($destination->country); 
            @endphp
            <x-destination-card :destination="$destination" :index="$index" :link="route('destinations.show', ['locale' => app()->getLocale(), 'slug' => $secureSlug])"/>
        @endforeach
        <div class="md:hidden flex-shrink-0 w-6"></div>
    </div>
</section>

{{-- INCLUDES --}}
@include('partials.services')
@include('partials.testimonials')

{{-- CALL TO ACTION FINAL --}}
<section class="py-24 text-center bg-white">
    <div class="max-w-3xl mx-auto px-6">
        <h2 class="text-3xl font-black text-slate-900 mb-4">{{ __('messages.home_cta_title') }}</h2>
        <p class="text-slate-500 mb-8">{{ __('messages.home_cta_desc') }}</p>
        <a href="{{ route('contact', ['locale' => app()->getLocale()]) }}" class="inline-block px-10 py-4 bg-slate-900 text-white rounded-[1.5rem] font-bold hover:bg-indigo-600 hover:shadow-2xl hover:shadow-indigo-200 transition-all duration-300 transform hover:-translate-y-1">
            {{ __('messages.home_cta_btn') }}
        </a>
    </div>
</section>

@endsection
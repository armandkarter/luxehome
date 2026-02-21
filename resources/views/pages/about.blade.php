@extends('welcome')

@section('title', __('messages.about_seo_title'))

@section('meta_description')
    <meta name="description" content="{{ __('messages.about_seo_description') }}">
    <meta property="og:title" content="{{ __('messages.about_seo_title') }}">
    <meta property="og:description" content="{{ __('messages.about_seo_description') }}">
    <meta property="og:image" content="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=2000">
    <link rel="canonical" href="{{ url()->current() }}">
@endsection

@section('content')
<div class="bg-white">
    
    {{-- HERO SECTION --}}
    <section class="relative h-[70vh] flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=2000" class="w-full h-full object-cover" alt="Luxe Habitat Mansion">
            <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-[2px]"></div>
        </div>

        <div class="relative z-10 text-center px-6">
            <span class="text-indigo-400 font-black uppercase tracking-[0.5em] text-xs mb-4 block">{{ __('messages.about_hero_label') }}</span>
            <h1 class="text-5xl md:text-8xl font-black text-white tracking-tighter mb-6">
                {{ __('messages.about_hero_title_1') }} <br> 
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-300 to-white italic font-serif text-4xl md:text-7xl">
                    {{ __('messages.about_hero_title_2') }}
                </span>
            </h1>
            <p class="text-slate-200 max-w-2xl mx-auto text-lg md:text-xl font-medium leading-relaxed italic">
                "{{ __('messages.about_hero_subtitle') }}"
            </p>
        </div>

        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 animate-bounce">
            <i class="fa-solid fa-chevron-down text-white/50 text-xl"></i>
        </div>
    </section>

    {{-- NOTRE VISION --}}
    <section class="py-24 px-6 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
            <div>
                <span class="text-indigo-600 font-bold uppercase tracking-widest text-[10px]">{{ __('messages.about_vision_label') }}</span>
                <h2 class="text-4xl md:text-5xl font-black text-slate-900 mt-4 mb-8 leading-tight">
                    {!! __('messages.about_vision_title') !!}
                </h2>
                <div class="space-y-6 text-slate-500 leading-relaxed text-lg">
                    <p>{!! __('messages.about_vision_p1') !!}</p>
                    <p>{{ __('messages.about_vision_p2') }}</p>
                </div>
            </div>
            <div class="relative">
                <div class="aspect-[4/5] rounded-[3rem] overflow-hidden shadow-2xl rotate-3 hover:rotate-0 transition-transform duration-700">
                    <img src="https://images.unsplash.com/photo-1512917774080-9991f1c4c750?q=80&w=1000" class="w-full h-full object-cover" alt="Luxe Design">
                </div>
                <div class="absolute -bottom-10 -left-10 bg-indigo-600 text-white p-10 rounded-[2.5rem] shadow-xl hidden md:block">
                    <p class="text-4xl font-black italic">{{ __('messages.about_stats_value') }}</p>
                    <p class="text-[10px] uppercase tracking-widest font-bold opacity-80">{{ __('messages.about_stats_label') }}</p>
                </div>
            </div>
        </div>
    </section>

    {{-- NOS SERVICES (LES TROIS PILIERS) --}}
    <section class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-6 text-center mb-16">
            <h2 class="text-3xl md:text-5xl font-black text-slate-900 italic">{{ __('messages.about_pillars_title') }}</h2>
        </div>

        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- Vente --}}
            <div class="bg-white p-10 rounded-[3rem] border border-slate-100 hover:shadow-2xl transition-all group">
                <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-key text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-4 italic">{{ __('messages.about_pillar1_title') }}</h3>
                <p class="text-slate-500 text-sm leading-relaxed">{{ __('messages.about_pillar1_desc') }}</p>
            </div>

            {{-- Location --}}
            <div class="bg-white p-10 rounded-[3rem] border border-slate-100 hover:shadow-2xl transition-all group">
                <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-calendar-check text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-4 italic">{{ __('messages.about_pillar2_title') }}</h3>
                <p class="text-slate-500 text-sm leading-relaxed">{{ __('messages.about_pillar2_desc') }}</p>
            </div>

            {{-- Conciergerie --}}
            <div class="bg-white p-10 rounded-[3rem] border border-slate-100 hover:shadow-2xl transition-all group">
                <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mb-8 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-hand-holding-heart text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-4 italic">{{ __('messages.about_pillar3_title') }}</h3>
                <p class="text-slate-500 text-sm leading-relaxed">{{ __('messages.about_pillar3_desc') }}</p>
            </div>
        </div>
    </section>

    {{-- CTA SECTION --}}
    <section class="py-24 px-6">
        <div class="max-w-5xl mx-auto bg-slate-900 rounded-[4rem] p-12 md:p-20 text-center relative overflow-hidden shadow-2xl">
            <div class="absolute -top-20 -right-20 w-64 h-64 bg-indigo-600/20 rounded-full blur-3xl"></div>
            
            <h2 class="text-3xl md:text-5xl font-black text-white mb-8">{!! __('messages.about_cta_title') !!}</h2>
            
            <div class="flex flex-col md:flex-row gap-4 justify-center">
                <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" class="bg-white text-slate-900 px-10 py-5 rounded-2xl font-bold hover:bg-indigo-50 transition-all shadow-lg">
                    {{ __('messages.about_cta_btn_explore') }}
                </a>
                <a href="{{ route('contact', ['locale' => app()->getLocale()]) }}" class="border border-white/20 text-white px-10 py-5 rounded-2xl font-bold hover:bg-white/10 transition-all">
                    {{ __('messages.about_cta_btn_contact') }}
                </a>
            </div>
        </div>
    </section>
</div>
@endsection
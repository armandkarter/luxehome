@extends('welcome')

@section('title', __('messages.terms_seo_title'))

@push('meta_description')
    <meta name="description" content="{{ __('messages.terms_seo_description') }}">
    <meta property="og:title" content="{{ __('messages.terms_seo_title') }}">
    <meta property="og:description" content="{{ __('messages.terms_seo_description') }}">
    <link rel="canonical" href="{{ url()->current() }}">
@endpush

@section('content')
<div class="bg-white min-h-screen">
    {{-- Header de la page --}}
    <header class="pt-32 pb-16 bg-slate-50 border-b border-slate-100">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <span class="text-indigo-600 font-bold uppercase tracking-[0.3em] text-[10px]">{{ __('messages.terms_label') }}</span>
            <h1 class="text-4xl md:text-5xl font-black text-slate-900 mt-4 italic font-serif">{{ __('messages.terms_title') }}</h1>
            <p class="text-slate-400 mt-4 text-sm uppercase tracking-widest font-medium">{{ __('messages.terms_last_update') }}</p>
        </div>
    </header>

    <div class="max-w-4xl mx-auto px-6 py-20">
        <div class="prose prose-slate prose-lg max-w-none">
            
            {{-- Introduction --}}
            <section class="mb-16">
                <h2 class="text-2xl font-bold text-slate-900 mb-6 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-full bg-indigo-600 text-white text-xs flex items-center justify-center italic">01</span>
                    {{ __('messages.terms_section1_title') }}
                </h2>
                <p class="text-slate-600 leading-relaxed">
                    {!! __('messages.terms_section1_desc') !!}
                </p>
            </section>

            {{-- Services Spécifiques --}}
            <section class="mb-16 bg-slate-50 p-8 md:p-12 rounded-[3rem] border border-slate-100">
                <h2 class="text-2xl font-bold text-slate-900 mb-6 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-full bg-indigo-600 text-white text-xs flex items-center justify-center italic">02</span>
                    {{ __('messages.terms_section2_title') }}
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-sm">
                    <div>
                        <h3 class="font-bold text-indigo-600 uppercase mb-2">{{ __('messages.terms_service_sale_title') }}</h3>
                        <p class="text-slate-500">{{ __('messages.terms_service_sale_desc') }}</p>
                    </div>
                    <div>
                        <h3 class="font-bold text-indigo-600 uppercase mb-2">{{ __('messages.terms_service_rent_title') }}</h3>
                        <p class="text-slate-500">{{ __('messages.terms_service_rent_desc') }}</p>
                    </div>
                    <div>
                        <h3 class="font-bold text-indigo-600 uppercase mb-2">{{ __('messages.terms_service_book_title') }}</h3>
                        <p class="text-slate-500">{{ __('messages.terms_service_book_desc') }}</p>
                    </div>
                </div>
            </section>

            {{-- Données Personnelles --}}
            <section class="mb-16">
                <h2 class="text-2xl font-bold text-slate-900 mb-6 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-full bg-indigo-600 text-white text-xs flex items-center justify-center italic">03</span>
                    {{ __('messages.terms_section3_title') }}
                </h2>
                <p class="text-slate-600 leading-relaxed mb-4">
                    {!! __('messages.terms_section3_desc') !!}
                </p>
                <ul class="list-none space-y-3">
                    <li class="flex items-start gap-2 text-slate-500 italic"><i class="fa-solid fa-check text-indigo-500 mt-1"></i> {{ __('messages.terms_rgpd_item1') }}</li>
                    <li class="flex items-start gap-2 text-slate-500 italic"><i class="fa-solid fa-check text-indigo-500 mt-1"></i> {{ __('messages.terms_rgpd_item2') }}</li>
                    <li class="flex items-start gap-2 text-slate-500 italic"><i class="fa-solid fa-check text-indigo-500 mt-1"></i> {{ __('messages.terms_rgpd_item3') }}</li>
                </ul>
            </section>

            {{-- Responsabilité --}}
            <section class="mb-16">
                <h2 class="text-2xl font-bold text-slate-900 mb-6 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-full bg-indigo-600 text-white text-xs flex items-center justify-center italic">04</span>
                    {{ __('messages.terms_section4_title') }}
                </h2>
                <p class="text-slate-600 leading-relaxed">
                    {{ __('messages.terms_section4_desc') }}
                </p>
            </section>

            {{-- Contact Juridique --}}
            <footer class="mt-20 pt-10 border-t border-slate-100 text-center">
                <p class="text-slate-400 text-sm">
                    {{ __('messages.terms_footer_text') }} <br>
                    <a href="mailto:support@luxhome.com" class="text-indigo-600 font-bold hover:underline">support@luxhome.com</a>
                </p>
            </footer>
        </div>
    </div>
</div>
@endsection
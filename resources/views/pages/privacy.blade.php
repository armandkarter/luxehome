@extends('welcome')

@section('title', __('messages.privacy_seo_title'))

@push('meta_description')
    <meta name="description" content="{{ __('messages.privacy_seo_description') }}">
    <meta property="og:title" content="{{ __('messages.privacy_seo_title') }}">
    <meta property="og:description" content="{{ __('messages.privacy_seo_description') }}">
    <link rel="canonical" href="{{ url()->current() }}">
@endpush

@section('content')
<div class="bg-white min-h-screen">
    {{-- Header Minimaliste --}}
    <header class="pt-32 pb-16 bg-indigo-900">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <span class="text-indigo-300 font-bold uppercase tracking-[0.3em] text-[10px]">{{ __('messages.privacy_label') }}</span>
            <h1 class="text-4xl md:text-5xl font-black text-white mt-4 italic font-serif">{{ __('messages.privacy_title') }}</h1>
            <p class="text-indigo-200/60 mt-4 text-sm uppercase tracking-widest font-medium">{{ __('messages.privacy_subtitle') }}</p>
        </div>
    </header>

    <div class="max-w-4xl mx-auto px-6 py-20">
        <div class="prose prose-slate prose-lg max-w-none">
            
            {{-- Introduction --}}
            <section class="mb-16 border-l-4 border-indigo-600 pl-8">
                <p class="text-slate-600 leading-relaxed italic text-xl">
                    "{{ __('messages.privacy_intro_text') }}"
                </p>
            </section>

            {{-- Collecte des données --}}
            <section class="mb-16">
                <h2 class="text-2xl font-bold text-slate-900 mb-6 uppercase tracking-tight">{{ __('messages.privacy_section1_title') }}</h2>
                <p class="text-slate-600 mb-6">{{ __('messages.privacy_section1_desc') }}</p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100">
                        <span class="font-bold text-indigo-600 block mb-2">{{ __('messages.privacy_data_identity_title') }}</span>
                        <p class="text-sm text-slate-500">{{ __('messages.privacy_data_identity_desc') }}</p>
                    </div>
                    <div class="p-6 bg-slate-50 rounded-2xl border border-slate-100">
                        <span class="font-bold text-indigo-600 block mb-2">{{ __('messages.privacy_data_project_title') }}</span>
                        <p class="text-sm text-slate-500">{{ __('messages.privacy_data_project_desc') }}</p>
                    </div>
                </div>
            </section>

            {{-- Utilisation des données --}}
            <section class="mb-16">
                <h2 class="text-2xl font-bold text-slate-900 mb-6 uppercase tracking-tight">{{ __('messages.privacy_section2_title') }}</h2>
                <p class="text-slate-600 mb-4">{{ __('messages.privacy_section2_desc') }}</p>
                <ul class="space-y-4">
                    <li class="flex gap-4 items-start">
                        <div class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 flex-shrink-0 flex items-center justify-center text-xs mt-1">1</div>
                        <span class="text-slate-500">{{ __('messages.privacy_usage_item1') }}</span>
                    </li>
                    <li class="flex gap-4 items-start">
                        <div class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 flex-shrink-0 flex items-center justify-center text-xs mt-1">2</div>
                        <span class="text-slate-500">{{ __('messages.privacy_usage_item2') }}</span>
                    </li>
                    <li class="flex gap-4 items-start">
                        <div class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 flex-shrink-0 flex items-center justify-center text-xs mt-1">3</div>
                        <span class="text-slate-500">{{ __('messages.privacy_usage_item3') }}</span>
                    </li>
                </ul>
            </section>

            {{-- Sécurité --}}
            <section class="mb-16 bg-slate-900 text-white p-10 md:p-16 rounded-[3rem] shadow-xl">
                <h2 class="text-2xl font-bold mb-6 italic font-serif">{{ __('messages.privacy_security_title') }}</h2>
                <p class="text-slate-300 leading-relaxed mb-6">
                    {{ __('messages.privacy_security_desc') }}
                </p>
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-white/10 rounded-full border border-white/20 text-xs font-bold tracking-widest uppercase">
                    <i class="fa-solid fa-shield-halved text-indigo-400"></i> {{ __('messages.privacy_security_badge') }}
                </div>
            </section>

            {{-- Vos Droits --}}
            <section class="mb-16">
                <h2 class="text-2xl font-bold text-slate-900 mb-6 uppercase tracking-tight">{{ __('messages.privacy_section3_title') }}</h2>
                <p class="text-slate-600">{{ __('messages.privacy_section3_desc') }}</p>
                <p class="text-slate-600 mt-4 font-bold italic">{{ __('messages.privacy_section3_contact') }}</p>
            </section>

        </div>
    </div>
</div>
@endsection
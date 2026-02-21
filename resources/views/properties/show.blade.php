@extends('welcome')

@section('title', $property->title . ' – LuxeHome')

@section('content')

{{-- Préparation de l'image initiale en PHP pour Alpine.js --}}
@php
    $firstImage = $property->images->where('is_main', true)->first() ?? $property->images->first();
    $initialUrl = $firstImage ? asset('uploads/properties/' . $firstImage->path) : asset('assets/img/placeholder.jpg');
@endphp

<main class="max-w-7xl mx-auto py-12 px-6 mt-20" 
      x-data="{ activeImage: '{{ $initialUrl }}', openModal: false, typeAction: '' }">
    
    {{-- En-tête : Titre et Localisation --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-8 gap-4">
        <div>
            <div class="flex items-center gap-2 mb-3">
                <span class="bg-indigo-100 text-indigo-700 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-widest">
                    {{ $property->category->name }}
                </span>
                <span class="bg-slate-100 text-slate-700 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-widest">
                    {{ $property->offer_type }}
                </span>
            </div>
            <h1 class="text-4xl md:text-5xl font-black text-slate-900">{{ $property->title }}</h1>
            <p class="text-slate-500 flex items-center mt-3 text-lg">
                <i class="fa-solid fa-location-dot mr-2 text-indigo-500"></i> 
                {{ $property->details?->address }}, {{ $property->details?->city }}
            </p>
        </div>
        <div class="text-left md:text-right">
            <p class="text-slate-400 font-bold text-sm uppercase tracking-tighter">{{ __('messages.show_price_label') }}</p>
            <p class="text-4xl font-black text-indigo-600">
                {{ number_format($property->price, 0, '.', ' ') }} <span class="text-lg">€</span>
                <span class="text-slate-400 text-sm font-medium">/ {{ $property->price_label }}</span>
            </p>
        </div>
    </div>

    {{-- Galerie d'images Interactive --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-16">
        <div class="lg:col-span-9">
            <div class="relative h-[400px] md:h-[600px] w-full overflow-hidden rounded-[3rem] shadow-2xl bg-slate-100">
                <img :src="activeImage" 
                     class="w-full h-full object-cover transition-all duration-700 ease-in-out" 
                     id="main-visual">
                
                {{-- Badge de Note --}}
                <div class="absolute top-6 left-6 bg-white/90 backdrop-blur-md px-4 py-2 rounded-2xl flex items-center gap-3 shadow-xl">
                    <span class="text-2xl font-black text-indigo-600">8.9</span>
                    <div class="flex flex-col">
                        <span class="text-[10px] font-bold text-slate-400 uppercase">{{ __('messages.show_rating_label') }}</span>
                        <span class="text-xs font-bold text-slate-900 uppercase">{{ __('messages.show_rating_value') }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- Miniatures (Sidebar Gallery) --}}
        <div class="lg:col-span-3 flex lg:flex-col gap-4 overflow-x-auto lg:overflow-y-auto max-h-[600px] pb-4 scrollbar-hide">
            @foreach($property->images as $image)
            @php $url = asset('uploads/properties/' . $image->path); @endphp
            <div @click="activeImage = '{{ $url }}'" 
                 class="relative flex-shrink-0 w-24 h-24 lg:w-full lg:h-40 rounded-[2rem] overflow-hidden cursor-pointer border-4 transition-all duration-300"
                 :class="activeImage === '{{ $url }}' ? 'border-indigo-500 scale-95 shadow-lg' : 'border-transparent hover:border-slate-200'">
                <img src="{{ $url }}" class="w-full h-full object-cover">
            </div>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-16">
        {{-- Contenu Principal --}}
        <div class="lg:col-span-2 space-y-12">
            
            {{-- Grille des Caractéristiques --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 p-8 bg-slate-50 rounded-[3rem]">
                <div class="space-y-1">
                    <i class="fa-solid fa-maximize text-indigo-500 text-xl mb-2"></i>
                    <p class="text-xs font-bold text-slate-400 uppercase">{{ __('messages.show_feat_surface') }}</p>
                    <p class="text-lg font-black text-slate-900">{{ $property->details?->area }} m²</p>
                </div>
                <div class="space-y-1">
                    <i class="fa-solid fa-bed text-indigo-500 text-xl mb-2"></i>
                    <p class="text-xs font-bold text-slate-400 uppercase">{{ __('messages.show_feat_rooms') }}</p>
                    <p class="text-lg font-black text-slate-900">{{ $property->details?->bedrooms }}</p>
                </div>
                <div class="space-y-1">
                    <i class="fa-solid fa-bath text-indigo-500 text-xl mb-2"></i>
                    <p class="text-xs font-bold text-slate-400 uppercase">{{ __('messages.show_feat_baths') }}</p>
                    <p class="text-lg font-black text-slate-900">{{ $property->details?->bathrooms }}</p>
                </div>
                <div class="space-y-1">
                    <i class="fa-solid fa-couch text-indigo-500 text-xl mb-2"></i>
                    <p class="text-xs font-bold text-slate-400 uppercase">{{ __('messages.show_feat_status') }}</p>
                    <p class="text-lg font-black text-green-600">{{ $property->status }}</p>
                </div>
            </div>

            {{-- Description --}}
            <section>
                <h2 class="text-3xl font-black text-slate-900 mb-6">{{ __('messages.show_desc_title') }}</h2>
                <div class="prose prose-slate max-w-none">
                    <p class="text-slate-600 leading-relaxed text-lg italic border-l-4 border-indigo-500 pl-6">
                        {{ $property->details?->description }}
                    </p>
                </div>
            </section>

            {{-- Commodités --}}
            @if($property->details?->amenities)
            <section>
                <h2 class="text-3xl font-black text-slate-900 mb-6">{{ __('messages.show_amenities_title') }}</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($property->details->amenities as $amenity)
                    <div class="flex items-center p-4 bg-white border border-slate-100 rounded-2xl shadow-sm hover:shadow-md transition">
                        <div class="w-10 h-10 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center mr-4">
                            <i class="fa-solid fa-check text-sm"></i>
                        </div>
                        <span class="font-bold text-slate-700">{{ $amenity }}</span>
                    </div>
                    @endforeach
                </div>
            </section>
            @endif
        </div>

        {{-- Sidebar de Contact --}}
        <div class="lg:col-span-1">
            <div class="sticky top-28 space-y-6">
                <div class="p-8 bg-slate-900 rounded-[3rem] shadow-2xl text-white">
                    <h3 class="text-2xl font-bold mb-4">{{ __('messages.show_sidebar_interest_title') }}</h3>
                    <p class="text-slate-400 text-sm mb-8 leading-relaxed">
                        {!! __('messages.show_sidebar_protocol_desc') !!}
                    </p>
                    
                    <div class="space-y-4">
                        <a href="#conditions-section" 
                           class="w-full py-5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-2xl font-bold transition flex items-center justify-center gap-3 shadow-lg shadow-indigo-500/20">
                            <i class="fa-solid fa-file-shield text-xl"></i>
                            {{ __('messages.show_sidebar_btn_modalities') }}
                        </a>

                        <a href="#conditions-section" 
                           class="w-full py-5 bg-white text-slate-900 border border-slate-200 rounded-2xl font-bold hover:bg-slate-50 transition flex items-center justify-center gap-3">
                            <i class="fa-solid fa-calendar-day"></i>
                            {{ __('messages.show_sidebar_btn_visit') }}
                        </a>
                    </div>

                    <hr class="my-8 border-slate-800">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl bg-slate-800 overflow-hidden">
                            <img src="https://ui-avatars.com/api/?name=Luxe+Habitat&background=6366f1&color=fff" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <p class="font-bold text-sm">{{ __('messages.show_sidebar_service_name') }}</p>
                            <p class="text-[10px] text-slate-400 font-medium tracking-widest uppercase text-nowrap">{{ __('messages.show_sidebar_availability') }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="p-6 bg-indigo-50 rounded-3xl border border-indigo-100">
                    <p class="text-indigo-900 text-sm font-medium leading-relaxed">
                        <i class="fa-solid fa-shield-halved mr-2"></i> {{ __('messages.show_sidebar_guarantee_text') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- SECTION CONDITIONS INSTITUTIONNELLES --}}
    <section id="conditions-section" 
            x-data="{ 
                price: {{ $property->price }},
                formatPrice(value) {
                    return new Intl.NumberFormat('fr-FR').format(value);
                }
            }"
            class="mt-16 p-8 md:p-12 bg-white border border-slate-200 rounded-[3rem] shadow-sm">
        
        <div class="max-w-4xl mx-auto">
            <h2 class="text-3xl font-black text-slate-900 mb-2">{{ __('messages.show_conditions_title') }}</h2>
            <p class="text-slate-500 mb-10 text-lg font-medium">{{ __('messages.show_conditions_subtitle') }}</p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <div class="space-y-8">
                    <div class="flex gap-4">
                        <div class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-id-card text-indigo-600 text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-black text-slate-900 uppercase text-sm tracking-widest mb-2">{{ __('messages.show_conditions_kyc_title') }}</h4>
                            <p class="text-sm text-slate-600 leading-relaxed">{{ __('messages.show_conditions_kyc_text') }}</p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="w-12 h-12 bg-amber-50 rounded-2xl flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-calendar-check text-amber-600 text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-black text-slate-900 uppercase text-sm tracking-widest mb-2">{{ __('messages.show_conditions_protocol_title') }}</h4>
                            <p class="text-sm text-slate-600 leading-relaxed">{!! __('messages.show_conditions_protocol_text') !!}</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-8">
                    <div class="flex gap-4">
                        <div class="w-12 h-12 bg-indigo-50 rounded-2xl flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-bank text-indigo-600 text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-black text-slate-900 uppercase text-sm tracking-widest mb-2">{{ __('messages.show_conditions_payment_title') }}</h4>
                            <p class="text-sm text-slate-600 leading-relaxed">{!! __('messages.show_conditions_payment_text') !!}</p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="w-12 h-12 bg-red-50 rounded-2xl flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-handshake-slash text-red-600 text-xl"></i>
                        </div>
                        <div>
                            <h4 class="font-black text-slate-900 uppercase text-sm tracking-widest mb-2">{{ __('messages.show_conditions_cancel_title') }}</h4>
                            <p class="text-sm text-slate-600 leading-relaxed">{{ __('messages.show_conditions_cancel_text') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            @if($property->offer_type == 'Location')
            <div class="mt-12 p-8 bg-slate-50 border border-slate-100 rounded-[2.5rem]">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-2 h-8 bg-indigo-600 rounded-full"></div>
                    <h4 class="font-black text-slate-900 uppercase text-sm tracking-widest">{{ __('messages.show_conditions_sim_title') }}</h4>
                </div>
                
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                        <p class="text-[10px] font-black uppercase text-slate-400 mb-2 tracking-tighter">{{ __('messages.show_conditions_sim_advance') }}</p>
                        <p class="text-xl font-black text-slate-900" x-text="formatPrice(price * 3) + ' €'"></p>
                    </div>
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-amber-200 relative overflow-hidden">
                        <div class="absolute top-0 right-0 bg-amber-400 text-[8px] font-black text-white px-3 py-1 rounded-bl-lg uppercase">{{ __('messages.show_conditions_sim_refundable') }}</div>
                        <p class="text-[10px] font-black uppercase text-slate-400 mb-2 tracking-tighter">{{ __('messages.show_conditions_sim_deposit') }}</p>
                        <p class="text-xl font-black text-slate-900" x-text="formatPrice(price) + ' €'"></p>
                    </div>
                    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
                        <p class="text-[10px] font-black uppercase text-slate-400 mb-2 tracking-tighter">{{ __('messages.show_conditions_sim_fees') }}</p>
                        <p class="text-xl font-black text-slate-900" x-text="formatPrice(price) + ' €'"></p>
                    </div>
                </div>

                <div class="mt-8 pt-8 border-t border-slate-200 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div>
                        <p class="text-xs font-black text-indigo-600 uppercase tracking-[0.2em] mb-1">{{ __('messages.show_conditions_sim_total') }}</p>
                        <p class="text-4xl font-black text-slate-900" x-text="formatPrice(price * 5) + ' €'"></p>
                    </div>
                    <div class="text-right sm:max-w-xs">
                        <p class="text-[10px] text-slate-400 italic leading-relaxed">
                            {{ __('messages.show_conditions_sim_note') }}
                        </p>
                    </div>
                </div>
            </div>
            @endif

            <div class="mt-12 p-6 bg-slate-900 rounded-[2.5rem] text-white flex items-center gap-6">
                <div class="hidden sm:flex w-14 h-14 bg-white/10 rounded-full items-center justify-center flex-shrink-0">
                    <i class="fa-solid fa-circle-exclamation text-xl"></i>
                </div>
                <div class="flex-1">
                    <h5 class="font-bold text-lg mb-0.5">{{ __('messages.show_conditions_note_title') }}</h5>
                    <p class="text-slate-400 text-sm italic">
                        {{ __('messages.show_conditions_note_text') }}
                    </p>
                </div>
            </div>

            <div class="mt-12 pt-12 border-t border-slate-100 flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <h4 class="text-xl font-black text-slate-900">{{ __('messages.show_conditions_ready_title') }}</h4>
                    <p class="text-slate-500">{{ __('messages.show_conditions_ready_subtitle') }}</p>
                </div>
                
                <div class="flex gap-4 w-full md:w-auto">
                    @if($property->offer_type == 'Vente')
                        <button @click="openModal = true; typeAction = 'Vente'" 
                                class="w-full md:w-auto px-10 py-5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-bold transition-all shadow-xl shadow-indigo-100">
                            {{ __('messages.show_conditions_btn_buy') }}
                        </button>
                    @else
                        <button @click="openModal = true; typeAction = '{{ $property->offer_type }}'" 
                            class="w-full md:w-auto px-10 py-5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-bold transition-all shadow-xl shadow-indigo-100">
                            {{ $property->offer_type == 'Réservation' ? __('messages.show_conditions_btn_book_now') : __('messages.show_conditions_btn_rent') }}
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- Section Biens Similaires --}}
    @if(isset($similarProperties) && $similarProperties->count() > 0)
    <section class="mt-20 pt-20 border-t border-slate-100">
        <div class="flex justify-between items-end mb-10">
            <div>
                <h2 class="text-3xl font-black text-slate-900">{{ __('messages.show_similar_title') }}</h2>
                <p class="text-slate-500 mt-2">
                    {{ __('messages.show_similar_subtitle') }} <span class="text-indigo-600 font-bold">{{ $property->category->name }}</span>.
                </p>
            </div>
            <a href="{{ route('categories.show', ['locale' => app()->getLocale(), 'slug' => $property->category->slug]) }}" class="hidden md:block text-indigo-600 font-bold hover:underline">
                {{ __('messages.show_similar_view_all') }} <i class="fa-solid fa-arrow-right ml-2"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($similarProperties as $similar)
            <div class="group bg-white rounded-[2.5rem] border border-slate-100 overflow-hidden hover:shadow-2xl transition-all duration-500">
                <a href="{{ route('properties.show', ['locale' => app()->getLocale(), 'slug_uuid' => $similar->url_identifier]) }}" class="block">
                    <div class="relative h-64 overflow-hidden">
                        <img src="{{ asset('uploads/properties/' . ($similar->images->where('is_main', true)->first()->path ?? $similar->images->first()->path)) }}" 
                                class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                    </div>
                    <div class="p-6">
                        <h3 class="font-bold text-lg text-slate-900 group-hover:text-indigo-600 transition-colors">{{ $similar->title }}</h3>
                        <p class="text-indigo-600 font-black mt-2">{{ number_format($similar->price, 0, '.', ' ') }} €</p>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- Modal de capture de données --}}
<div x-show="openModal" 
     class="fixed inset-0 z-[60] overflow-y-auto flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
     x-cloak>
    
    <div @click.away="openModal = false" 
         class="bg-white rounded-[3rem] max-w-lg w-full p-10 shadow-2xl relative border border-slate-100">
        
        <button @click="openModal = false" class="absolute top-8 right-8 text-slate-400 hover:text-slate-600 transition">
            <i class="fa-solid fa-xmark text-2xl"></i>
        </button>

        <div class="mb-8">
            <h3 class="text-3xl font-black text-slate-900 mb-2 leading-tight">
                <span x-show="typeAction == 'Vente'">{{ __('messages.show_modal_title_buy') }}</span>
                <span x-show="typeAction != 'Vente'">{{ __('messages.show_modal_title_res') }}</span>
            </h3>
        </div>

        <div x-data="inquiryHandler()">
    {{-- État 1 : Message de succès après envoi --}}
    <div x-show="submitted" x-transition:enter="transition ease-out duration-500" 
         x-transition:enter-start="opacity-0 transform scale-90" 
         class="p-10 bg-indigo-50 rounded-[3rem] text-center border border-indigo-100">
        <div class="w-20 h-20 bg-indigo-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg shadow-indigo-200">
            <i class="fa-solid fa-check text-3xl text-white"></i>
        </div>
        <h3 class="text-2xl font-black text-slate-900 mb-2">{{ __('messages.show_modal_success_title') }}</h3>
        <p class="text-slate-600 leading-relaxed">
            {{ __('messages.show_modal_success_text') }}
        </p>
    </div>

    {{-- État 2 : Le Formulaire --}}
    <form x-show="!submitted" @submit.prevent="submitForm" class="space-y-5">
        @csrf
        <input type="hidden" name="typeAction" :value="typeAction">
        
        <div class="grid grid-cols-1 gap-5">
            <div>
                <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2 ml-2">{{ __('messages.show_modal_label_name') }}</label>
                <input type="text" x-model="formData.name" placeholder="{{ __('messages.show_modal_ph_name') }}" required 
                        class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:ring-2 focus:ring-indigo-500 transition">
            </div>

            <div>
                <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2 ml-2">{{ __('messages.show_modal_label_email') }}</label>
                <input type="email" x-model="formData.email" placeholder="{{ __('messages.show_modal_ph_email') }}" required 
                        class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:ring-2 focus:ring-indigo-500 transition">
            </div>

            <template x-if="typeAction == 'Location'">
                <div class="grid grid-cols-2 gap-4" x-transition>
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2 ml-2">{{ __('messages.show_modal_label_visit_date') }}</label>
                        <input type="date" x-model="formData.visit_date" :required="typeAction == 'Location'" :min="new Date().toISOString().split('T')[0]"
                        class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:ring-2 focus:ring-indigo-500 transition text-sm">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2 ml-2">{{ __('messages.show_modal_label_slot') }}</label>
                        <select x-model="formData.visit_time" class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:ring-2 focus:ring-indigo-500 transition text-sm font-bold">
                            <option value="Matin (09h - 12h)">{{ __('messages.show_modal_slot_morning') }}</option>
                            <option value="Après-midi (14h - 17h)">{{ __('messages.show_modal_slot_afternoon') }}</option>
                            <option value="Soirée (17h - 19h)">{{ __('messages.show_modal_slot_evening') }}</option>
                        </select>
                    </div>
                </div>
            </template>
            <template x-if="typeAction == 'Réservation'">
                <div class="space-y-5" x-transition>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2 ml-2">{{ __('messages.show_modal_label_arrival') }}</label>
                            <input type="date" x-model="formData.arrival_date" :required="typeAction == 'Réservation'" :min="new Date().toISOString().split('T')[0]"
                            class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:ring-2 focus:ring-indigo-500 transition text-sm">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2 ml-2">{{ __('messages.show_modal_label_nights') }}</label>
                            <input type="number" x-model="formData.nights" min="1" :required="typeAction == 'Réservation'" 
                            class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:ring-2 focus:ring-indigo-500 transition text-sm font-bold">
                        </div>
                    </div>
            
                    <div class="p-6 bg-slate-900 rounded-[2rem] flex justify-between items-center shadow-inner">
                        <div>
                            <p class="text-[10px] font-black text-indigo-400 uppercase tracking-widest">{{ __('messages.show_modal_est_title') }}</p>
                            <p class="text-white text-xs opacity-60" x-text="formData.nights + ' {{ __('messages.show_modal_est_nights') }}'"></p>
                        </div>
                        <div class="text-right">
                            <span class="text-2xl font-black text-white" x-text="formatPrice(formData.price * formData.nights) + '€'"></span>
                        </div>
                    </div>
                </div>
            </template>
            <template x-if="typeAction != 'Vente'">
                <div class="space-y-5" x-transition>
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2 ml-2">{{ __('messages.show_modal_label_id') }}</label>
                        <input type="text" x-model="formData.id_card" required 
                        class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:ring-2 focus:ring-indigo-500 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-widest text-slate-400 mb-2 ml-2">{{ __('messages.show_modal_label_phone') }}</label>
                        <input type="tel" x-model="formData.phone" placeholder="+33 ..." required
                        class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:ring-2 focus:ring-indigo-500 transition">
                    </div>
                </div>
            </template>

            <template x-if="typeAction == 'Vente'">
                <div class="space-y-5" x-transition>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-widest text-slate-400 mb-2 ml-2">{{ __('messages.show_modal_label_phone') }}</label>
                        <input type="tel" x-model="formData.phone" placeholder="+33 ..." required
                        class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:ring-2 focus:ring-indigo-500 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-widest text-slate-400 mb-2 ml-2">{{ __('messages.show_modal_label_message') }}</label>
                        <textarea name="message" id="message" x-model="formData.message" placeholder="{{ __('messages.show_modal_ph_message') }}" required class="w-full px-6 py-4 bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:ring-2 focus:ring-indigo-500 transition"></textarea>
                    </div>
                </div>
            </template>
        </div>

        <button type="submit" 
                :disabled="loading"
                class="w-full py-5 bg-indigo-600 text-white rounded-2xl font-black uppercase tracking-widest text-sm shadow-xl shadow-indigo-100 hover:bg-indigo-700 transition flex items-center justify-center gap-3 disabled:opacity-70">
            <span x-show="!loading">{{ __('messages.show_modal_btn_confirm') }}</span>
            <span x-show="loading" class="flex items-center gap-2">
                <i class="fa-solid fa-circle-notch animate-spin"></i> {{ __('messages.show_modal_btn_loading') }}
            </span>
        </button>
    </form>
</div>
    </div>
</div>
</main>

<style>
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<script>
function inquiryHandler() {
    return {
        loading: false,
        submitted: false,
        formData: {
            name: '',
            email: '',
            visit_date: '',
            visit_time: 'Matin (09h - 12h)',
            id_card: '',
            phone: '',
            arrival_date: '', // Important pour la Réservation
            nights: 1,
            message: '',
            price: {{ $property->price }},
        },

        formatPrice(price) {
            if (!price) return '0';
            return new Intl.NumberFormat('fr-FR').format(price);
        },

        async submitForm() {
            this.loading = true;

            // On ajoute le typeAction qui vient de la variable Alpine globale
            this.formData.typeAction = this.typeAction;

            try {
                const response = await fetch("{{ route('property.inquiry', ['locale' => app()->getLocale(), 'id' => $property->id]) }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(this.formData)
                });

                if (response.ok) {
                    this.submitted = true;
                } else {
                    alert("Une erreur est survenue. Veuillez vérifier vos informations.");
                }
            } catch (error) {
                console.error("Erreur lors de l'envoi :", error);
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>
@endsection
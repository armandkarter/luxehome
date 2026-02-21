@extends('welcome')

@section('title', __('messages.contact_seo_title'))

@push('meta_description')
    <meta name="description" content="{{ __('messages.contact_seo_description') }}">
    <link rel="canonical" href="{{ url()->current() }}">
@endpush

@section('content')
<div class="bg-slate-50 min-h-screen pt-24 md:pt-32 pb-12 md:pb-20" 
     x-data="{ 
        loading: false, 
        sent: false,
        formData: {
            name: '',
            email: '',
            subject: 'achat',
            message: ''
        },
        async submitForm() {
            this.loading = true;
            try {
                const response = await fetch('{{ route('contact.submit', ['locale' => app()->getLocale()]) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(this.formData)
                });

                if (response.ok) {
                    this.sent = true;
                    this.formData = { name: '', email: '', subject: 'achat', message: '' };
                } else {
                    const errorData = await response.json();
                    alert('Erreur : ' + Object.values(errorData.errors).flat().join('\n'));
                }
            } catch (e) {
                console.error(e);
                alert('{{ __('messages.contact_error_server') }}');
            } finally {
                this.loading = false;
            }
        }
     }">
    
    <div class="max-w-7xl mx-auto px-4 md:px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-start">
            
            {{-- COLONNE GAUCHE : INFOS --}}
            <div class="space-y-8 md:space-y-12 text-center lg:text-left">
                <div>
                    <span class="text-indigo-600 font-bold uppercase tracking-[0.3em] text-[10px]">{{ __('messages.contact_label') }}</span>
                    <h1 class="text-4xl md:text-6xl lg:text-7xl font-black text-slate-900 mt-4 tracking-tighter italic leading-tight">
                        {{ __('messages.contact_title_1') }} <br> <span class="text-indigo-400">{{ __('messages.contact_title_2') }}</span>.
                    </h1>
                    <p class="text-slate-500 mt-6 md:mt-8 text-base md:text-lg leading-relaxed max-w-md mx-auto lg:mx-0 italic">
                        {{ __('messages.contact_subtitle') }}
                    </p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 md:gap-8">
                    <div class="bg-white p-6 md:p-8 rounded-[2rem] border border-slate-100 shadow-sm">
                        <div class="w-10 h-10 md:w-12 md:h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center mb-4 mx-auto lg:mx-0">
                            <i class="fa-solid fa-phone text-sm"></i>
                        </div>
                        <p class="text-[9px] md:text-[10px] font-black uppercase text-slate-400 tracking-widest text-center lg:text-left">{{ __('messages.contact_info_phone_label') }}</p>
                        <p class="text-base md:text-lg font-bold text-slate-900 mt-1 text-center lg:text-left">+33 1 23 45 67 89</p>
                    </div>

                    <div class="bg-white p-6 md:p-8 rounded-[2rem] border border-slate-100 shadow-sm">
                        <div class="w-10 h-10 md:w-12 md:h-12 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center mb-4 mx-auto lg:mx-0">
                            <i class="fa-solid fa-envelope text-sm"></i>
                        </div>
                        <p class="text-[9px] md:text-[10px] font-black uppercase text-slate-400 tracking-widest text-center lg:text-left">{{ __('messages.contact_info_email_label') }}</p>
                        <p class="text-base md:text-lg font-bold text-slate-900 mt-1 text-center lg:text-left break-words">support@luxhome.com</p>
                    </div>
                </div>

                <div class="flex items-center justify-center lg:justify-start gap-4 md:gap-6">
                    <a href="#" class="w-12 h-12 rounded-full bg-slate-900 text-white flex items-center justify-center hover:bg-indigo-600 transition-all shadow-lg active:scale-90">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="#" class="w-12 h-12 rounded-full bg-slate-900 text-white flex items-center justify-center hover:bg-indigo-600 transition-all shadow-lg active:scale-90">
                        <i class="fa-brands fa-linkedin-in"></i>
                    </a>
                    <a href="#" class="w-12 h-12 rounded-full bg-slate-900 text-white flex items-center justify-center hover:bg-indigo-600 transition-all shadow-lg active:scale-90">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                </div>
            </div>

            {{-- COLONNE DROITE : FORMULAIRE --}}
            <div class="bg-white rounded-[2.5rem] md:rounded-[3.5rem] p-6 md:p-10 lg:p-12 shadow-2xl shadow-slate-200 border border-white relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 md:w-32 md:h-32 bg-indigo-50 rounded-bl-[4rem] -z-0"></div>
                
                {{-- UI Message de Succès --}}
                <div x-show="sent" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 scale-90" class="relative z-10 text-center py-10 md:py-20">
                    <div class="w-20 h-20 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fa-solid fa-check text-3xl"></i>
                    </div>
                    <h3 class="text-2xl md:text-3xl font-black text-slate-900 italic">{{ __('messages.contact_success_title') }}</h3>
                    <p class="text-slate-500 mt-4 max-w-xs mx-auto">{{ __('messages.contact_success_text') }}</p>
                    <button @click="sent = false" class="mt-8 text-indigo-600 font-bold uppercase tracking-widest text-xs hover:underline">{{ __('messages.contact_btn_again') }}</button>
                </div>

                {{-- Formulaire --}}
                <form x-show="!sent" @submit.prevent="submitForm()" class="relative z-10 space-y-5 md:space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="space-y-2">
                            <label class="text-[9px] font-black uppercase text-slate-400 ml-2 tracking-widest">{{ __('messages.contact_field_name') }}</label>
                            <input type="text" x-model="formData.name" required placeholder="{{ __('messages.contact_ph_name') }}" 
                                   class="w-full px-5 py-3 md:py-4 rounded-xl bg-slate-50 border border-slate-100 focus:border-indigo-500 outline-none transition">
                        </div>
                        <div class="space-y-2">
                            <label class="text-[9px] font-black uppercase text-slate-400 ml-2 tracking-widest">{{ __('messages.contact_field_email') }}</label>
                            <input type="email" x-model="formData.email" required placeholder="{{ __('messages.contact_ph_email') }}" 
                                   class="w-full px-5 py-3 md:py-4 rounded-xl bg-slate-50 border border-slate-100 focus:border-indigo-500 outline-none transition">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[9px] font-black uppercase text-slate-400 ml-2 tracking-widest">{{ __('messages.contact_field_subject') }}</label>
                        <select x-model="formData.subject" class="w-full px-5 py-3 md:py-4 rounded-xl bg-slate-50 border border-slate-100 focus:border-indigo-500 outline-none transition appearance-none cursor-pointer">
                            <option value="achat">{{ __('messages.contact_opt_buy') }}</option>
                            <option value="vente">{{ __('messages.contact_opt_sell') }}</option>
                            <option value="location">{{ __('messages.contact_opt_rent') }}</option>
                            <option value="reservation">{{ __('messages.contact_opt_book') }}</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[9px] font-black uppercase text-slate-400 ml-2 tracking-widest">{{ __('messages.contact_field_message') }}</label>
                        <textarea x-model="formData.message" rows="4" placeholder="{{ __('messages.contact_ph_message') }}" 
                                  class="w-full px-5 py-3 md:py-4 rounded-xl bg-slate-50 border border-slate-100 focus:border-indigo-500 outline-none transition"></textarea>
                    </div>

                    <button type="submit" :disabled="loading" 
                            class="w-full py-4 md:py-5 bg-slate-900 text-white rounded-xl font-black uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-xl active:scale-[0.95] flex items-center justify-center gap-3">
                        <span x-show="!loading">{{ __('messages.contact_btn_submit') }} <i class="fa-solid fa-paper-plane ml-2"></i></span>
                        <span x-show="loading" class="flex items-center gap-2">
                            <i class="fa-solid fa-circle-notch animate-spin"></i> {{ __('messages.contact_btn_loading') }}
                        </span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
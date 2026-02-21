<section class="max-w-7xl mx-auto px-6 py-24 bg-white">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-16 items-center">
        
        {{-- Colonne de gauche : Texte d'introduction --}}
        <div class="space-y-6">
            <span class="text-indigo-600 font-bold uppercase tracking-[0.3em] text-[10px]">
                {{ __('messages.home_services_tag') }}
            </span>
            <h2 class="text-4xl md:text-5xl font-black text-slate-900 leading-tight">
                {!! __('messages.home_services_title') !!}
            </h2>
            <p class="text-slate-500 text-lg leading-relaxed">
                {{ __('messages.home_services_description') }}
            </p>
            <div class="pt-4">
                <a href="#" class="inline-flex items-center gap-3 text-slate-900 font-bold hover:text-indigo-600 transition-colors group">
                    {{ __('messages.home_services_cta') }}
                    <span class="w-10 h-10 rounded-full border border-slate-200 flex items-center justify-center group-hover:bg-indigo-600 group-hover:text-white group-hover:border-indigo-600 transition-all">
                        <i class="fa-solid fa-arrow-right"></i>
                    </span>
                </a>
            </div>
        </div>

        {{-- Colonne de droite : Grille de services --}}
        <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-8">
            
            {{-- Service 1 : Gestion Locative --}}
            <div class="p-10 rounded-[3rem] border border-slate-100 hover:border-white hover:shadow-2xl hover:shadow-indigo-500/10 transition-all duration-500 group">
                <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center text-3xl mb-8 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-hand-holding-dollar"></i>
                </div>
                <h3 class="text-xl font-black text-slate-900 mb-4">{{ __('messages.service_1_title') }}</h3>
                <p class="text-slate-500 text-sm leading-relaxed">
                    {{ __('messages.service_1_desc') }}
                </p>
            </div>

            {{-- Service 2 : Conciergerie --}}
            <div class="p-10 rounded-[3rem] border border-slate-100 hover:border-white hover:shadow-2xl hover:shadow-indigo-500/10 transition-all duration-500 group">
                <div class="w-16 h-16 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center text-3xl mb-8 group-hover:bg-amber-600 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-bell-concierge"></i>
                </div>
                <h3 class="text-xl font-black text-slate-900 mb-4">{{ __('messages.service_2_title') }}</h3>
                <p class="text-slate-500 text-sm leading-relaxed">
                    {{ __('messages.service_2_desc') }}
                </p>
            </div>

            {{-- Service 3 : Conseil Juridique --}}
            <div class="p-10 rounded-[3rem] border border-slate-100 hover:border-white hover:shadow-2xl hover:shadow-indigo-500/10 transition-all duration-500 group">
                <div class="w-16 h-16 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center text-3xl mb-8 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <h3 class="text-xl font-black text-slate-900 mb-4">{{ __('messages.service_3_title') }}</h3>
                <p class="text-slate-500 text-sm leading-relaxed">
                    {{ __('messages.service_3_desc') }}
                </p>
            </div>

            {{-- Service 4 : Aménagement --}}
            <div class="p-10 rounded-[3rem] border border-slate-100 hover:border-white hover:shadow-2xl hover:shadow-indigo-500/10 transition-all duration-500 group">
                <div class="w-16 h-16 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center text-3xl mb-8 group-hover:bg-rose-600 group-hover:text-white transition-colors">
                    <i class="fa-solid fa-couch"></i>
                </div>
                <h3 class="text-xl font-black text-slate-900 mb-4">{{ __('messages.service_4_title') }}</h3>
                <p class="text-slate-500 text-sm leading-relaxed">
                    {{ __('messages.service_4_desc') }}
                </p>
            </div>

        </div>
    </div>
</section>
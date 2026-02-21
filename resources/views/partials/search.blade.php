<section x-data="smartSearch()" class=" bg-slate-50">
    <div class="max-w-7xl mx-auto">
        
        {{-- HEADER --}}
        <div class="mt-2">
            <span class="text-indigo-600 font-bold uppercase tracking-[0.3em] text-[10px]">{{ __('messages.search_tag') }}</span>
            <h2 class="text-4xl font-black text-slate-900 tracking-tight mt-2">{!! __('messages.search_title') !!}</h2>
        </div>

        {{-- BARRE DE FILTRES --}}
        <div class="bg-white p-4 rounded-[2.5rem] shadow-xl mb-4 grid grid-cols-1 md:grid-cols-4 gap-4 items-center border border-slate-100">
            {{-- Localisation --}}
            <div class="flex items-center px-6 py-3 border-r border-slate-100 group">
                <i class="fa-solid fa-location-dot text-indigo-500 mr-4"></i>
                <div class="flex-1">
                    <label class="block text-[10px] uppercase font-bold text-slate-400">{{ __('messages.search_label_destination') }}</label>
                    <input type="text" 
                           x-model.debounce.400ms="filters.location" 
                           @input="triggerSearch" 
                           placeholder="{{ __('messages.search_placeholder_city') }}" 
                           class="w-full outline-none text-slate-700 font-bold bg-transparent">
                </div>
            </div>

            {{-- Type --}}
            <div class="flex items-center px-6 py-3 border-r border-slate-100 group">
                <i class="fa-solid fa-tag text-indigo-500 mr-4"></i>
                <div class="flex-1">
                    <label class="block text-[10px] uppercase font-bold text-slate-400">{{ __('messages.search_label_offer') }}</label>
                    <select x-model="filters.offer_type" @change="triggerSearch" class="w-full outline-none text-slate-700 font-bold bg-transparent">
                        <option value="">{{ __('messages.search_option_all') }}</option>
                        <option value="Vente">{{ __('messages.search_option_sale') }}</option>
                        <option value="Location">{{ __('messages.search_option_rent') }}</option>
                        <option value="Réservation">{{ __('messages.search_option_booking') }}</option>
                    </select>
                </div>
            </div>

            {{-- Catégorie --}}
            <div class="flex items-center px-6 py-3 border-r border-slate-100 group">
                <i class="fa-solid fa-house text-indigo-500 mr-4"></i>
                <div class="flex-1">
                    <label class="block text-[10px] uppercase font-bold text-slate-400">{{ __('messages.search_label_type') }}</label>
                    <select x-model="filters.category_id" @change="triggerSearch" class="w-full outline-none text-slate-700 font-bold bg-transparent">
                        <option value="">{{ __('messages.search_option_all_types') }}</option>
                        @isset($categories)
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        @endisset
                    </select>
                </div>
            </div>

            {{-- Budget --}}
            <div class="flex items-center px-6 py-3 group">
                <i class="fa-solid fa-wallet text-indigo-500 mr-4"></i>
                <div class="flex-1">
                    <label class="block text-[10px] uppercase font-bold text-slate-400">{{ __('messages.search_label_budget') }}</label>
                    <select x-model="filters.max_price" @change="triggerSearch" class="w-full outline-none text-slate-700 font-bold bg-transparent">
                        <option value="">{{ __('messages.search_option_unlimited') }}</option>
                        <template x-for="option in budgetOptions" :key="option.value">
                            <option :value="option.value" x-text="option.label"></option>
                        </template>
                    </select>
                </div>
            </div>
        </div>

        {{-- ZONE DE RÉSULTATS DYNAMIQUE --}}
        <div class="relative min-h-[40px] mb-12">
            
            {{-- 2. État : Chargement --}}
            <div x-show="loading" x-transition class="flex justify-center py-24">
                <div class="animate-spin h-12 w-12 border-4 border-indigo-600 border-t-transparent rounded-full"></div>
            </div>

            {{-- 3. État : Résultats trouvés --}}
            <div class="relative">
                <div class="flex overflow-x-auto space-x-4 pb-4 scroll-smooth scrollbar-hide" 
                     x-show="hasActiveFilters() && !loading && results.length > 0">
                    
                    <template x-for="property in results" :key="property.id">
                        <div class="flex-shrink-0 w-[80%] sm:w-[45%] md:w-[30%] lg:w-[23%] 
                                    bg-white rounded-[2.5rem] overflow-hidden shadow-sm hover:shadow-2xl 
                                    transition-all border border-slate-100">
                            
                            <img :src="property.main_image_url" class="h-64 w-full object-cover">
                            
                            <div class="p-6 sm:p-8">
                                <p class="text-indigo-500 text-[10px] font-black uppercase tracking-widest" 
                                   x-text="property.city"></p>
                                
                                <h3 class="text-xl font-bold text-slate-900 mt-1" x-text="property.title"></h3>
                                
                                <div class="mt-4 sm:mt-6 flex justify-between items-center border-t pt-4 sm:pt-5">
                                    <span class="text-2xl font-black text-slate-900" 
                                          x-text="new Intl.NumberFormat('{{ app()->getLocale() === 'fr' ? 'fr-FR' : 'en-US' }}').format(property.price) + ' €'"></span>
                                    
                                    <a :href="property.url" 
                                       class="w-12 h-12 bg-slate-900 text-white rounded-full flex items-center justify-center 
                                              hover:bg-indigo-600 transition">
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
                <div class="absolute top-0 right-0 h-full w-10 bg-gradient-to-l from-white to-transparent pointer-events-none hidden sm:block"></div>
            </div>

            {{-- 4. État : Aucun résultat trouvé --}}
            <div x-show="hasActiveFilters() && !loading && results.length === 0" 
                 x-transition 
                 class="text-center py-24 bg-red-50/50 rounded-[3rem] border border-red-100">
                <i class="fa-solid fa-ghost text-red-200 text-5xl mb-4"></i>
                <h3 class="text-xl font-bold text-slate-800">{{ __('messages.search_no_results_title') }}</h3>
                <p class="text-slate-500 mt-2">{{ __('messages.search_no_results_desc') }}</p>
            </div>

        </div>
    </div>
</section>

<script>
function smartSearch() {
    return {
        loading: false,
        results: [],
        controller: null,
        searchUrl: "{{ route('search.smart', ['locale' => app()->getLocale()]) }}",

        filters: {
            location: '',
            offer_type: '',
            category_id: '',
            max_price: ''
        },

        hasActiveFilters() {
            return Object.values(this.filters).some(value => value !== '' && value !== null);
        },

        get budgetOptions() {
            if (this.filters.offer_type === 'Réservation')
                return [
                    { label: '500€ / {{ __("messages.label_nuit") }}', value: 500 }, 
                    { label: '1000€ / {{ __("messages.label_nuit") }}', value: 1000 }
                ];
            if (this.filters.offer_type === 'Location')
                return [
                    { label: '2000€ / {{ __("messages.label_mois") }}', value: 2000 }, 
                    { label: '5000€ / {{ __("messages.label_mois") }}', value: 5000 }
                ];
            return [
                { label: '500k €', value: 500000 },
                { label: '1.5M €', value: 1500000 },
                { label: '{{ __("messages.budget_prestige") }} (+5M €)', value: 5000000 }
            ];
        },

        async triggerSearch() {

            if (!this.hasActiveFilters()) {
                this.results = [];
                this.loading = false;
                return;
            }

            if (this.controller) {
                this.controller.abort();
            }

            this.controller = new AbortController();
            this.loading = true;

            try {
                const activeParams = Object.fromEntries(
                    Object.entries(this.filters).filter(([_, v]) => v !== "")
                );

                const params = new URLSearchParams(activeParams).toString();

                const response = await fetch(`${this.searchUrl}?${params}`, {
                    headers: { 'Accept': 'application/json' },
                    signal: this.controller.signal
                });

                if (!response.ok) throw new Error();

                this.results = await response.json();

            } catch (e) {
                if (e.name !== 'AbortError') {
                    console.error("Erreur de recherche");
                    this.results = [];
                }
            } finally {
                this.loading = false;
            }
        }
    }
}
</script>
<nav class="fixed top-0 left-0 w-full z-50 px-4 md:px-6 pt-4" x-data="{ mobileMenuOpen: false, servicesOpen: false }">
    {{-- Container Principal --}}
    <div class="max-w-7xl mx-auto flex justify-between items-center bg-white/70 backdrop-blur-lg border border-white/20 rounded-[2rem] p-3 md:p-4 shadow-xl shadow-slate-900/5">
        
        {{-- Logo --}}
        <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" class="text-xl md:text-2xl font-black text-indigo-600 tracking-tighter flex items-center">
            LUXE<span class="text-slate-800">HOME</span>
        </a>

        {{-- Menu Desktop --}}
        <div class="hidden md:flex items-center space-x-1">
            <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" class="px-5 py-2 text-slate-600 font-bold hover:text-indigo-600 transition-all rounded-full hover:bg-indigo-50">
                {{ __('messages.header_nav_home') }}
            </a>
            
            {{-- Dropdown Services --}}
            <div class="relative" @mouseenter="servicesOpen = true" @mouseleave="servicesOpen = false">
                <button class="px-5 py-2 text-slate-600 font-bold hover:text-indigo-600 transition-all rounded-full hover:bg-indigo-50 flex items-center gap-2">
                    {{ __('messages.header_nav_services') }} <i class="fa-solid fa-chevron-down text-[10px] transition-transform" :class="servicesOpen ? 'rotate-180' : ''"></i>
                </button>

                <div x-show="servicesOpen" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="absolute top-full left-0 mt-2 w-48 bg-white border border-slate-100 rounded-3xl shadow-xl p-2 z-50">
                    <a href="{{ route('services.vente', ['locale' => app()->getLocale()]) }}" class="block px-5 py-3 text-sm font-bold text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 rounded-2xl transition-all">
                        {{ __('messages.header_service_sale') }}
                    </a>
                    <a href="{{ route('services.location', ['locale' => app()->getLocale()]) }}" class="block px-5 py-3 text-sm font-bold text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 rounded-2xl transition-all">
                        {{ __('messages.header_service_rent') }}
                    </a>
                    <a href="{{ route('services.reservation', ['locale' => app()->getLocale()]) }}" class="block px-5 py-3 text-sm font-bold text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 rounded-2xl transition-all">
                        {{ __('messages.header_service_booking') }}
                    </a>
                </div>
            </div>

            <a href="{{ route('about', ['locale' => app()->getLocale()]) }}" class="px-5 py-2 text-slate-600 font-bold hover:text-indigo-600 transition-all rounded-full hover:bg-indigo-50">
                {{ __('messages.header_nav_about') }}
            </a>
            <a href="{{ route('contact', ['locale' => app()->getLocale()]) }}" class="px-5 py-2 text-slate-600 font-bold hover:text-indigo-600 transition-all rounded-full hover:bg-indigo-50">
                {{ __('messages.header_nav_contact') }}
            </a>
        </div>

        {{-- Actions --}}
        <div class="flex items-center gap-3">
            <button class="hidden sm:block bg-indigo-600 text-white px-6 py-3 rounded-2xl font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200 active:scale-95">
                {{ __('messages.header_btn_publish') }} <span class="hidden lg:inline">{{ __('messages.header_btn_publish_suffix') }}</span>
            </button>

            {{-- Bouton Hamburger --}}
            <button @click="mobileMenuOpen = !mobileMenuOpen" 
                    class="md:hidden w-12 h-12 flex items-center justify-center rounded-2xl bg-slate-100 text-slate-600 transition-all active:scale-90">
                <i class="fa-solid" :class="mobileMenuOpen ? 'fa-xmark text-xl' : 'fa-bars-staggered text-xl'"></i>
            </button>
        </div>
    </div>

    {{-- Menu Mobile --}}
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         @click.away="mobileMenuOpen = false"
         class="absolute top-24 left-6 right-6 p-6 bg-white/95 backdrop-blur-xl rounded-[2.5rem] shadow-2xl border border-slate-100 md:hidden flex flex-col space-y-3 z-40">
        
        <a href="{{ route('home', ['locale' => app()->getLocale()]) }}" class="p-4 bg-slate-50 rounded-2xl font-bold text-slate-700">
            {{ __('messages.header_nav_home') }}
        </a>
        
        {{-- Services Mobile Accordion --}}
        <div x-data="{ subOpen: false }" class="bg-slate-50 rounded-2xl overflow-hidden">
            <button @click="subOpen = !subOpen" class="w-full flex items-center justify-between p-4 font-bold text-slate-700">
                {{ __('messages.header_nav_services') }} <i class="fa-solid fa-chevron-down text-xs transition-transform" :class="subOpen ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="subOpen" class="bg-slate-100/50 px-4 pb-4 flex flex-col space-y-2">
                <a href="{{ route('services.vente', ['locale' => app()->getLocale()]) }}" class="text-sm font-bold text-slate-500 py-2 border-l-2 border-indigo-500 pl-4">{{ __('messages.header_service_sale') }}</a>
                <a href="{{ route('services.location', ['locale' => app()->getLocale()]) }}" class="text-sm font-bold text-slate-500 py-2 border-l-2 border-indigo-500 pl-4">{{ __('messages.header_service_rent') }}</a>
                <a href="{{ route('services.reservation', ['locale' => app()->getLocale()]) }}" class="text-sm font-bold text-slate-500 py-2 border-l-2 border-indigo-500 pl-4">{{ __('messages.header_service_booking') }}</a>
            </div>
        </div>

        <a href="{{ route('about', ['locale' => app()->getLocale()]) }}" class="p-4 bg-slate-50 rounded-2xl font-bold text-slate-700">{{ __('messages.header_nav_about') }}</a>
        <a href="{{ route('contact', ['locale' => app()->getLocale()]) }}" class="p-4 bg-slate-50 rounded-2xl font-bold text-slate-700">{{ __('messages.header_nav_contact') }}</a>
        
        <button class="w-full py-5 bg-indigo-600 text-white rounded-[1.5rem] font-bold shadow-xl shadow-indigo-200 mt-2">
            {{ __('messages.header_btn_publish') }} {{ __('messages.header_btn_publish_suffix') }}
        </button>
    </div>
</nav>
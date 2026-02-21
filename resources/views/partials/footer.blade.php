<footer class="bg-slate-900 text-slate-400 mt-24 border-t border-slate-800">
    <div class="max-w-7xl mx-auto px-6 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
            
            <div class="space-y-6">
                <h3 class="text-2xl font-black text-white tracking-tighter">LUXE<span class="text-indigo-500">HOME</span></h3>
                <p class="text-sm leading-relaxed">
                    {{ __('messages.footer_description') }}
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-white hover:bg-indigo-600 transition-colors">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-white hover:bg-indigo-600 transition-colors">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                    <a href="#" class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-white hover:bg-indigo-600 transition-colors">
                        <i class="fa-brands fa-linkedin-in"></i>
                    </a>
                </div>
            </div>

            <div>
                <h4 class="text-white font-bold mb-6 uppercase text-xs tracking-widest">{{ __('messages.footer_title_nav') }}</h4>
                <ul class="space-y-4 text-sm">
                    <li><a href="{{ route('services.vente', ['locale' => app()->getLocale()]) }}" class="hover:text-white transition-colors">{{ __('messages.footer_link_sale') }}</a></li>
                    <li><a href="{{ route('services.location', ['locale' => app()->getLocale()]) }}" class="hover:text-white transition-colors">{{ __('messages.footer_link_rent') }}</a></li>
                    <li><a href="{{ route('services.reservation', ['locale' => app()->getLocale()]) }}" class="hover:text-white transition-colors">{{ __('messages.footer_link_booking') }}</a></li>
                </ul>
            </div>

            <div>
                <h4 class="text-white font-bold mb-6 uppercase text-xs tracking-widest">{{ __('messages.footer_title_info') }}</h4>
                <ul class="space-y-4 text-sm">
                    <li><a href="{{ route('about', ['locale' => app()->getLocale()]) }}" class="hover:text-white transition-colors">{{ __('messages.footer_link_about') }}</a></li>
                    <li><a href="{{ route('terms', ['locale' => app()->getLocale()]) }}" class="hover:text-white transition-colors">{{ __('messages.footer_link_terms') }}</a></li>
                    <li><a href="{{ route('privacy', ['locale' => app()->getLocale()]) }}" class="hover:text-white transition-colors">{{ __('messages.footer_link_privacy') }}</a></li>
                    <!-- <li><a href="{{ route('login', ['locale' => app()->getLocale()]) }}" class="inline-flex items-center text-indigo-400 hover:text-indigo-300 transition-colors">
                        <i class="fa-solid fa-lock mr-2 text-xs"></i> {{ __('messages.footer_link_admin') }}
                    </a></li> -->
                </ul>
            </div>

            <div>
                <h4 class="text-white font-bold mb-6 uppercase text-xs tracking-widest">{{ __('messages.footer_title_contact') }}</h4>
                <ul class="space-y-4 text-sm mb-6">
                    <li class="flex items-start">
                        <i class="fa-solid fa-location-dot mt-1 mr-3 text-indigo-500"></i>
                        <span>{!! __('messages.footer_address') !!}</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fa-solid fa-phone mr-3 text-indigo-500"></i>
                        <span>{{ __('messages.footer_phone') }}</span>
                    </li>
                </ul>
            </div>

        </div>

        <div class="pt-8 border-t border-slate-800 flex flex-col md:flex-row justify-between items-center text-xs space-y-4 md:space-y-0">
            <p>© {{ date('Y') }} LuxeHome. {{ __('messages.footer_rights') }}</p>
            <div class="flex space-x-6 italic">
                <span>{{ __('messages.footer_slogan') }}</span>
            </div>
        </div>
    </div>
</footer>
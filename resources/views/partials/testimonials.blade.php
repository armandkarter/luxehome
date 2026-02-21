{{-- SECTION TÉMOIGNAGES EUROPÉENS --}}
<section class="max-w-7xl mx-auto px-6 py-24 border-t border-slate-50 overflow-hidden">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-16">
        
        {{-- Colonne Infos & Stats --}}
        <div class="lg:col-span-1 flex flex-col justify-center">
            <span class="text-indigo-600 font-bold uppercase tracking-[0.3em] text-[10px] mb-4">
                {{ __('messages.testimonials_tag') }}
            </span>
            <h2 class="text-4xl font-black text-slate-900 mb-8 leading-tight">
                {!! __('messages.testimonials_title') !!}
            </h2>
            
            <div class="space-y-4">
                <div class="p-6 bg-slate-50 rounded-[2rem] flex items-center justify-between">
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-widest">{{ __('messages.stat_countries') }}</p>
                    <p class="text-2xl font-black text-slate-900">8</p>
                </div>
                <div class="p-6 bg-indigo-600 rounded-[2rem] flex items-center justify-between text-white shadow-xl shadow-indigo-200">
                    <p class="text-white/80 text-xs font-bold uppercase tracking-widest">{{ __('messages.stat_rating') }}</p>
                    <p class="text-2xl font-black">4.9/5</p>
                </div>
            </div>
        </div>

        {{-- Colonne Slider --}}
        <div class="lg:col-span-2 relative">
            <div class="swiper mySwiper pb-12">
                <div class="swiper-wrapper">
                    @foreach (range(1, 10) as $id)
                    <div class="swiper-slide h-auto">
                        <div class="bg-white p-10 rounded-[3rem] shadow-xl shadow-slate-100 border border-slate-50 flex flex-col h-full m-4 hover:border-indigo-100 transition-colors group">
                            <div class="flex gap-1 text-amber-400 mb-6 text-[10px]">
                                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                            </div>
                            
                            <p class="text-md text-slate-600 leading-relaxed italic mb-8 flex-grow">
                                "{{ __("messages.testimonial_{$id}_text") }}"
                            </p>
                            
                            <div class="flex items-center gap-4 mt-auto">
                                <img src="https://i.pravatar.cc/150?u={{ $id + 50 }}" class="w-12 h-12 rounded-full grayscale group-hover:grayscale-0 transition-all" alt="Client">
                                <div>
                                    <p class="font-black text-slate-900 text-sm">{{ __("messages.testimonial_{$id}_name") }}</p>
                                    <p class="text-[10px] text-indigo-500 font-bold uppercase tracking-widest">{{ __("messages.testimonial_{$id}_role") }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="swiper-pagination"></div>
            </div>
            
            {{-- Navigation --}}
            <div class="flex gap-4 mt-8 lg:absolute lg:-top-20 lg:right-0">
                <div class="prev-btn w-12 h-12 rounded-full border border-slate-200 flex items-center justify-center cursor-pointer hover:bg-slate-900 hover:text-white transition-all">
                    <i class="fa-solid fa-chevron-left text-xs"></i>
                </div>
                <div class="next-btn w-12 h-12 rounded-full border border-slate-200 flex items-center justify-center cursor-pointer hover:bg-slate-900 hover:text-white transition-all">
                    <i class="fa-solid fa-chevron-right text-xs"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        if(typeof Swiper !== 'undefined') {
            new Swiper(".mySwiper", {
                slidesPerView: 1,
                spaceBetween: 30,
                loop: true,
                autoplay: { delay: 4000, disableOnInteraction: false },
                pagination: { el: ".swiper-pagination", clickable: true },
                navigation: { nextEl: ".next-btn", prevEl: ".prev-btn" },
                breakpoints: { 768: { slidesPerView: 2 } }
            });
        }
    });
</script>
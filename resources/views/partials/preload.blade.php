<div x-data="{ loaded: false }" 
     x-init="window.addEventListener('load', () => { setTimeout(() => loaded = true, 800) })" 
     x-show="!loaded"
     x-transition:leave="transition ease-in duration-500"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-[9999] flex flex-col items-center justify-center bg-slate-900">
    
    <div class="relative flex flex-col items-center">
        <div class="w-24 h-24 border-2 border-indigo-500/20 border-t-indigo-500 rounded-full animate-spin"></div>
        
        <div class="absolute inset-0 flex items-center justify-center">
            <span class="text-white font-black text-xl tracking-tighter italic">L<span class="text-indigo-500">H</span></span>
        </div>

        <div class="mt-8 overflow-hidden">
            <h2 class="text-white font-bold tracking-[0.3em] uppercase text-[10px] animate-pulse">
                LuxeHome <span class="text-indigo-500">|</span> Excellence
            </h2>
        </div>
    </div>

    <div class="absolute bottom-0 left-0 h-[2px] bg-indigo-600 transition-all duration-1000 ease-out"
         :style="loaded ? 'width: 100%' : 'width: 30%'">
    </div>
</div>
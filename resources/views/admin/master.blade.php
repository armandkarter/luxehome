<!DOCTYPE html>
<html lang="fr" x-data="{ sidebarOpen: false }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Ajout de Alpine.js pour l'interactivité du menu mobile --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); }
        .sidebar-link.active { @apply bg-indigo-600 text-white shadow-lg shadow-indigo-200; }
        [x-cloak] { display: none !important; }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800 flex min-h-screen">

    <div x-show="sidebarOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false" 
         class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-sm lg:hidden">
    </div>

    <aside 
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="w-64 bg-white border-r border-slate-200 flex flex-col fixed h-full z-50 transition-transform duration-300 ease-in-out lg:translate-x-0">
        
        <div class="p-8 flex items-center justify-between">
            <span class="text-2xl font-extrabold text-slate-900 tracking-tight">Luxe<span class="text-indigo-600">Habitat</span></span>
            <button @click="sidebarOpen = false" class="lg:hidden text-slate-500">
                <i class="fa-solid fa-xmark text-xl"></i>
            </button>
        </div>

        <nav class="flex-1 px-4 space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-50 transition-all {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-pie w-5"></i>
                <span class="font-semibold">Dashboard</span>
            </a>
            <a href="#" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-50 transition-all">
                <i class="fa-solid fa-house-chimney w-5"></i>
                <span class="font-semibold">Mes Propriétés</span>
            </a>
            <a href="#" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-50 transition-all">
                <i class="fa-solid fa-calendar-days w-5"></i>
                <span class="font-semibold">Réservations</span>
            </a>
            <a href="#" class="sidebar-link flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 hover:bg-slate-50 transition-all">
                <i class="fa-solid fa-gear w-5"></i>
                <span class="font-semibold">Paramètres</span>
            </a>
        </nav>

        <div class="p-4 border-t border-slate-100">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="flex items-center gap-3 px-4 py-3 w-full text-red-500 font-bold hover:bg-red-50 rounded-xl transition-all">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    Déconnexion
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col min-w-0 lg:ml-64">
        
        <header class="h-20 bg-white/80 backdrop-blur-md border-b border-slate-200 px-4 lg:px-8 flex items-center justify-between sticky top-0 z-30">
            
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = true" class="lg:hidden p-2 text-slate-600 hover:bg-slate-100 rounded-lg">
                    <i class="fa-solid fa-bars-staggered text-xl"></i>
                </button>

                <div class="hidden md:flex items-center gap-4 text-slate-400">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Rechercher..." class="bg-transparent outline-none text-sm w-48 lg:w-64">
                </div>
            </div>
            
            <div class="flex items-center gap-3 lg:gap-4">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-bold text-slate-900 leading-tight">{{ Auth::user()->name }}</p>
                    <p class="text-[10px] text-emerald-500 font-bold uppercase tracking-widest">En ligne</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold border-2 border-white shadow-sm shrink-0">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </div>
        </header>

        <div class="p-4 lg:p-8">
            @yield('admin_content')
        </div>
    </main>

    @stack('scripts')
</body>
</html>
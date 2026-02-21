<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'LuxeHome')</title>
    @yield('meta_description')

    {{-- Tailwind CDN (temporaire) --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <meta name="author" content="Luxe Home Hub">
    <link rel="icon" href="{{ asset('assets/images/logo.jpeg') }}">
    <meta property="og:image" content="https://images.unsplash.com/photo-1600596542815-ffad4c1539a9?q=80&w=800&auto=format&fit=crop">


    {{-- Font Awesome --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    {{-- Google Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    {{-- Styles globaux --}}
    <style>
        :root {
            --color-primary: #4f46e5; /* indigo-600 */
            --color-dark: #0f172a;    /* slate-900 */
            --radius-xl: 1.5rem;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        
        }

        .glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
        /* Sur l'accueil uniquement, on annule ce padding si tu veux que l'image passe derrière */

        .home-page body {
            padding-top: 0;
        }

        [x-cloak] { display: none !important; }
    
       /* Empêcher le scroll pendant le chargement */
        body.loading {
            overflow: hidden;
        }
    
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap');
    
        .hero-gradient { background: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3)), url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80'); }
    </style>

    @include('components.hreflang')
</head>

<body class="bg-slate-50 text-slate-800">

    @include('partials.preload')


    @include('partials.header')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

</body>
</html>

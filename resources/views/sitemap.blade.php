{!! '<' . '?xml version="1.0" encoding="UTF-8"?' . '>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
@foreach($locales as $lang)
    @foreach($pages as $page)
    <url>
        {{-- Laravel construit l'URL complète avec le bon préfixe langue --}}
        <loc>{{ route($page, ['locale' => $lang]) }}</loc>
        
        {{-- Priorité basée sur le nom de la route --}}
        <priority>{{ $page === 'home' ? '1.0' : ($page === 'contact' ? '0.9' : '0.7') }}</priority>
        
        <changefreq>weekly</changefreq>
    </url>
    @endforeach
@endforeach
</urlset>
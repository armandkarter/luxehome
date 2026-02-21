@php
    // Ta liste de langues
    $availableLocales = ['en','fr']; 
    $currentPath = request()->path();

    // Nettoyage propre du segment de langue
    foreach ($availableLocales as $lang) {
        if (str_starts_with($currentPath, $lang . '/')) {
            $currentPath = substr($currentPath, strlen($lang) + 1);
            break;
        } elseif ($currentPath === $lang) {
            $currentPath = '';
            break;
        }
    }

    // On s'assure que le chemin ne commence pas par un slash pour la concaténation
    $currentPath = ltrim($currentPath, '/');
@endphp

{{-- Génération des balises par langue --}}
@foreach($availableLocales as $lang)
    <link rel="alternate" hreflang="{{ $lang }}" href="{{ url($lang . ($currentPath ? '/' . $currentPath : '')) }}">
@endforeach

{{-- Le x-default (Pointant ici vers la version anglaise ou française par défaut) --}}
<link rel="alternate" hreflang="x-default" href="{{ url('en' . ($currentPath ? '/' . $currentPath : '')) }}">
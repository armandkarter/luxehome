<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
   public function index()
{
    $locales = ['en', 'fr']; 

    // On liste les noms (alias) des routes statiques
    $pages = [
        'home', 
        'properties.index', 
        'services.vente', 
        'services.location', 
        'services.reservation', 
        'contact', 
        'about', 
        'terms', 
        'privacy'
    ];

    $xml = Cache::remember('sitemap_static', 86400, function () use ($locales, $pages) {
        return view('sitemap', compact('locales', 'pages'))->render();
    });

    return response($xml)->header('Content-Type', 'text/xml');
}
}
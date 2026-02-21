<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class DetectUserLanguage
{
    public function handle(Request $request, Closure $next)
    {
        $supportedLangs = [
    'en', // Anglais
    'fr', // Français
];

        $defaultLang = 'en';
        $lang = null;

        // 1️⃣ Vérifier si l'URL contient un code de langue
        $urlLang = $request->segment(1);
        if (in_array($urlLang, $supportedLangs)) {
            $lang = $urlLang;
        }

        // 2️⃣ Sinon vérifier la langue du navigateur
        if (!$lang) {
            $browserLang = substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);
            if (in_array($browserLang, $supportedLangs)) {
                $lang = $browserLang;
            }
        }

        // 3️⃣ Sinon détecter via IP
        if (!$lang) {
            $ip = $request->ip();
            try {
                $response = @file_get_contents("https://ipapi.co/{$ip}/json/");
                $data = json_decode($response);
                if (!empty($data->languages)) {
                    $detected = substr($data->languages, 0, 2);
                    if (in_array($detected, $supportedLangs)) {
                        $lang = $detected;
                    }
                }
            } catch (\Exception $e) {
                // Ne rien faire
            }
        }

        // 4️⃣ Si rien → langue par défaut
        if (!$lang) {
            $lang = $defaultLang;
        }

        // 5️⃣ Sauvegarder la langue
        Session::put('locale', $lang);
        App::setLocale($lang);

        // 6️⃣ Rediriger si l'URL ne contient pas la langue
        if ($urlLang !== $lang) {
            $segments = $request->segments();

            // Assurer que $segments[0] existe
            if (empty($segments)) {
                $segments = [$lang];
            } else {
                $segments[0] = $lang;
            }

            $newUrl = url(implode('/', $segments));

            // Éviter boucle infinie
            if ($request->url() !== $newUrl) {
                return redirect($newUrl);
            }
        }

        return $next($request);
    }
}

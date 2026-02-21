<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Property;

class AuthController extends Controller
{
    //

    // Commande : php artisan make:controller AuthController

public function login($locale, Request $request)
{
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('admin/dashboard');
    }

    return back()->withErrors(['email' => 'Identifiants incorrects.']);
}

public function logout($locale, Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect("/$locale");
}

public function dashboard($locale)
{

    $totalProperties = Property::count();
    $totalVente = Property::where('offer_type', 'Vente')->count();
    $totalReservation = Property::where('offer_type', 'Réservation')->count();
    $totalRent = Property::where('offer_type', 'Location')->count();


    $occupancyRate = $totalProperties > 0 ? round(($totalReservation / $totalProperties) * 100) : 0;

        // 2. Récupérer les 5 dernières annonces avec leurs catégories et images
        $recentProperties = Property::with(['category', 'images'])
                            ->latest()
                            ->take(5)
                            ->get();

    return view('admin.dashboard', compact(
        'totalProperties',
        'totalVente',
        'totalReservation', 
        'totalRent', 
        'occupancyRate', 
        'recentProperties'
        ));
}



}

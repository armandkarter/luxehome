<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Authcontroller;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\InquiryController;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $lang = Session::get('locale', 'en'); // récupère la langue en session ou par défaut
    return redirect($lang); // redirige vers /fr, /en, etc.
});



Route::group([
    'prefix' => '{locale}', // code langue obligatoire
    'where' => [
    'locale' => 'en|fr|es|de|it|pt|nl',
    ],

    'middleware' => ['web', \App\Http\Middleware\DetectUserLanguage::class]
], function () {

Route::get('/sitemap.xml', [SitemapController::class, 'index']);

Route::get('/', [PropertyController::class, 'index'])->name('home');

Route::get('/sitemap.xml', [SitemapController::class, 'index']);

Route::get('all-properties', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/proprietes/{slug_uuid}', [PropertyController::class, 'show'])->name('properties.show');

Route::get('category/{id}/properties', [PropertyController::class, 'propertiesByCategory'])->name('categories.show');
Route::get('/search-smart', [PropertyController::class, 'search'])->name('search.smart');

Route::get('/destination/{slug}', [PropertyController::class, 'byCountry'])->name('destinations.show');

Route::get('/categorie/{slug}', [PropertyController::class, 'categorie'])
    ->name('categories.show');


//services
// Routes pour les services
Route::get('/services/vente', [PropertyController::class, 'services'])->name('services.vente');
Route::get('/services/location', [PropertyController::class, 'services'])->name('services.location');
Route::get('/services/reservation', [PropertyController::class, 'services'])->name('services.reservation');

Route::get('/a-propos', function () {
    return view('pages.about');
})->name('about');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

Route::get('/mentions-legales', function () {
    return view('pages.terms');
})->name('terms');

Route::get('/politique-confidentialite', function () {
    return view('pages.privacy');
})->name('privacy');

//reservation
Route::post('/property/{id}/inquiry', [InquiryController::class, 'store'])->name('property.inquiry');
Route::post('/contact', [InquiryController::class, 'contact'])->name('contact.submit');
//login routes
Route::get('/login', function () {return view('auth.login');})->name('login');
Route::post('/login/store',[Authcontroller::class,'login'])->name('login.store');

//admin routes
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('admin.dashboard'); 
    Route::post('/properties/quick-store', [PropertyController::class, 'quickStore'])->name('admin.properties.quickStore');
    
    // Route pour l'étape suivante (Détails et Photos)
    Route::get('/properties/{id}/complete', [PropertyController::class, 'complete'])->name('admin.properties.complete');
    Route::put('/properties/{id}/complete', [PropertyController::class, 'updateDetails'])->name('admin.properties.updateDetails');

    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});


/*  on fait deux et de facon simultanée. quand il va ajouter la chambre et c'est succres, immediatement un modal sera affiché pour lui permettre d'ajouter les descriptions */


});
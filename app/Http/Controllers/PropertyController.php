<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\PropertyDetail;
use Illuminate\Support\Facades\Crypt;
use App\Models\Country;

class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
  public function index() {
    // On récupère toutes les catégories qui ont au moins un bien
    $categories = Category::with(['properties' => function($query) {
        $query->with(['details', 'images'])->latest()->take(10);
    }])->get();

    $offers = ['Vente', 'Location', 'Réservation'];

    $destinations = PropertyDetail::whereNotNull('country')
    ->select('country', 'country_image')
    ->selectRaw('count(*) as total')
    ->groupBy('country', 'country_image')
    ->orderBy('total', 'desc')
    ->get();

    return view('home', compact('categories', 'destinations', 'offers'));
}

public function search(Request $request)
{
    // 1. Initialisation de la requête avec les relations nécessaires
    $query = Property::query()
        ->with(['details', 'images' => function($q) {
            // On ne charge que les images marquées comme principales ou la première disponible
            $q->orderBy('is_main', 'desc'); 
        }]);

    // 2. Filtre par Type d'offre (Vente, Location, Réservation)
    if ($request->filled('offer_type')) {
        $query->where('offer_type', $request->offer_type);
    }

    // 3. Filtre par Catégorie
    if ($request->filled('category_id')) {
        $query->where('category_id', $request->category_id);
    }

    // 4. Filtre par Localisation (Ville ou Pays)
   if ($request->filled('location')) {
    $search = strtolower($request->location); // On force en minuscule
    $query->whereHas('details', function($q) use ($search) {
        $q->whereRaw('LOWER(city) LIKE ?', ["%$search%"])
          ->orWhereRaw('LOWER(country) LIKE ?', ["%$search%"]);
    });
}

    // 5. Filtre par Budget Max (avec ta logique spécifique pour les séjours/loyers)
    if ($request->filled('max_price')) {
        $price = (float) $request->max_price;
        // Si c'est un gros budget sur une location/réservation, on ajuste la logique
        if ($price >= 1000000 && ($request->offer_type == 'Réservation' || $request->offer_type == 'Location')) {
             $query->where('price', '>=', ($request->offer_type == 'Réservation' ? 1000 : 5000));
        } else {
            $query->where('price', '<=', $price);
        }
    }

    // 6. Récupération et Transformation des données pour le JSON Alpine.js
    $properties = $query->latest()->get()->map(function($p) {
    $mainImg = $p->images->where('is_main', true)->first() ?? $p->images->first();

    return [
        'id'             => $p->id,
        'title'          => $p->title,
        'url_identifier' => $p->url_identifier, // ✅ existant
        'price'          => $p->price,
        'offer_type'     => $p->offer_type,
        'status'         => $p->status,
        'city'           => $p->details->city ?? 'Europe',
        'main_image_url' => $mainImg 
            ? asset('uploads/properties/' . $mainImg->path) 
            : 'https://via.placeholder.com/800x600?text=LuxeHabitat',
        'area'           => $p->details->area ?? 0,
        'bedrooms'       => $p->details->bedrooms ?? 0,
        'bathrooms'      => $p->details->bathrooms ?? 0,
        // 🔥 ajout de l'URL complète côté backend
        'url' => route('properties.show', [
    'locale' => app()->getLocale(),
    'slug_uuid' => $p->url_identifier,
]),
    ];
});

    // 7. Retour de la réponse JSON
    return response()->json($properties);
}


   public function quickStore($locale, Request $request)
{
    $request->validate([
        'title' => 'required|max:255',
        'category_id' => 'required|exists:categories,id',
        'price' => 'required|numeric',
        'offer_type' => 'required|in:Vente,Location,Réservation'
    ]);

    // Détermination automatique du label
    $label = 'total';
    if ($request->offer_type === 'Location') {
        $label = 'par mois';
    } elseif ($request->offer_type === 'Réservation') {
        $label = 'par nuit';
    }

    $property = Property::create([
        'title'       => $request->title,
        'slug'        => Str::slug($request->title) . '-' . rand(1000, 9999),
        'category_id' => $request->category_id,
        'price'       => $request->price,
        'offer_type'  => $request->offer_type,
        'price_label' => $label, // On insère le label dynamique ici
        'status'      => 'Disponible',
    ]);

    return redirect()->route('admin.properties.complete', ['locale' => app()->getLocale(), 'id' => $property->id])
                        ->with('success', 'Bien créé ! Complétons maintenant les détails.');
}

    public function complete($locale, $id)
    {
        $property = Property::findOrFail($id);
        $countries = Country::all();
        return view('admin.properties.complete', compact('property', 'countries'));
    }



public function updateDetails($locale, $id, Request $request)
{
    $property = Property::findOrFail($id);

    $request->validate([
        'description' => 'required|string',
        'city'        => 'required|string|max:100',
        'country_id'     => 'required|exists:countries,id', 
        'address'     => 'required|string|max:255',
        'area'        => 'nullable|numeric',
        'bedrooms'    => 'nullable|integer',
        'bathrooms'   => 'nullable|integer',
        'country_image' => 'nullable|string|max:255',
        'amenities'   => 'nullable|array',
        'images.*'    => 'image|mimes:jpeg,png,jpg,webp|max:5120'
    ]);

    $country = Country::find($request->country_id); 

    try {
        return DB::transaction(function () use ($property, $request, $country) {
            
            // 2. Mise à jour des détails
            $property->details()->updateOrCreate(
                ['property_id' => $property->id],
                [
                    'description' => $request->description,
                    'area'         => $request->area,
                    'bedrooms'    => $request->bedrooms ?? 0,
                    'bathrooms'   => $request->bathrooms ?? 0,
                    'country'     => $country->name,
                    'city'        => $request->city,
                    'address'     => $request->address,
                    'country_image' => $country->image_path,
                    'amenities'   => $request->amenities, 
                ]
            );

            // 3. Gestion des images directement dans le dossier PUBLIC
            if ($request->hasFile('images')) {
                // On définit le chemin vers public/uploads/properties
                $destinationPath = public_path('uploads/properties');

                // On crée le dossier s'il n'existe pas
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                foreach ($request->file('images') as $index => $file) {
                    $filename = Str::slug($property->title) . '-' . time() . '-' . $index . '.' . $file->getClientOriginalExtension();

                    // On déplace le fichier directement dans le dossier public
                    $file->move($destinationPath, $filename);

                    // Enregistrement en BDD
                    $property->images()->create([
                        'path'       => $filename,
                        'is_main'    => ($index === 0 && !$property->images()->where('is_main', true)->exists()),
                        'sort_order' => $index
                    ]);
                }
            }

            return redirect()->route('admin.dashboard', ['locale' => app()->getLocale()])
                ->with('success', 'L\'annonce a été mise à jour avec succès !');
        });

    } catch (\Exception $e) {
        return back()->withInput()->with('error', 'Erreur : ' . $e->getMessage());
    }
}


    /**
     * Display the specified resource.
     */
public function show($locale, $slug_uuid)
{
    $shortUuid = substr($slug_uuid, -8);

    $property = Property::with(['category', 'images', 'details'])
        ->where('uuid', 'like', $shortUuid . '%')
        ->firstOrFail();

    if ($slug_uuid !== $property->url_identifier) {
    return redirect()->route('properties.show', [
    'locale' => app()->getLocale(),
    'slug_uuid' => $property->url_identifier
]);    }

    $similarProperties = Property::where('category_id', $property->category_id)
        ->where('id', '!=', $property->id)
        ->take(4)
        ->get();

    return view('properties.show', compact('property', 'similarProperties'));
}


public function byCountry($locale, $slug)
{
    try {
        
        $countryName = trim(Crypt::decryptString($slug));

        $properties = Property::whereHas('details', function($query) use ($countryName) {
           // On transforme les deux côtés en minuscules pour être sûr de matcher
            $query->whereRaw('LOWER(country) = ?', [strtolower($countryName)]);
            })->with(['details', 'images'])->latest()->paginate(12);


        $propertiesGrouped = $properties->getCollection()->groupBy(function($item) {
            return $item->category->name; 
        });

        // 3. Transformation des données pour la vue (pour gérer les images proprement)
        $properties->getCollection()->transform(function($p) {
            $mainImg = $p->images->where('is_main', true)->first() ?? $p->images->first();
            $p->main_image_url = $mainImg 
                ? asset('uploads/properties/' . $mainImg->path) 
                : asset('images/placeholder-luxe.jpg');
            return $p;
        });

        return view('properties.group-by-country', [
            'properties' => $properties,
            'countryName' => $countryName,
            'propertiesGrouped' => $propertiesGrouped
        ]);

    } catch (\Illuminate\Contracts\Encryption\DecryptException $e) {
        abort(404);
    }
}


//recherche par categorie
public function categorie($locale, $slug)
{

    $category = Category::where('slug', $slug)->firstOrFail();

    // 2. Récupérer les propriétés et les grouper par le pays (situé dans la table details)
    $propertiesGroupedByCountry = Property::where('category_id', $category->id)
        ->with(['details', 'images', 'category'])
        ->latest()
        ->get()
        ->groupBy('details.country'); // On groupe par la colonne 'country' de la table 'property_details'

    return view('properties.categories.show', [
        'category' => $category,
        'propertiesGrouped' => $propertiesGroupedByCountry
    ]);
}



//services
public function services($locale)
    {
        $routeName = request()->route()->getName();

        // Détermination du type d'offre et des textes selon la route
       $config = match($routeName) {
    'services.vente' => [
        'type' => 'Vente',
        'title' => __('messages.service_vente_title'),
        'subtitle' => __('messages.service_vente_subtitle')
    ],
    'services.location' => [
        'type' => 'Location',
        'title' => __('messages.service_location_title'),
        'subtitle' => __('messages.service_location_subtitle')
    ],
    'services.reservation' => [
        'type' => 'Réservation',
        'title' => __('messages.service_reservation_title'),
        'subtitle' => __('messages.service_reservation_subtitle')
    ],
};

        // Récupération des biens filtrés
        $properties = Property::where('offer_type', $config['type'])
            ->with(['category', 'details', 'images'])
            ->latest()
            ->paginate(12);

        return view('services.index', compact('properties', 'config'));
    }


    public function edit(Property $property)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Property $property)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        //
    }
}

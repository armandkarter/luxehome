<?php
namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyInquiry;
use App\Mail\InquiryConfirmation;
use App\Mail\NewAdminNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use App\Models\Contact;
use App\Mail\ContactAdminMail;
use App\Mail\ContactClientMail;

class InquiryController extends Controller
{
    public function store($locale, $id, Request $request)
    {
        // 1. Validation des données entrantes
        $validator = Validator::make($request->all(), [
            'name'        => 'required|string|max:255',
            'email'       => 'required|email',
            'typeAction'  => 'required|string',
            'visit_date'  => 'required_if:typeAction,Location|nullable|string',
            'visit_time'  => 'required_if:typeAction,Location|nullable|string',
            'phone'       => 'required|string',
            'id_card' => 'required_if:typeAction,Location,Réservation|nullable|string',
            'message'      => 'required_if:typeAction,Vente|nullable|string',

            // Correction ici : on attend 'arrival_date' et 'nights' si Réservation
            'arrival_date'  => 'required_if:typeAction,Réservation|nullable|date',
            'nights'        => 'required_if:typeAction,Réservation|nullable|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // 2. Récupération de la propriété
        $property = Property::findOrFail($id);

        // 3. Sauvegarde en Base de Données
        $inquiry = PropertyInquiry::create([
            'property_id' => $property->id,
            'type_action' => $request->typeAction,
            'name'        => $request->name,
            'email'       => $request->email,
            'phone'       => $request->phone,
            'id_card'     => $request->id_card,
            'visit_date'  => $request->visit_date,
            'visit_time'  => $request->visit_time,
            'nights'      => $request->nights,
            'arrival_date' => $request->arrival_date,
            'message' => $request->message,
            'price' => $property->price, // On stocke le prix au moment de l'inquiry pour référence future
            'objet' => $request->objet,
            'status' => 'pending', // Statut initial
        ]);

        // 4. Envoi des Emails (Asynchrone via Queue si possible plus tard)
        try {
            // Mail de remerciement au client
            Mail::to($inquiry->email)->send(new InquiryConfirmation($inquiry, $property));
            
            // Notification pour l'équipe LuxeHabitat
            Mail::to('support@luxehomehub.com')->send(new NewAdminNotification($inquiry, $property));
        } catch (\Exception $e) {
            // On log l'erreur mais on ne bloque pas la réponse pour l'utilisateur
            Log::error("Erreur envoi mail : " . $e->getMessage());
        }

        // 5. Réponse JSON pour Alpine.js
        return response()->json([
            'message' => __('messages.api_inquiry_success'),
            'inquiry_id' => $inquiry->id
        ], 200);
    }

 public function contact($locale, Request $request)
{
    // 1. Validation
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'subject' => 'required|string',
        'message' => 'required|string|min:10',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // 2. Enregistrement en base de données
    $contact = Contact::create($request->all());

    // 3. Envoi des Mails
    try {
        // Mail pour l'Admin
        Mail::to('support@luxehomehub.com')->send(new ContactAdminMail($contact));

        // Mail de confirmation pour le Client
        Mail::to($contact->email)->send(new ContactClientMail($contact));
    } catch (\Exception $e) {
        // On log l'erreur mais on ne bloque pas la réponse succès pour l'utilisateur
        Log::error("Erreur envoi mail : " . $e->getMessage());
    }

    return response()->json([
        'message' => __('messages.api_contact_success')
    ], 200);
}
}
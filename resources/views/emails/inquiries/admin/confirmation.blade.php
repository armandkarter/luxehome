@component('mail::message')
# 📢 Nouveau Dossier : {{ strtoupper($inquiry->type_action) }}

Le client **{{ $inquiry->name }}** vient de soumettre une demande pour le bien : **{{ $property->title }}**.



@if($inquiry->type_action === 'Location')
### 💰 Transparence Financière
**Montant total à encaisser : {{ number_format($property->price * 5, 0, ',', ' ') }} €** (équivalent à {{ number_format($property->price * 5, 0, ',', ' ') }} € pour les 3 mois d'avance + caution + frais)
> **Détail du calcul (Standard) :**
> * 3 mois d'avances sur loyer
> * 1 mois de caution
> * 1 mois de frais d'agence
@else
> **Détail du calcul (Séjour) :**
> * Tarif : {{ number_format($property->price / ($inquiry->nights ?: 1), 0, ',', ' ') }} € / nuit
> * Durée : {{ $inquiry->nights }} nuit(s)
> * Total : {{ number_format($property->price * $inquiry->nights, 0, ',', ' ') }} €
@endif

---

### 👤 Profil du Prospect
* **Nom :** {{ $inquiry->name }}
* **Email :** {{ $inquiry->email }}
* **Téléphone :** {{ $inquiry->phone }}
* **Pièce d'Identité :** {{ $inquiry->id_card }}

### 📋 Détails de la Demande
@if($inquiry->type_action === 'Réservation')
* **Check-in :** {{ \Carbon\Carbon::parse($inquiry->arrival_date)->format('d/m/Y') }}
* **Check-out :** {{ \Carbon\Carbon::parse($inquiry->arrival_date)->addDays($inquiry->nights)->format('d/m/Y') }}
@else
* **Rendez-vous :** Le {{ \Carbon\Carbon::parse($inquiry->visit_date)->format('d/m/Y') }} à {{ $inquiry->visit_time }}
@endif

@if($inquiry->message)
**Message client :** {{ $inquiry->message }}
@endif

---

@component('mail::button', ['url' => 'https://wa.me/' . preg_replace('/[^0-9]/', '', $inquiry->phone), 'color' => 'success'])
Contacter via WhatsApp
@endcomponent

**Action administrative :**
1. Vérifiez la disponibilité réelle du bien.
2. Envoyez les coordonnées de paiement (Orange Money/Virement).
3. Ne délivrez le **Pass Visite** qu'après encaissement effectif.
@endcomponent
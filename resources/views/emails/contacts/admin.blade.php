@component('mail::message')
# Nouvelle Demande de Contact

Vous avez reçu un nouveau message via le site **Luxe Habitat**.

**Détails du prospect :**
- **Nom :** {{ $contact->name }}
- **Email :** {{ $contact->email }}
- **Projet :** {{ ucfirst($contact->subject) }}

**Message :**
{{ $contact->message }}

@component('mail::button', ['url' => config('app.url') . '/' . app()->getLocale() . '/admin/contacts'])
Voir dans l'administration
@endcomponent

Cordialement,<br>
L'Automate {{ config('app.name') }}
@endcomponent
<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Property;
use App\Models\PropertyInquiry;

class NewAdminNotification extends Mailable
{
    use Queueable, SerializesModels;

    // On déclare les propriétés pour qu'elles soient accessibles dans la vue Blade
    public $inquiry;
    public $property;

    /**
     * On reçoit les instances du modèle via le contrôleur
     */
    public function __construct(PropertyInquiry $inquiry, Property $property)
    {
        $this->inquiry = $inquiry;
        $this->property = $property;
    }

    /**
     * Construction du mail
     */
    public function build()
    {
        return $this->subject('🚨 NOUVELLE DEMANDE : ' . $this->inquiry->name)
                    ->markdown('emails.inquiries.admin.confirmation');
    }
}
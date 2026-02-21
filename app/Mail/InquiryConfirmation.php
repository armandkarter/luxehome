<?php

namespace App\Mail;

use App\Models\Property;
use App\Models\PropertyInquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InquiryConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $inquiry;
    public $property;

    public function __construct(PropertyInquiry $inquiry, Property $property)
    {
        $this->inquiry = $inquiry;
        $this->property = $property;
    }

    public function build()
    {
        return $this->subject(__('messages.mail_inquiry_subject', [
                'type' => ucfirst($this->property->offer_type), 
                'title' => $this->property->title
            ]))
            ->markdown('emails.inquiries.customers.confirmation');
    }
}
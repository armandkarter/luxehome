<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyInquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id', 'type_action', 'name', 'email', 
        'phone', 'id_card', 'visit_date', 'visit_time',
        'arrival_date', 'message', 'nights', 'objet', 'price', 'status'
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}

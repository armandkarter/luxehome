<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PropertyDetail extends Model
{
    use HasFactory;

    protected $fillable = ['property_id', 'description', 'area', 'bedrooms', 'bathrooms','country', 'city', 'address','country_image', 'amenities'];

    // Indispensable car amenities est stocké en JSON dans la table
    protected $casts = [
        'amenities' => 'array',
    ];

    public function property(): BelongsTo
    {
        return $this->belongsTo(Property::class);
    }

    public function country()
{
    return $this->belongsTo(Country::class, 'country_id');
}
}

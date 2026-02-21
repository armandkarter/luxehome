<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Property extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'title', 'slug', 'price', 'price_label', 'offer_type', 'status', 'is_featured'];

    // Pour utiliser le slug dans l'URL à la place de l'ID
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function details(): HasOne
    {
        return $this->hasOne(PropertyDetail::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(PropertyImage::class)->orderBy('sort_order', 'asc');
    }


    // Petit bonus : Une fonction pour obtenir l'image principale directement
    public function mainImage()
    {
        return $this->hasOne(PropertyImage::class)->where('is_main', true);
    }

    protected static function boot()
{
    parent::boot();

    static::creating(function ($model) {
        if (empty($model->uuid)) {
            $model->uuid = (string) Str::uuid();
        }
    });
}

public function getUrlIdentifierAttribute()
{
    // On prend le slug et on attache les 8 premiers caractères de l'UUID
    return $this->slug . '-' . substr($this->uuid, 0, 8);
}

protected $appends = ['main_image_url'];

public function getMainImageUrlAttribute() {
    $mainImg = $this->images()->where('is_main', true)->first() ?? $this->images()->first();
    return $mainImg ? asset('uploads/properties/' . $mainImg->path) : null;
}
}

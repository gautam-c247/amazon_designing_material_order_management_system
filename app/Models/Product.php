<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * Get the brand that owns the product.
     */
    protected $fillable = ['name', 'brand_id', 'description','service_status'];
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get the media for the product.
     */
    public function media()
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}

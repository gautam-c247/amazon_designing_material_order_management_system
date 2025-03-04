<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Brand extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $fillable = [
        'name', 'category_id', 'logo', 'website_url', 'about', 'pronunciation', 'instagram_url'
    ];

    /**
     * The category that this brand belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    /**
     * Get the logo URL.
     *
     * @param  string  $value
     * @return string|null
     */
    public function getLogoAttribute($value)
    {
        return $value ? asset('storage/'.$value) : null;
    }
}

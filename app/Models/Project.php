<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'user_id',
        'product_id',
        'service_id',
        'priority',
        'guidelines',
        'notes',
        'estimated_delivery_date',
        'status',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}

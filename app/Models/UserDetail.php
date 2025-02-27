<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\Scopes\OrderByScope;

class UserDetail extends Model
{
    use HasFactory;
    //
    protected $fillable = [
        'gender',
        'date_of_birth',
        'profile_picture',
        'contact_no',
        'location',
        'country_code'
    ];
    protected static function booted()
    {
        static::addGlobalScope(new OrderByScope());
    }
}

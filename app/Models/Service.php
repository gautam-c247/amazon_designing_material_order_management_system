<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'category', 'status', 'credit'];
    protected $guarded = ['id'];

    public function projects()
    {
        return $this->belongsToMany(Project::class,'project_service');
    }
}

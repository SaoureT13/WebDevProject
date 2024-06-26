<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parcours extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'school_year',
        'user_id'
    ];

    public function users(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(User::class);
    }

    public function professeurs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Professeur::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Professeur extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'contact',
        'last_student_assigned_at',
    ];

    public function users(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(User::class);
    }

    public function parcours(): BelongsTo{
        return $this->belongsTo(Parcours::class);
    }
}

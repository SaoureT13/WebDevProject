<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    use HasFactory;

    protected $fillable = [
        'theme',
        'memory_problems',
        'global_objective',
        'specific_objective',
        'expected_result',
        'deposit_date',
        'request_status',
        'societe_id',
        'commentaire_id',
    ];

    protected $casts = [
        'is_active' => 'boolean', // Définir le type de champ comme booléen
    ];

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function commentaire(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Commentaire::class, 'commentaire_id');
    }

    public function societe(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Societe::class, 'societe_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commentaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'comment_theme',
        'comment_problems',
        'comment_global_obj',
        'comment_specific_obj',
        'comment_result_expected',
    ];

    public function demande(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Demande::class);
    }
}

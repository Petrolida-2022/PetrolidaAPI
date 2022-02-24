<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'ord_competition_id', 'register_code', 'name', 'email', 'phone', 'file'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ord_competition()
    {
        return $this->belongsTo(OrdCompetition::class);
    }
}

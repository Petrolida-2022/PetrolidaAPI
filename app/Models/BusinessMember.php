<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'business_competition_id', 'register_code', 'name', 'email', 'phone', 'file'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function business_competition()
    {
        return $this->belongsTo(BusinessCompetition::class);
    }
}

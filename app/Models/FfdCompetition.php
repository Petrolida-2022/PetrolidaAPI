<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FfdCompetition extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'register_code', 'name', 'email', 'team_name', 'university', 'phone', 'file', 'payment'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ffd_member()
    {
        return $this->hasMany(FfdCompetition::class);
    }
}

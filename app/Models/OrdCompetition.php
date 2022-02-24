<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdCompetition extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'register_code', 'leader_name', 'leader_email', 'team_name', 'university', 'phone', 'leader_file'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ord_member()
    {
        return $this->hasMany(OrdMember::class);
    }
}

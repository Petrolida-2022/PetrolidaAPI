<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PetrosmartMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'register_code', 'name', 'email', 'team_name', 'university', 'phone', 'file'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function petrosmart_member()
    {
        return $this->hasMany(PetrosmartMember::class);
    }
}

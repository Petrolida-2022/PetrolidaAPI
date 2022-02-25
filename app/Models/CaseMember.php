<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaseMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'case_competition_id', 'register_code', 'name', 'email', 'phone', 'file'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function case_competition()
    {
        return $this->belongsTo(CaseCompetition::class);
    }
}

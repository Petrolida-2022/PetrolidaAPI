<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'stock_competition_id', 'register_code', 'name', 'email', 'phone', 'file'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stock_competition()
    {
        return $this->belongsTo(StockCompetition::class);
    }
}

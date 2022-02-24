<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // ORDC Relations
    public function ord_competition()
    {
        return $this->hasOne(OrdCompetition::class);
    }

    public function ord_member()
    {
        return $this->hasMany(OrdMember::class);
    }

    // PAPER Relations
    public function paper_competition()
    {
        return $this->hasOne(PaperCompetition::class);
    }

    public function paper_member()
    {
        return $this->hasMany(PaperMember::class);
    }

    // Stock Trading Relations
    public function stock_competition()
    {
        return $this->hasOne(StockCompetition::class);
    }

    public function stock_member()
    {
        return $this->hasOne(StockMember::class);
    }
}

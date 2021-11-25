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
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function items() {
        return $this->hasMany(AuctionItem::class, 'owner');
    }

    public function participatesIn() {
        return $this->hasMany(ParticipantsOf::class, 'participant');
    }

    public function is_admin() {
        return $this->typ === 'admin';
    }

    public function is_auctioneer() {
        return $this->typ === 'auctioneer';
    }

    public function auctioneer_auctions() {
        return $this->hasMany(AuctioneerOf::class, 'user');
    }
}

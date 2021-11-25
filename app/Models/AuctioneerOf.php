<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuctioneerOf extends Model
{
    public $timestamps = false;
    protected $fillable = ['user', 'auction'];
    protected $table = 'auctioneers_of';

    public function auctioneer() {
        return $this->belongsTo(User::class, 'user', 'id');
    }
    
    public function auction() {
        return $this->morphOne(Auction::class, 'myAuctioneer');
    }
}

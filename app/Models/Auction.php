<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    protected $fillable = ['item', 'is_open', 'is_selling', 'is_approved', 'starting_price', 'start_time', 'is_active', 'closing_price', 'time_limit', 'bid_min', 'bid_max'];

    public function winner() {
        return $this->belongsTo(User::class, 'winner');
    }

    public function auctionItem() {
        return $this->belongsTo(AuctionItem::class, 'item');
    }

    public function participants() {
        return $this->hasMany(ParticipantsOf::class, 'auction');
    }

    public function myAuctioneer() {
        return $this->morphTo();
    }
}

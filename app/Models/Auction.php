<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    use HasFactory;

    public function winner() {
        return $this->belongsTo(User::class, 'winner');
    }

    public function auctionItem() {
        return $this->belongsTo(AuctionItem::class, 'id');
    }
}

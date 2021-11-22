<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuctionItem extends Model
{
    protected $fillable = ['item_name', 'owner', 'description', 'image'];

    public function auctionOwner() {
        return $this->belongsTo(User::class, 'owner', 'id');
    }

    public function auctions() {
        return $this->hasMany(Auction::class);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auction;

class AuctionController extends Controller
{
    function showRecent() {
        return Auction::all();
    }
}

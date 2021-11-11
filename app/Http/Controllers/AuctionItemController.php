<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AuctionItem;


class AuctionItemController extends Controller
{
    function showAll() {
        return AuctionItem::all();
    }
}

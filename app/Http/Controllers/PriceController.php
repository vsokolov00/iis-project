<?php

namespace App\Http\Controllers;
use App\Models\Auction;

class PriceController extends Controller
{
    public function index($id)
    {
        $auction = Auction::with('auctionItem')->where('id', '=', $id)->first();
        $participants = Auction::find($id)->participants;

        if(isset($participants))
        {
            $price = $participants->sum('last_bid') + $auction->start_price;
            $lastBid = $participants->sortBy('date_of_last_bid')->last()->last_bid;
        }
        else
        {
            $price = $auction->start_price;
            $lastBid = 0;
        }

        return view('components/price', ["price" => $price, "lastBid" => $lastBid]);
    }
}

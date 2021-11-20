<?php

namespace App\Http\Controllers;
use App\Models\Auction;
use Psr\Log\NullLogger;

class PriceController extends Controller
{
    public function index($id)
    {
        $auction = Auction::with('auctionItem')->where('id', '=', $id)->first();

        if($auction == null)
            return;

        $participants = Auction::find($id)->participants;

        if(!$participants->isEmpty())
        {
            $price = $participants->sum('last_bid') + $auction->starting_price;
            $lastBid = $participants->sortBy('date_of_last_bid')->last()->last_bid;

            if($auction->time_limit > now())
                return view('components/price', ["price" => $price, "lastBid" => $lastBid]);
            else
                return view('components/price', ["price" => $price]);
        }
        else
        {
            $price = $auction->starting_price;

            if($auction->time_limit > now())
                return view('components/price', ["price" => $price, "lastBid" => 0]);
            else
            return view('components/price', ["price" => $price]);
        }
    }
}

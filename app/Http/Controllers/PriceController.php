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
                //return view('components/price', ["price" => $price, "lastBid" => $lastBid]);
                return '<div class="yellow-text">'.$price.' Kč</div>
                        <div class="green-text">(+'.$lastBid.' Kč)</div>';
            else
                //return view('components/price', ["price" => $price]);
                return '<div class="yellow-text">'.$price.' Kč</div>';
        }
        else
        {
            $price = $auction->starting_price;

            if($auction->time_limit > now()){
                //return view('components/price', ["price" => $price, "lastBid" => 0]);
                return '<div class="yellow-text">'.$price.' Kč</div>
                        <div class="green-text">(+0 Kč)</div>';
            }
            else{
                //return view('components/price', ["price" => $price]); 
                return '<div class="yellow-text">'.$price.' Kč</div>';
            }
           
        }
    }
}

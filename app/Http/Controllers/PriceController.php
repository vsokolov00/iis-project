<?php

namespace App\Http\Controllers;
use App\Models\Auction;
use Psr\Log\NullLogger;
use Auth;

class PriceController extends Controller
{
    public function index($id)
    {
        $auction = Auction::with('auctionItem')->where('id', '=', $id)->first();
        if($auction == null)
            return;

        $participants = Auction::find($id)->participants;

        if(!$auction->is_open)
            return '<div class="yellow-text" id="price">'.$auction->starting_price.' Kč</div>';

        if(!$participants->isEmpty())
        {
            $price = $participants->sum('last_bid') + $auction->starting_price;
            $lastPartc = $participants->sortBy('date_of_last_bid')->last();
            $lastBid = $lastPartc->last_bid;
            
            if (Auth::check()) {
                if(!$participants->where("participant", Auth::user()->id)->isEmpty())
                    $youWinning = $lastPartc->participant == Auth::user()->id && $lastBid != 0;
            }

            if($auction->time_limit > now()) {
                if ($auction->is_selling) {
                    if(isset($youWinning)) {
                        if ($youWinning) {
                            return '<div class="yellow-text" id="price">'.$price.' Kč</div>
                                    <div class="green-text" id="winStatus">(vyhráváte)</div>';
                        } else {
                            return '<div class="yellow-text" id="price">'.$price.' Kč</div>
                                    <div class="red-loosing" id="winStatus">(prohráváte)</div>';
                        }
                    } else {
                        return '<div class="yellow-text" id="price">'.$price.' Kč</div>';
                    }
                }
                else {
                    return '<div class="yellow-text" id="price">'.$price.' Kč</div>'; 
                }
            }
            else
                return '<div class="yellow-text" id="price">'.$price.' Kč</div>';
        }
        else
        {
            $price = $auction->starting_price;

            if($auction->time_limit > now()){
                if ($auction->is_selling)
                    return '<div class="yellow-text" id="price">'.$price.' Kč</div>';
                else 
                    return '<div class="yellow-text" id="price">'.$price.' Kč</div>';
            }
            else{ 
                return '<div class="yellow-text" id="price">'.$price.' Kč</div>';
            }
           
        }
    }
}

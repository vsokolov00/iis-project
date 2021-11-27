<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Auction;
use App\Models\AuctionItem;
use Auth;

class CreateAuctionFormController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        return view('auction/create-auction');
    }

    public function create(Request $req) {
        $auction_item = new AuctionItem();
        $auction = new Auction();

        $auction_item->item_name = $req->name;
        
        if ($req->hasFile('image')) {
            $auction_item->image = basename($req->image->store('public/images', 's3'));
        } else {
            $auction_item->image = "empty.png";
        }
        $auction_item->description = $req->description;
        $auction_item->owner = Auth::user()->id;

        $auction->item = AuctionItem::create($auction_item->toArray())->id;

        $auction->is_open = $req->is_open;
        $auction->is_selling = $req->is_selling;
        $auction->starting_price = $req->stratPrice;
        $auction->start_time = $req->auctionStart;
        $auction->time_limit = $req->auctionEnd;
        $auction->closing_price = $req->closingPrice;
        if($req->is_open){
            $auction->bid_min = $req->bid_min;
            $auction->bid_max = $req->bid_max;
        }

        Auction::create($auction->toArray());

        return redirect(route('userAuctions'));
    }
}

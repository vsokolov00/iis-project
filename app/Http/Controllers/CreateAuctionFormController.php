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
        //TODO
        // $validator = Validator::make($req->toArray(),
        // [
        //     'item_name' => 'required|string|max:255',
        //     'description' => 'required|string|max:255',
        //     'image' => 'string|max:255',
        //     'password' => 'required|string|min:6|confirmed',
        //     'start_time' => 'required|integer',
        // ]);

        // if ($validator->fails()) {
        //     return response()->json(['errors'=>$validator->errors()]);
        // } else {
        //     return "";
        // }

        $auction_item = new AuctionItem();
        $auction = new Auction();

        $auction_item->item_name = $req->name;

        if ($req->hasFile('image')) {
            $auction_item->image = basename($req->image->store('public/images'));
        }
        $auction_item->description = $req->description;
        $auction_item->owner = Auth::user()->id;

        $auction->item = AuctionItem::create($auction_item->toArray())->id;

        $auction->is_open = $req->is_open;
        $auction->is_selling = $req->is_selling;
        #TODO approved
        $auction->is_approved = "1";
        $auction->starting_price = $req->stratPrice;
        $auction->start_time = $req->auctionStart;
        $auction->time_limit = $req->auctionEnd;
        $auction->closing_price = $req->closingPrice;

        Auction::create($auction->toArray());

        #redirect to the list of created auctions TODO
        return redirect('/');
    }
}

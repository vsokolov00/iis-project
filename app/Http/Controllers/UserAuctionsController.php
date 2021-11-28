<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Auction;
use App\Models\AuctionItem;
use Auth;
use App;
use App\Models\ParticipantsOf;
use Monolog\Handler\FirePHPHandler;

use function PHPUnit\Framework\isEmpty;

class UserAuctionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function updateAuction(Request $request)
    {
        if(isset($request->deleteItem) && isset($request->id))
        {
            $targetAuction = Auction::with('auctionItem')->where('id', $request->id)->first();

            if($targetAuction != null)
                if($targetAuction->auctionItem->owner == Auth::user()->id || Auth::user()->is_admin())
                    Auction::where('id', $request->id)->delete();
        }
        else if(isset($request->name) && isset($request->min_bid) && isset($request->max_bid) &&
           isset($request->startPrice) && isset($request->auctionStart) && isset($request->auctionEnd) &&
           isset($request->is_selling) && isset($request->is_open) && isset($request->id))
           {
                $auction = Auction::with('auctionItem')->where('id', '=', $request->id)->first();

                if($auction->auctionItem->owner == Auth::user()->id)
                {
                    $auction->auctionItem->item_name = $request->name;
                    $auction->auctionItem->description = $request->description;

                    if ($request->hasFile('image')) {
                        $auction->auctionItem->image = basename($request->image->store('public/images', 's3'));
                    }

                    $auction->bid_min = $request->min_bid;
                    $auction->bid_max = $request->max_bid;
                    $auction->is_open = $request->is_open;
                    $auction->is_selling = $request->is_selling;
                    $auction->starting_price = $request->startPrice;
                    $auction->is_approved = null;
                    $auction->start_time = $request->auctionStart;
                    $auction->time_limit = $request->auctionEnd;

                    $auction->auctionItem->save();
                    $auction->save();
                }
           }

        return $this->index();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $items = AuctionItem::select('id')->where('owner','=',Auth::user()->id)->get();
        $auctions = Auction::with('auctionItem')->whereIn('item', $items)->get();

        $actualPrices = [];
        foreach($auctions as $auction){
            if($auction->time_limit < now())
                $actualPrices[$auction->id] = Auction::find($auction->id)->participants->sum('last_bid') + Auction::find($auction->id)->starting_price;
        }

        App::setLocale('cs');
        return view('user/userAuctions', ["auctions" => $auctions, "actualPrices" => $actualPrices]);
    }

    public function wonAuctions() {
        $wonAuctions = Auction::with('auctionItem')->where('winner', Auth::user()->id)->get();
        $auctions = [];
        $bids = [];

        foreach ($wonAuctions as $auction) {
            $partic = ParticipantsOf::where('participant', Auth::user()->id)->where('auction', $auction->id)->first();

            if($partic != null && $partic->is_approved == 1)
            {
                array_push($auctions, $auction);

                if ($auction->is_open) {
                    $bids[$auction->id] = Auction::find($auction->id)->participants->sum('last_bid');
                } else {
                    $bid = Auction::find($auction->id)->participants->where('participant', Auth::user()->id)->where('auction', $auction->id)->first()->last_bid;
                }
            }
        }

        return view('allAuctions', ["auctions" => $auctions, "title" => "Vyhrané aukce", "bids" => $bids]);
    }

    private function getAllBids($auctions)
    {
        $bids = [];
        foreach ($auctions as $auction) {
            $bids[$auction->id] = Auction::find($auction->id)->participants->sum('last_bid');
        }

        return $bids;
    }
}

<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Auction;
use App\Models\AuctionItem;
use Auth;
use App;

class AuctionApprovalController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function updateAuction(Request $request)
    {
        if(isset($request->name) && isset($request->description) &&
           isset($request->startPrice) && isset($request->auctionStart) && isset($request->auctionEnd) &&
           isset($request->is_selling) && isset($request->is_open) && isset($request->id))
           {
                $auction = Auction::with('auctionItem')->where('id', '=', $request->id)->first();

                if($auction->auctionItem->owner == Auth::user()->id)
                {
                    $auction->auctionItem->item_name = $request->name;
                    $auction->auctionItem->description = $request->description;

                    if ($request->hasFile('image')) {
                        $auction->auctionItem->image = basename($request->image->store('public/images'));
                    }

                    $auction->is_open = $request->is_open;
                    $auction->is_selling = $request->is_selling;
                    $auction->starting_price = $request->startPrice;
                    $auction->start_time = $request->auctionStart;
                    $auction->time_limit = $request->auctionEnd;

                    $auction->auctionItem->save();
                    $auction->save();
                }
           }
        else if(isset($request->auctionId) && isset($request->approved))
            if($request->approved >= 0 && $request->approved <= 1)
            {
                $auction = Auction::where('id', '=', $request->auctionId)->first();

                if($auction != NULL)
                {
                    $auction->is_approved = $request->approved;

                    if($auction->start_time < now())
                    {
                        $auction->time_limit = date("Y-m-d H:i:s", strtotime(now()) + (strtotime($auction->time_limit) - strtotime($auction->start_time)));
                        $auction->start_time = now();
                    }

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
        $auctions = Auction::with('auctionItem')->where('is_approved', '=', NULL)->whereIn('item', $items)->get();

        App::setLocale('cs');
        return view('liciator/auction-approval', ["auctions" => $auctions]);
    }
}

<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Auction;
use App\Models\AuctionItem;
use Auth;
use App;

class UserAuctionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
        
        App::setLocale('cs');
        return view('user/userAuctions', ["auctions" => $auctions]);
    }
}

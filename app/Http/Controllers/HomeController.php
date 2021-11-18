<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auction;
use App\Models\ParticipantsOf;
use App;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data = Auction::with('auctionItem')->where('start_time', '>', date('Y-m-d H:i:s'))->orderBy('start_time')->take(7)->get();
        $bids = [];
        foreach ($data as $auction) {
            $bids[$auction->id] = Auction::find($auction->id)->participants->sum('last_bid');
        }
        
        return view('home', ["auctions" => $data], ["bids" => $bids]);
    }
}

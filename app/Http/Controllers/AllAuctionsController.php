<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auction;
use App\Models\ParticipantsOf;
use App;
use Auth;

class AllAuctionsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function sellingAuctions()
    {
        $data = Auction::with('auctionItem')->where('is_selling', '=', '1')->where('is_approved', '=', '1')->orderBy('start_time')->get();

        App::setLocale('cs');
        return view('allAuctions', ["auctions" => $data, "title" => "Lidé prodávají"]);
    }

    public function buyingAuctions()
    {
        $data = Auction::with('auctionItem')->where('is_selling', '=', '0')->where('is_approved', '=', '1')->orderBy('start_time')->get();

        App::setLocale('cs');
        return view('allAuctions', ["auctions" => $data, "title" => "Lidé shánějí"]);
    }

    public function closestAuctions()
    {
        $data = Auction::with('auctionItem')->orderBy('start_time')->where('is_approved', '=', '1')->get();

        App::setLocale('cs');
        return view('allAuctions', ["auctions" => $data, "title" => "Nejbližší aukce"]);
    }

    public function userTakesPartIn() {
        $auctionIDsITakePartIt = Auth::user()->participatesIn->pluck('auction');

        $auctionsITakePartIn = Auction::with('auctionItem')->whereIn('id', $auctionIDsITakePartIt)->get();

        $bids = [];
        foreach ($auctionsITakePartIn as $auction) {
            $bids[$auction->id] = Auction::find($auction->id)->participants->sum('last_bid');
        }
        return view('allAuctions', ["auctions" => $auctionsITakePartIn, "title" => "Aukce, kterych jste se zůčastnil"]);
        return view('user/registeredAuctions', ["auctions" => $auctionsITakePartIn, "bids" => $bids]);
    }
}

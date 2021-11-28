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

    private function getAllBids($auctions)
    {
        $bids = [];

        foreach ($auctions as $auction) {
            $bids[$auction->id] = Auction::find($auction->id)->participants->sum('last_bid');
        }

        return $bids;
    }

    public function sellingAuctions()
    {
        $data = Auction::with('auctionItem')->where('is_selling', '=', '1')->where('is_approved', '=', '1')
            ->where('time_limit', '>', now())->orderBy('start_time')->get();

        App::setLocale('cs');
        return view('allAuctions', ["auctions" => $data, "bids" => $this->getAllBids($data), "title" => "Lidé prodávají"]);
    }

    public function buyingAuctions()
    {
        $data = Auction::with('auctionItem')->where('is_selling', '=', '0')->where('is_approved', '=', '1')
            ->where('time_limit', '>', now())->orderBy('start_time')->get();

        App::setLocale('cs');
        return view('allAuctions', ["auctions" => $data, "bids" => $this->getAllBids($data), "title" => "Lidé shánějí"]);
    }

    public function closestAuctions()
    {
        $data = Auction::with('auctionItem')->orderBy('start_time')->where('start_time', '>', now())->where('is_approved', '=', '1')->get();

        App::setLocale('cs');
        return view('allAuctions', ["auctions" => $data, "bids" => $this->getAllBids($data), "title" => "Nejbližší aukce"]);
    }

    public function activeAuctions()
    {
        $data = Auction::with('auctionItem')->orderBy('time_limit')->where('start_time', '<', now())
            ->where('time_limit', '>', now())->where('is_approved', '=', '1')->get();

        App::setLocale('cs');
        return view('allAuctions', ["auctions" => $data, "bids" => $this->getAllBids($data), "title" => "Aktivní aukce", "active" => True]);
    }
}

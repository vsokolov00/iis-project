<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auction;
use App;

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
}

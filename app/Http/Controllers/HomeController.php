<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auction;
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
        
        App::setLocale('cs');
        return view('home', ["auctions" => $data]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auction;
use App\Models\ParticipantsOf;
use Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class AuctionController extends Controller
{
    function showRecent() {
        return Auction::all();
    }

    function index($id) {
        $auction = Auction::with('auctionItem')->where('id', '=', $id)->get()->first();
        if(Auth::user() == null)
            $registered = "";
        else
            $registered =! ParticipantsOf::all()->where("participant", "=", Auth::user()->id)->where("auction", "=", $id)->isEmpty();
            
        if($auction->auctionItem->owner == Auth::user()->id)
            $registered = "2";       

        return view('auction/detailed-auction', ["auction" => $auction, "registered" => $registered]);
    }

    function bid(Request $req) {
        $participant = ParticipantsOf::where("participant", "=", Auth::user()->id)->where("auction", "=", $req->id)->first();
        if (!$participant == null) {
            $last_bid = $participant->last_bid + $req->bid;
            ParticipantsOf::where("participant", "=", Auth::user()->id)->where("auction", "=", $req->id)->update(['last_bid'=>$last_bid, 'date_of_last_bid'=>date('Y-m-d H:i:s')]);
       }
    }

    function time(){
        return date("c");
    }

    function price(){
        return '<div class="yellow-text">100 Kč</div> 
            <div class="green-text">(+5)</div>';
    }

    function register($id){
        $participant = new ParticipantsOf();
        $participant->participant = Auth::user()->id;
        $participant->auction = $id;
        $participant->is_approved = 0;
        $participant->registered_at = date("c");
        $participant->last_bid = 0;
        ParticipantsOf::create($participant->toArray());
        return redirect("/auction/$$id");
    }
}

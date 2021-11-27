<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auction;
use App\Models\User;
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
            $registered = 0;
        else{
            $registered =! ParticipantsOf::all()->where("participant", "=", Auth::user()->id)->where("auction", "=", $id)->isEmpty();
            if($auction->auctionItem->owner == Auth::user()->id)
                $registered = 2;

            $participant = ParticipantsOf::where("participant", "=", Auth::user()->id)->where("auction", "=", $id)->first();

            if($participant != null){

                if(!$auction->is_open){
                    if($participant->last_bid != 0)
                    $registered = 3;
                }

                if($participant->is_approved == 0)
                    $registered = 4;
            }
        }

        if($auction->is_open)
            $default_bid = $auction->min_bid;
        else
            $default_bid = Auction::find($auction->id)->participants->where('participant', Auth::user()->id)->first()->last_bid;

        if(!is_null($auction->winner)) {
            $winner = Auction::with('winner')->where('id', $id)->first();
            $winner = User::find($winner->winner);
        } else {
            $winner = null;
        }

        return view('auction/detailed-auction', ["auction" => $auction, "registered" => $registered, "winner" => $winner, "default_bid" => $default_bid]);
    }

    function bid(Request $req) {
        $auction = Auction::where("id", $req->id)->first();
        if($auction == null)
            return;

        if($auction->start_time < now() && $auction->time_limit > now()){
            $participant = ParticipantsOf::where("participant", "=", Auth::user()->id)->where("auction", "=", $req->id)->first();
            if (!$participant == null) {
                $last_bid = $participant->last_bid + $req->bid;
                ParticipantsOf::where("participant", "=", Auth::user()->id)->where("auction", "=", $req->id)->update(['last_bid'=>$last_bid, 'date_of_last_bid'=>date('Y-m-d H:i:s')]);
            }
        }
    }

    function time(){
        return date("c");
    }

    function register($id){
        $participant = new ParticipantsOf();
        $participant->participant = Auth::user()->id;
        $participant->auction = $id;
        $participant->last_bid = 0;
        $participant->is_approved = 1;
        ParticipantsOf::create($participant->toArray());
        return redirect("/auction/$$id");
    }
}

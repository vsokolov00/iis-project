<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auction;
use App\Models\User;
use App\Models\ParticipantsOf;
use App\Models\AuctioneerOf;
use Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class AuctionController extends Controller
{
    function showRecent() {
        return Auction::all();
    }

    function index($id) {
        /**
         *   0 - nepřihlášený
         *   1 - přihlášený, registrovaný na aukci
         *   2 - owner, nebo liciátor
         *   3 - uzavřená aukce a uživatel už přihodil
         *   4 - uživatel byl zamítnut liciátorem
         */
        $auction = Auction::with('auctionItem')->where('id', '=', $id)->get()->first();

        if($auction == null)
            return redirect('/');

        if(!Auth::check()) {
            $registered = 0;
        } else{
            $registered =! ParticipantsOf::all()->where("participant", "=", Auth::user()->id)->where("auction", "=", $id)->isEmpty();

            if($auction->auctionItem->owner == Auth::user()->id || !AuctioneerOf::all()->where("user", Auth::user()->id)->where("auction", $id)->isEmpty())
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
        if (Auth::check()) {
            if($auction->is_open ||
                Auction::find($auction->id)->participants->where('participant', Auth::user()->id)->first() == null)
                $default_bid = $auction->min_bid;
            else
                $default_bid = Auction::find($auction->id)->participants->where('participant', Auth::user()->id)->first()->last_bid;
        } else {
            $default_bid = $auction->min_bid;
        }


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
                if ($auction->is_selling) {
                    $last_bid = $participant->last_bid + $req->bid;
                    ParticipantsOf::where("participant", "=", Auth::user()->id)->where("auction", "=", $req->id)->update(['last_bid'=>$last_bid]);
                }
                else
                {
                    if($auction->is_open){
                        $participants = Auction::find($req->id)->participants;

                        if(!$participants->isEmpty()) {
                            $price = $participants->sum('last_bid') + $auction->starting_price;

                            if ($price - $req->bid >= 0) {
                                $last_bid = $participant->last_bid - $req->bid;
                                ParticipantsOf::where("participant", "=", Auth::user()->id)->where("auction", "=", $req->id)->update(['last_bid'=>$last_bid]);
                            }
                        }
                    }else{
                        $last_bid = $participant->last_bid - $req->bid;
                        ParticipantsOf::where("participant", "=", Auth::user()->id)->where("auction", "=", $req->id)->update(['last_bid'=>$last_bid]);
                    }
                }
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

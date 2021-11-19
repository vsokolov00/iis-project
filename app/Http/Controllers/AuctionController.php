<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auction;
use App\Models\ParticipantsOf;
use Auth;

class AuctionController extends Controller
{
    function showRecent() {
        return Auction::all();
    }

    function index($id) {
        $auction = Auction::with('auctionItem')->where('id', '=', $id)->get()->first();
        return view('auction/detailed-auction', ["auction" => $auction, "bid" => "200"]);
    }

    function bid($id, Request $req) {
        if (!Auction::find($id)->participants->where('participant', '=', Auth::user()->id)->isEmpty()) {
            $last_bid = ParticipantsOf::where('participant', Auth::user()->id)->get('last_bid')->first()->last_bid;
            $new_bid = $last_bid + $req->bid;
            ParticipantsOf::where('participant', Auth::user()->id)->where('auction', $id)->update(['last_bid'=> $new_bid]);
        } else {
            $participant = new ParticipantsOf();
            $participant->participant = Auth::user()->id;
            $participant->auction = $id;
            #TODO
            $participant->is_approved = 1;
            $participant->last_bid = $req->bid;

            ParticipantsOf::create($participant->toArray());
        }

        return $this->index($id);
    }

    function time(){
        return date("c");
    }
}

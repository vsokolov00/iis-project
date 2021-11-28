<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Auction;
use App\Models\AuctionItem;
use App\Models\AuctioneerOf;
use App\Models\ParticipantsOf;
use Auth;
use App;
use Doctrine\DBAL\Driver\IBMDB2\Result;
use Illuminate\Support\Facades\Auth as FacadesAuth;

use function PHPUnit\Framework\isEmpty;

class AuctionApprovalController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function updateAuction(Request $request)
    {
        if(!Auth::user()->is_auctioneer() && !Auth::user()->is_admin())
            return redirect('/');

        if(isset($request->deleteItem) && isset($request->id))
        {
            $targetAuction = Auction::with('auctionItem')->where('id', $request->id)->first();

            if($targetAuction != NULL)
                if($targetAuction->auctionItem->owner == Auth::user()->id || Auth::user()->is_admin())
                    Auction::where('id', $request->id)->delete();
        }
        if(isset($request->name) &&
           isset($request->startPrice) && isset($request->auctionStart) && isset($request->auctionEnd) &&
           isset($request->is_selling) && isset($request->is_open) && isset($request->id))
           {
                $auction = Auction::with('auctionItem')->where('id', '=', $request->id)->first();

                if($auction->auctionItem->owner == Auth::user()->id || Auth::user()->is_admin() || Auth::user()->is_auctioneer())
                {
                    $auction->auctionItem->item_name = $request->name;
                    $auction->auctionItem->description = $request->description;

                    if ($request->hasFile('image')) {
                        $auction->auctionItem->image = basename($request->image->store('public/images'));
                    }

                    $auction->is_open = $request->is_open;
                    $auction->is_selling = $request->is_selling;
                    $auction->starting_price = $request->startPrice;
                    $auction->start_time = $request->auctionStart;
                    $auction->time_limit = $request->auctionEnd;

                    $auction->auctionItem->save();
                    $auction->save();
                }
           }
        else if(isset($request->auctionId) && isset($request->approved)) {
            if($request->approved >= 0 && $request->approved <= 1)
            {
                $auction = Auction::where('id', '=', $request->auctionId)->first();

                if($auction != NULL && $auction->is_approved == NULL)
                {
                    $auction->is_approved = $request->approved;

                    //save only the information about the approved auctions
                    if ($auction->is_approved) {
                        AuctioneerOf::create(['user'=>Auth::user()->id, 'auction'=>$request->auctionId]);
                    }

                    if($auction->start_time < now())
                    {
                        $auction->time_limit = date("Y-m-d H:i:s", strtotime(now()) + (strtotime($auction->time_limit) - strtotime($auction->start_time)));
                        $auction->start_time = now();
                    }

                    $auction->save();
                }
            }
        }

        return $this->index();
    }

    public function invalidateAuction(Request $request)
    {
        if(isset($request->id))
        {
            if(!empty(AuctioneerOf::where('user', Auth::user()->id)
                ->where('auction', $request->id)->pluck('auction')))
            {
                Auction::where('id', $request->id)->update(['is_approved' => null]);
                AuctioneerOf::where('auction', $request->id)->where('user', Auth::user()->id)->delete();
                return response('OK', 200);
            }

            return abort(403);
        }

        return abort(404);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(!Auth::user()->is_auctioneer() && !Auth::user()->is_admin())
            return redirect('/');

        $auctions = Auction::with('auctionItem', 'auctionItem.auctionOwner')->where('is_approved', '=', NULL)->get();

        return view('liciator/auction-approval', ["auctions" => $auctions, "title" => "Neschválené aukce"]);
    }

    public function approvedByYou() {
        $auctionsIapproved = AuctioneerOf::where('user', Auth::user()->id)->pluck('auction');

        if(Auth::user()->is_admin())
            $auctions = Auction::with('auctionItem', 'auctionItem.auctionOwner')->where('is_approved', '=', '1')->get();
        else
            $auctions = Auction::with('auctionItem', 'auctionItem.auctionOwner')->whereIn('id', $auctionsIapproved)->where('is_approved', '=', '1')->get();

        $newRegisteredUsers = ParticipantsOf::with('user')->whereIn('auction', $auctionsIapproved)->where('is_approved', 1)->get();

        $auction_winners = [];

        foreach ($auctions as $auction) {
            if($auction->is_open) {
                $current_winner = ParticipantsOf::with('user')->where('auction', $auction->id)->where('is_approved', 1)->where('last_bid', '!=', 0)->orderBy('date_of_last_bid', 'desc')->first();
                $current_price = Auction::find($auction->id)->participants->sum('last_bid') + Auction::find($auction->id)->starting_price;
                $auction_winners[$auction->id] = [$current_winner, $current_price];
            } else {
                if ($auction->is_selling) {
                    $current_winner = ParticipantsOf::with('user')->where('auction', $auction->id)->where('is_approved', 1)->orderBy('last_bid', 'desc')->first();
                    $current_price = Auction::find($auction->id)->participants->max('last_bid') + Auction::find($auction->id)->starting_price;
                    $auction_winners[$auction->id] = [$current_winner, $current_price];
                } else {
                    $current_winner = ParticipantsOf::with('user')->where('auction', $auction->id)->where('is_approved', 1)->orderBy('last_bid', 'asc')->first();
                    $current_price = Auction::find($auction->id)->participants->min('last_bid') + Auction::find($auction->id)->starting_price;
                    $auction_winners[$auction->id] = [$current_winner, $current_price];
                }
            }
        }

        if(Auth::user()->is_admin())
        return view('liciator/auction-approval', ["auctions" => $auctions, "newParticipants" => $newRegisteredUsers, "winners" => $auction_winners, "title" => "Všechny schválené aukce"]);
        else
            return view('liciator/auction-approval', ["auctions" => $auctions, "newParticipants" => $newRegisteredUsers, "winners" => $auction_winners, "title" => "Aukce schvalené mnou"]);
    }

    public function handleNewRegisteredUser(Request $request) {
        if(Auth::check() && (Auth::user()->is_admin() || Auth::user()->is_auctioneer())) {
            if(isset($request->userId) && (isset($request->auctionId))) {
                ParticipantsOf::where('auction', $request->auctionId)->where('participant', $request->userId)->update(['is_approved'=>False, 'last_bid' => 0]);;
                return response('OK', 200);
            }
            else {
                return abort(400);
            }
        }

        return abort(403);
    }

    public function approveAuction(Request $request) {
        if(Auth::check() && (Auth::user()->is_admin() || Auth::user()->is_auctioneer())) {
            $auction = Auction::where('id', $request->auctionId)->first();
            if(isset($request->response) && (isset($request->auctionId))) {
                if($auction->is_open) {
                    $winner = ParticipantsOf::with('user')->where('auction', $auction->id)->where('is_approved', 1)->where('last_bid', '!=', 0)->orderBy('date_of_last_bid', 'desc')->first();
                } else {
                    if ($auction->is_selling) {
                        $winner = ParticipantsOf::with('user')->where('auction', $auction->id)->where('is_approved', 1)->orderBy('last_bid', 'desc')->first();
                    } else {
                        $winner = ParticipantsOf::with('user')->where('auction', $auction->id)->where('is_approved', 1)->orderBy('last_bid', 'asc')->first();        
                    }
                }
                if ($request->response) {
                    if ($winner != null)
                        Auction::where('id', $request->auctionId)->update(['results_approved'=> $request->response, "winner" => $winner->participant]);
                    else
                        Auction::where('id', $request->auctionId)->update(['results_approved'=> $request->response]);
                } else {
                    Auction::where('id', $request->auctionId)->update(['results_approved'=> 0]);
                }

                return response('OK', 200);
            }
            else {
                return abort(400);
            }
        }
        return abort(403);
    }
}

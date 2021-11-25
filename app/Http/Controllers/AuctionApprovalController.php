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

        if(isset($request->name) && isset($request->description) &&
           isset($request->startPrice) && isset($request->auctionStart) && isset($request->auctionEnd) &&
           isset($request->is_selling) && isset($request->is_open) && isset($request->id))
           {
                $auction = Auction::with('auctionItem')->where('id', '=', $request->id)->first();
                if($auction->auctionItem->owner == Auth::user()->id)
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
        else if(isset($request->auctionId) && isset($request->approved))
            if($request->approved >= 0 && $request->approved <= 1)
            {
                $auction = Auction::where('id', '=', $request->auctionId)->first();

                if($auction != NULL)
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

        return $this->index();
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
        $auctions = Auction::with('auctionItem', 'auctionItem.auctionOwner')->whereIn('id', $auctionsIapproved)->where('is_approved', '=', '1')->get();

        $newRegisteredUsers = ParticipantsOf::with('user')->whereIn('auction', $auctionsIapproved)->where('is_approved', 1)->get();

        return view('liciator/auction-approval', ["auctions" => $auctions, "newParticipants" => $newRegisteredUsers, "title" => "Aukce schvalené mnou"]);
    }

    public function handleNewRegisteredUser(Request $request) {
        if(Auth::check() && (Auth::user()->is_admin() || Auth::user()->is_auctioneer())) {
            if(isset($request->userId) && (isset($request->auctionId))) {
                $participation = ParticipantsOf::where('auction', $request->auctionId)->where('participant', $request->userId)->update(['is_approved'=>False]);;
                return response('OK', 200);
            }
            else {
                return abort(400);
            }
        }

        return abort(403);
    }
}

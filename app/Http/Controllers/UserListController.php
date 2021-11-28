<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class UserListController extends Controller
{
    public function triggerToggle(Request $request)
    {
        if(Auth::check() && Auth::user()->is_admin())
            if(isset($request->userId) && (isset($request->isAuctioneer) || isset($request->isAdmin)))
            {
                $user = User::where('id', '=', $request->userId)->first();

                if($user == null)
                    return abort(400);

                if(isset($request->isAuctioneer))
                    $user->typ = $user->typ != "auctioneer" ? "auctioneer" : "user";
                else
                    $user->typ = $user->typ != "admin" ? "admin" : "user";

                $user->save();
                return response('OK', 200);
            }
            else{
                return abort(400);
            }

        return abort(403);
    }

    public function deleteUser(Request $request)
    {
        if(isset($request->userId) && Auth::user()->is_admin())
        {
            $user = User::find($request->userId);

            if($user != null)
            {
                $user->delete();
            }
        }

        return $this->index();
    }

    public function index()
    {
        if (Auth::check() && Auth::user()->is_admin()) {
            $users = User::all()->except(Auth::id());
            return view('user/userList', ["users" => $users]);
        } else {
            abort(403);
        }
    }
}

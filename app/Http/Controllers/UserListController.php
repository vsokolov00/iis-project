<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;

class UserListController extends Controller
{
    public function index()
    {
        if (Auth::user()->is_admin()) {
            $users = User::all()->except(Auth::id());
            return view('user/userList', ["users" => $users]);
        } else {
            abort(403);
        }
    }
}

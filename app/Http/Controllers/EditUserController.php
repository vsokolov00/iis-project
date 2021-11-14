<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class EditUserController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        return view('user/edit');
    }

    public function updateProfile(Request $request)
    {
        if(isset($request->username))
            User::where('id', Auth::user()->id)->update(['name' => $request->username]);
        else if(isset($request->email))
            User::where('id', Auth::user()->id)->update(['email' => $request->email]);
        else if(isset($request->new_password) && isset($request->old_password) && isset($request->password_confirm))
            return "Password";
        else
            return "None";

        return redirect('profile');
    }
}

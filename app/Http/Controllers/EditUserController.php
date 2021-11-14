<?php

namespace App\Http\Controllers;

class EditUserController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        return view('user/edit');
    }
}

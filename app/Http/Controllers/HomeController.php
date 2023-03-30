<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        //this is home controller
        //edit branch
        //after merge
        return view('admin.layout.app');
    }
}

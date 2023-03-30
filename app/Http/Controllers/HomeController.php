<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        //this is home controller
        return view('admin.layout.app');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if(Session::get('session') == null) {
            return view('auth/login');
        }
        else {
            return view('layouts.mainpageContainer');
        }
    }
    public function usermanage(){
        if(Session::get('session') == null) {
            return view('auth/login');
        }
        else {
            return view('main.usermanage');
        }
    }
    public function reportmanage(){
        if(Session::get('session') == null) {
            return view('auth/login');
        }
        else {
            return view('main.reportmanage');
        }
    }

}

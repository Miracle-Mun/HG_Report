<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;

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

        $data = DB::table('reports')
                ->leftjoin('communities', 'reports.community_id', '=', 'communities.id')
                ->leftjoin('periods', 'reports.period_id', '=', 'periods.id')
                ->orderBy('periods.id', 'DESC')
                ->take(20)
                ->get()->toArray();
        if(isset($_POST['sortTypeagain'])) {
            if($_POST['sortTypeagain'] != 'null') {
                $GLOBALS['before'] = $_POST['sortTypeagain'];
            } else {
                $GLOBALS['before'] = "null";
            }
        }
        $GLOBALS['field'] = null;
        if(count($_POST) > 0) {
            if($_POST['type'] == 'locationReport1') {
                $GLOBALS['field'] = 'locationReport1';
            } else if($_POST['type'] == 'dateofreport1') {
                $GLOBALS['field'] = 'dateofreport1';
            } else if($_POST['type'] == 'user1') {
                $GLOBALS['field'] = 'user1';
            } else if($_POST['type'] == 'timeoftheedit1') {
                $GLOBALS['field'] = 'timeoftheedit1';
            } else if($_POST['type'] == 'whatwasedit1') {
                $GLOBALS['field'] = 'whatwasedit1';
            }
            usort($data, array($this,'cmp'));
        }

        if(Session::get('session') == null) {
            return view('auth/login');
        }
        else {
            return view('main.reportmanage', compact('data'));
        }
    }

    private static function cmp($a, $b)
    {
        if($GLOBALS['field'] != null) {
            if($GLOBALS['field'] == 'locationReport1') {
                if($GLOBALS['before'] == 'locationReport1') {
                    return strcmp($b->name, $a->name);
                } else {
                    return strcmp($a->name, $b->name);
                }
            } else if($GLOBALS['field'] == 'dateofreport1') {
                if($GLOBALS['before'] == 'dateofreport1') {
                    return strcmp($b->period_id, $a->period_id);
                } else {
                    return strcmp($a->period_id, $b->period_id);
                }
            }
            else if($GLOBALS['field'] == 'user1') {
                if($GLOBALS['before'] == 'dateofreport1') {
                    return strcmp($b->period_id, $a->period_id);
                } else {
                    return strcmp($a->period_id, $b->period_id);
                }
            }
            else if($GLOBALS['field'] == 'timeoftheedit1') {
                if($GLOBALS['before'] == 'dateofreport1') {
                    return strcmp($b->period_id, $a->period_id);
                } else {
                    return strcmp($a->period_id, $b->period_id);
                }
            }
            else if($GLOBALS['field'] == 'whatwasedit1') {
                if($GLOBALS['before'] == 'dateofreport1') {
                    return strcmp($b->period_id, $a->period_id);
                } else {
                    return strcmp($a->period_id, $b->period_id);
                }
            } 
        } else {
            return strcmp($a->name, $b->name);
        }
    }

}

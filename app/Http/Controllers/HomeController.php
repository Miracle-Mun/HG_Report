<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use DB;
use App\model\logins;
use App\model\users;
use App\model\reports;
use App\model\Communities;


class HomeController extends Controller
{
    public static $Type = '0';
    public static $againCheck = '0';
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
    public function profile()
    {
        $userinfo = Session::get('whole');
        $result = DB::table('users')
            ->rightjoin('reports', 'reports.report_user', '=', 'users.id')
            ->leftjoin('communities', 'reports.community_id', '=', 'communities.id')
            ->where('users.id', '=', $userinfo->user_id)
            ->take('50')
            ->get();
        $userData = DB::table('users')
            ->leftjoin('logins', 'logins.user_id', '=', 'users.id')
            ->leftjoin('communities', 'users.community_id', '=', 'communities.id')
            ->where('users.id', '=', $userinfo->user_id)
            ->get();
        $userData = json_decode($userData)[0];
        $reportsData = DB::table('reports')->leftjoin('periods', 'reports.period_id', 'periods.id')
            ->leftjoin('communities', 'reports.community_id', 'communities.id')
            ->where('report_user', $userData->user_id)->take('30')
            ->get()->toArray();

        if(isset($_POST['sortTypeagain1'])) {
            if($_POST['sortTypeagain1'] != 'null') {
                $GLOBALS['before1'] = $_POST['sortTypeagain1'];
            } else {
                $GLOBALS['before1'] = "null";
            }
        }
        $GLOBALS['field1'] = null;
        if(count($_POST) > 0) {
            if($_POST['type1'] == 'locationReport1') {
                $GLOBALS['field1'] = 'locationReport1';
            } else if($_POST['type1'] == 'dateofreport1') {
                $GLOBALS['field1'] = 'dateofreport1';
            } else if($_POST['type1'] == 'user1') {
                $GLOBALS['field1'] = 'user1';
            } else if($_POST['type1'] == 'timeoftheedit1') {
                $GLOBALS['field1'] = 'timeoftheedit1';
            } else if($_POST['type1'] == 'whatwasedit1') {
                $GLOBALS['field1'] = 'whatwasedit1';
            }
            usort($reportsData, array($this,'cmp2'));
        }
        $EditedData = ['Census and Capacity', 'moveouts', 'statics', 'Move ins'];
        return view('profile', compact(
            'result',
            'userData',
            'reportsData',
            'EditedData'
        ));
    }
    public function usermanage(){

        if(isset($_POST['type']) == true) {
            if(isset($_POST['sortTypeagain'])) {
                self::$againCheck = $_POST['sortTypeagain'];
            }
            self::$Type = $_POST['type'];
        }

        $logins = new logins;
        $users = new users;
        $Communities = new Communities;
        
        $Sessionuserinfo = Session::get('session');

        $infoarr = explode(",", $Sessionuserinfo);
        $userData = DB::table('logins')
                ->leftjoin('users', 'logins.user_id','=','users.id')
                ->where('logins.username','=',$infoarr[0])
                ->where('logins.encrypted','=',$infoarr[1])
                ->get(
                    'users.*'
                )->toArray();
        if($userData[0]->leveluser != 3) {
            $result = json_decode(
                $users->leftJoin('logins', 'users.id', '=', 'logins.user_id')
                ->where(
                    [
                        'community_id' => $userData[0]->community_id,
                        'leveledit' => $userData[0]->leveledit,
                        'levelreport' => $userData[0]->levelreport,
                        'levelcompany' => $userData[0]->levelcompany,
                        'leveladd' => $userData[0]->leveladd
                    ]
                )
                ->get([ 'users.*','logins.*'])
            );
        } else {
            $result = json_decode($users->leftJoin('logins', 'users.id', '=', 'logins.user_id')->get([ 'users.*','logins.*']));
        }

        // dd($result);
        foreach ($result as $key => $value) {
            $value->community = json_decode($Communities->where(['id'=>$value->community_id])->get())[0]->name;
        }

        $arr = ['success', 'danger', 'warning', 'primary'];
        $iNum = 0;

        usort($result, array($this,'cmp1'));

        if(Session::get('session') == null) {
            return view('auth/login');
        }
        else {
            return view('main.usermanage',compact(
                'result',
                'iNum',
                'arr',
                'Communities',
                'users',
                'logins',
                'userData'
            ));
        }
    }
    public function reportmanage(){

        $data = DB::table('reports')
                ->leftjoin('communities', 'reports.community_id', '=', 'communities.id')
                ->leftjoin('periods', 'reports.period_id', '=', 'periods.id')
                ->leftjoin('users', 'reports.report_user', '=', 'users.id')
                ->orderBy('periods.id', 'DESC')
                ->take(20)
                ->get(
                    array(
                        'users.name as username',
                        'users.whatedit as whatedit',
                        'reports.*',
                        'periods.*',
                        'communities.*'
                    )
                )->toArray();
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

        $EditedData = ['Census and Capacity', 'moveouts', 'statics', 'Move ins'];

        if(Session::get('session') == null) {
            return view('auth/login');
        }
        else {
            return view('main.reportmanage', compact('data', 'EditedData'));
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
                if($GLOBALS['before'] == 'user1') {
                    return strcmp($b->username, $a->username);
                } else {
                    return strcmp($a->username, $b->username);
                }
            }
            else if($GLOBALS['field'] == 'timeoftheedit1') {
                if($GLOBALS['before'] == 'timeoftheedit1') {
                    return strcmp($b->edit_time, $a->edit_time);
                } else {
                    return strcmp($a->edit_time, $b->edit_time);
                }
            }
            else if($GLOBALS['field'] == 'whatwasedit1') {
                if($GLOBALS['before'] == 'whatwasedit1') {
                    return strcmp($b->whatedit, $a->whatedit);
                } else {
                    return strcmp($a->whatedit, $b->whatedit);
                }
            } 
        } else {
            return strcmp($a->name, $b->name);
        }
    }
    private static function cmp1($a, $b)
    {
        if(self::$againCheck != 'true') {
            if(self::$Type == 'name') {
                return strcmp($a->name, $b->name);
            } else if(self::$Type == 'Community') {
                return strcmp($a->community, $b->community);
            } else if(self::$Type == 'Position') {
                return strcmp($a->position, $b->position);
            } else if(self::$Type == 'Status') {
                return strcmp($a->inactive, $b->inactive);
            } else if(self::$Type == 'CreatedDate') {
                return strcmp($a->created_date, $b->created_date);
            } else if(self::$Type == 'LastLogin') {
                return strcmp($a->last_login, $b->last_login);
            } else {
                return strcmp($a->name, $b->name);
            }
        } else {
            if(self::$Type == 'name') {
                return strcmp($b->name, $a->name);
            } else if(self::$Type == 'Community') {
                return strcmp($b->community, $a->community);
            } else if(self::$Type == 'Position') {
                return strcmp($b->position, $a->position);
            } else if(self::$Type == 'Status') {
                return strcmp($b->inactive, $a->inactive);
            } else if(self::$Type == 'CreatedDate') {
                return strcmp($b->created_date, $a->created_date);
            } else if(self::$Type == 'LastLogin') {
                return strcmp($b->last_login, $a->last_login);
            } else {
                return strcmp($b->name, $a->name);
            }
        }
    }
    private static function cmp2($a, $b)
    {
        if($GLOBALS['field1'] != null) {
            if($GLOBALS['field1'] == 'locationReport1') {
                if($GLOBALS['before1'] == 'locationReport1') {
                    return strcmp($b->name, $a->name);
                } else {
                    return strcmp($a->name, $b->name);
                }
            } else if($GLOBALS['field1'] == 'dateofreport1') {
                if($GLOBALS['before1'] == 'dateofreport1') {
                    return strcmp($b->period_id, $a->period_id);
                } else {
                    return strcmp($a->period_id, $b->period_id);
                }
            }
            else if($GLOBALS['field1'] == 'timeoftheedit1') {
                if($GLOBALS['before1'] == 'timeoftheedit1') {
                    return strcmp($b->edit_time, $a->edit_time);
                } else {
                    return strcmp($a->edit_time, $b->edit_time);
                }
            }
            else if($GLOBALS['field1'] == 'whatwasedit1') {
                if($GLOBALS['before1'] == 'whatwasedit1') {
                    return strcmp($b->whatedit, $a->whatedit);
                } else {
                    return strcmp($a->whatedit, $b->whatedit);
                }
            } 
        } else {
            return strcmp($a->name, $b->name);
        }
    }
}

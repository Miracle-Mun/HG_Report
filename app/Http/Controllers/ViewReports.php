<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Session;
use App\model\users;
use App\model\logins;
use App\model\reports;
use App\model\periods;
use App\model\cencaps;
use App\model\buildings;
use App\model\moveouts;
use App\model\inquiries;
use App\model\Communities;

class ViewReports extends Controller
{
    public function getinfo() {
        Session::flash('info',$_POST['community_id'].','.$_POST['period_id']);
        return view('ViewReports');
    }
    public function getinfoSecond() {
        if($_POST['period_id_from'] > $_POST['period_id_to']) {
            $temp = $_POST['period_id_from'];
            $_POST['period_id_from'] = $_POST['period_id_to'];
            $_POST['period_id_to'] = $temp;
        }

        $inquiries = new inquiries;
        $periods = new periods;
        $WholeSum = $inquiries = DB::table('inquiries')->leftjoin('reports', 'inquiries.report_id', '=', 'reports.id')
            ->where('reports.community_id', '=', $_POST['community_id'])     
            ->where('reports.period_id', '>=', $_POST['period_id_from'])     
            ->where('reports.period_id', '<=', $_POST['period_id_to'])
            ->groupBy('reports.period_id')
            ->get(
                array(
                    DB::raw('SUM(inquiries.number) as sum'),
                    DB::raw('reports.period_id')
                )
            )->toArray();
        $ownmainData = $inquiries = DB::table('inquiries')->leftjoin('reports', 'inquiries.report_id', '=', 'reports.id')
            ->where('reports.community_id', '=', $_POST['community_id'])     
            ->where('reports.period_id', '>=', $_POST['period_id_from'])     
            ->where('reports.period_id', '<=', $_POST['period_id_to'])
            ->groupBy('inquiries.description')
            ->get(
                array(
                    DB::raw('SUM(inquiries.number) as sum'),
                    DB::raw('inquiries.description'),
                    DB::raw('reports.period_id')
                )
            );
        $periodsData2 = $periods->where([['id','>=',$_POST['period_id_from']], ['id','<=',$_POST['period_id_to']]])->get()->toArray();

        Session::flash('info',$_POST['community_id'].','.$_POST['period_id_from'].','.$_POST['period_id_to']);
        return view('ViewReportsSecond', compact('ownmainData', 'periodsData2', 'WholeSum'));
    }
    public function getDateinfo() {
        $periods = new periods;
        $result = $periods->where([ 'starting' => $_POST['from'], 'ending' => $_POST['to'] ])->get();
        if(count($result) > 0) {
            return $result[0];
        } else {
            $result = null;
            return $result;
        }
    }
    public function getinfocreports()
    {
        Session::flash('period',$_POST['period_id']);
        return view('ViewCreports');
    }
    public function getinfocreportsSecond() {
        
        $reports = new reports;
        $periods = new periods;
        $cencaps = new cencaps;
        $buildings = new buildings;
        $moveouts = new moveouts;
        $Communities = new Communities;

        $buildingsData = $buildings->get();
        $wholeData = [];
        
        if($_POST['period_id_from'] > $_POST['period_id_to']) {
            $temp = $_POST['period_id_from'];
            $_POST['period_id_from'] = $_POST['period_id_to'];
            $_POST['period_id_to'] = $temp;
        }

        foreach ($buildingsData as $value) {
            $subjects = DB::table('cencaps')
                ->leftjoin('reports', 'reports.id', '=', 'cencaps.report_id')
                ->leftjoin('buildings', 'buildings.id', '=', 'cencaps.building_id')
                ->where('reports.period_id', '>=', $_POST['period_id_from'])         
                ->where('reports.period_id', '<=', $_POST['period_id_to'])         
                ->where('buildings.id', '=' , $value->id)
                ->selectRaw('sum(cencaps.census)')
                ->groupBy('reports.period_id')
                ->get();

            $data = DB::table('cencaps')
                ->leftjoin('reports', 'reports.id', '=', 'cencaps.report_id')
                ->leftjoin('buildings', 'buildings.id', '=', 'cencaps.building_id')
                ->where('reports.period_id', '>=', $_POST['period_id_from'])         
                ->where('reports.period_id', '<=', $_POST['period_id_to'])         
                ->where('buildings.id', '=' , $value->id)
                ->selectRaw('sum(cencaps.census)')
                ->get();
            array_push($wholeData, [$subjects,$data]);
        }

        $periodsData = $periods->where([['id','>=',$_POST['period_id_from']], ['id','<=',$_POST['period_id_to']]])->get();
        $totalData = [];
        foreach ($periodsData as $key => $value) {
            $tempData = DB::table('cencaps')
                ->leftjoin('reports', 'reports.id', '=', 'cencaps.report_id')
                ->leftjoin('buildings', 'buildings.id', '=', 'cencaps.building_id')
                ->where('reports.period_id', '=', $value->id)  
                ->selectRaw('sum(cencaps.census)')
                ->get();
         
            array_push($totalData, $tempData);
        }
        $data = DB::table('cencaps')
                ->leftjoin('reports', 'reports.id', '=', 'cencaps.report_id')
                ->leftjoin('buildings', 'buildings.id', '=', 'cencaps.building_id')
                ->where('reports.period_id', '>=', $_POST['period_id_from'])         
                ->where('reports.period_id', '<=', $_POST['period_id_to'])         
                ->selectRaw('sum(cencaps.census)')
                ->get();

        $wholeData1 = [];
        foreach ($buildingsData as $value) {
            $subjects = DB::table('cencaps')
                ->leftjoin('reports', 'reports.id', '=', 'cencaps.report_id')
                ->leftjoin('buildings', 'buildings.id', '=', 'cencaps.building_id')
                ->where('reports.period_id', '>=', $_POST['period_id_from'])         
                ->where('reports.period_id', '<=', $_POST['period_id_to'])         
                ->where('buildings.id', '=' , $value->id)
                ->selectRaw('sum(cencaps.capacity)')
                ->groupBy('reports.period_id')
                ->get();

            $data1 = DB::table('cencaps')
                ->leftjoin('reports', 'reports.id', '=', 'cencaps.report_id')
                ->leftjoin('buildings', 'buildings.id', '=', 'cencaps.building_id')
                ->where('reports.period_id', '>=', $_POST['period_id_from'])         
                ->where('reports.period_id', '<=', $_POST['period_id_to'])         
                ->where('buildings.id', '=' , $value->id)
                ->selectRaw('sum(cencaps.capacity)')
                ->get();
            array_push($wholeData1, [$subjects,$data1]);
        }

        $totalData1 = [];
        foreach ($periodsData as $key => $value) {
            $tempData = DB::table('cencaps')
                ->leftjoin('reports', 'reports.id', '=', 'cencaps.report_id')
                ->leftjoin('buildings', 'buildings.id', '=', 'cencaps.building_id')
                ->where('reports.period_id', '=', $value->id)  
                ->selectRaw('sum(cencaps.capacity)')
                ->get();
         
            array_push($totalData1, $tempData);
        }
        $data1 = DB::table('cencaps')
                ->leftjoin('reports', 'reports.id', '=', 'cencaps.report_id')
                ->leftjoin('buildings', 'buildings.id', '=', 'cencaps.building_id')
                ->where('reports.period_id', '>=', $_POST['period_id_from'])         
                ->where('reports.period_id', '<=', $_POST['period_id_to'])         
                ->selectRaw('sum(cencaps.capacity)')
                ->get();


        $wholeData2 = [];
        foreach ($buildingsData as $value) {
            $subjects = DB::table('cencaps')
                ->leftjoin('reports', 'reports.id', '=', 'cencaps.report_id')
                ->leftjoin('buildings', 'buildings.id', '=', 'cencaps.building_id')
                ->where('reports.period_id', '>=', $_POST['period_id_from'])         
                ->where('reports.period_id', '<=', $_POST['period_id_to'])         
                ->where('buildings.id', '=' , $value->id)
                ->selectRaw('sum(cencaps.census)/sum(cencaps.capacity)')
                ->groupBy('reports.period_id')
                ->get();

            $data2 = DB::table('cencaps')
                ->leftjoin('reports', 'reports.id', '=', 'cencaps.report_id')
                ->leftjoin('buildings', 'buildings.id', '=', 'cencaps.building_id')
                ->where('reports.period_id', '>=', $_POST['period_id_from'])         
                ->where('reports.period_id', '<=', $_POST['period_id_to'])         
                ->where('buildings.id', '=' , $value->id)
                ->selectRaw('sum(cencaps.census)/sum(cencaps.capacity)')
                ->get();
            array_push($wholeData2, [$subjects,$data2]);
        }

        $totalData2 = [];
        foreach ($periodsData as $key => $value) {
            $tempData = DB::table('cencaps')
                ->leftjoin('reports', 'reports.id', '=', 'cencaps.report_id')
                ->leftjoin('buildings', 'buildings.id', '=', 'cencaps.building_id')
                ->where('reports.period_id', '=', $value->id)  
                ->selectRaw('sum(cencaps.census)/sum(cencaps.capacity)')
                ->get();
            
            array_push($totalData2, $tempData);
        }
        $data2 = DB::table('cencaps')
                ->leftjoin('reports', 'reports.id', '=', 'cencaps.report_id')
                ->leftjoin('buildings', 'buildings.id', '=', 'cencaps.building_id')
                ->where('reports.period_id', '>=', $_POST['period_id_from'])         
                ->where('reports.period_id', '<=', $_POST['period_id_to'])         
                ->selectRaw('sum(cencaps.census)/sum(cencaps.capacity)')
                ->get();
        
        $MoveoutData = DB::table('reports')->leftjoin('moveouts', 'reports.id', '=', 'moveouts.report_id')
                        ->where('reports.period_id', '>=', $_POST['period_id_from'])         
                        ->where('reports.period_id', '<=', $_POST['period_id_to'])
                        ->where('moveouts.description', '!=', 'null')
                        ->groupBy('moveouts.description')
                        ->get(
                            array(
                                DB::raw('SUM(moveouts.number) AS sum'),
                                DB::raw('moveouts.description')
                            )
                        )->toArray();

        $MoveoutData2 = DB::table('reports')->leftjoin('moveouts', 'reports.id', '=', 'moveouts.report_id')
            ->where('reports.period_id', '>=', $_POST['period_id_from'])         
            ->where('reports.period_id', '<=', $_POST['period_id_to'])
            ->groupBy(['reports.period_id','moveouts.description'])
            ->get(
                array(
                    DB::raw('SUM(moveouts.number) AS sum'),
                    DB::raw('reports.period_id'),
                    DB::raw('moveouts.description')
                )
            )->toArray();

        $periodsData2 = $periods->where([['id','>=',$_POST['period_id_from']], ['id','<=',$_POST['period_id_to']]])->get()->toArray();

        $finaltotalData = DB::table('reports')->rightjoin('moveouts', 'reports.id', '=', 'moveouts.report_id')
            ->where('reports.period_id', '>=', $_POST['period_id_from'])         
            ->where('reports.period_id', '<=', $_POST['period_id_to'])
            ->groupBy('reports.period_id')
            ->get(
                array(
                    DB::raw('SUM(moveouts.number) AS sum')
                )
            );
        $finalwholetotalData = DB::table('reports')->rightjoin('moveouts', 'reports.id', '=', 'moveouts.report_id')
            ->where('reports.period_id', '>=', $_POST['period_id_from'])         
            ->where('reports.period_id', '<=', $_POST['period_id_to'])
            ->get(
                array( 
                    DB::raw('SUM(moveouts.number) AS sum')
                )
            );
        
        $reportsData = DB::table("reports")
            ->where('period_id', '>=', $_POST['period_id_from'])         
            ->where('period_id', '<=', $_POST['period_id_to'])
            ->select(
                'reports.*',
                DB::raw("SUM(unqualified) as total_unqualified"),
                DB::raw("SUM(tours) as total_tours"),
                DB::raw("SUM(deposits) as total_deposits"),
                DB::raw("SUM(wtd_movein) as total_wtd_movein"),
                DB::raw("SUM(wtd_moveout) as total_wtd_moveout"),
                DB::raw("SUM(ytd_movein) as total_ytd_movein"),
                DB::raw("SUM(ytd_moveout) as total_ytd_moveout")
            )
            ->groupBy('period_id')
            ->get();
        $reportsData1 = DB::table("reports")
            ->where('period_id', '>=', $_POST['period_id_from'])         
            ->where('period_id', '<=', $_POST['period_id_to'])
            ->select(
                'reports.*',
                DB::raw("SUM(unqualified) as total_unqualified"),
                DB::raw("SUM(tours) as total_tours"),
                DB::raw("SUM(deposits) as total_deposits"),
                DB::raw("SUM(wtd_movein) as total_wtd_movein"),
                DB::raw("SUM(wtd_moveout) as total_wtd_moveout"),
                DB::raw("SUM(ytd_movein) as total_ytd_movein"),
                DB::raw("SUM(ytd_moveout) as total_ytd_moveout")
            )
            ->groupBy('unqualified')
            ->get();

        return view(
            'ViewCreportsSecond', 
            compact(
                'data', 
                'totalData', 
                'wholeData', 
                'periodsData', 
                'buildingsData', 
                'totalData1', 
                'wholeData1', 
                'data1', 
                'totalData2', 
                'wholeData2', 
                'data2', 
                'MoveoutData',
                'MoveoutData2',
                'periodsData2',
                'finaltotalData',
                'finalwholetotalData',
                'reportsData',
                'reportsData1'
            )
        );
    }

    public function editaction() {
        
        $reports = new reports;
        $cencaps = new cencaps;
        $inquiries = new inquiries;
        $moveouts = new moveouts;
        $buildings = new buildings;

        $reportsData = $reports->where(['community_id' => $_POST['community_id'], 'period_id' => $_POST['period_id']])->get()->toArray();
        if(count($reportsData) > 0) {
            $reportsData = $reportsData[0];
        } else {
            return redirect()->back(); 
        }
        $reports->where(['community_id' => $_POST['community_id'], 'period_id' => $_POST['period_id']])->update(['edit_time' => date('Y-m-d')]);
        // Community_id and period_id

        $CI = $_POST['community_id'];
        $PI = $_POST['period_id'];

        // Census and Capacity Data
        $CCD = DB::table('cencaps')->leftjoin('buildings', 'buildings.id', 'cencaps.building_id')
            ->where(['report_id' => $reportsData['id']])
            ->get();

        // Inquiries
        $ID = $inquiries->where(['report_id' => $reportsData['id']])->get();

        // Moveouts
        $MD = $moveouts->where(['report_id' => $reportsData['id']])->get();

        // Buildings
        $BD = $buildings->get();

        // viewitems
        $viewitems = ( new Communities )->get();

        // info
        $info = [$CI, $PI];

        // periods
        $periods = new periods;
        $sessioninfo = Session::get('session');
        $infos = explode(',', $sessioninfo);
        $userData = DB::table('users')->leftjoin('logins', 'users.id', '=', 'logins.user_id')
        ->where('logins.username', '=', $infos[0])
        ->where('logins.encrypted', '=', $infos[1])
        ->get(
            array(
                'users.*'
            )
        )->toArray();

        return view('EditAction', compact('reportsData', 'CCD', 'ID', 'MD', 'BD', 'CI', 'PI', 'viewitems', 'info', 'periods', 'userData'));
    }

    public function savedata() {
        
        $reports = new reports;
        $cencaps = new cencaps;
        $inquiries = new inquiries;
        $moveouts = new moveouts;
        $buildings = new buildings;
        
        $reportsData = array(
            'unqualified' => $_POST['unqualified'],
            'tours' => $_POST['tours'],
            'deposits' => $_POST['deposits'],
            'wtd_movein' => $_POST['wtd_movein'],
            'wtd_moveout' => $_POST['wtd_moveout'],
            'ytd_movein' => $_POST['ytd_movein'],
            'ytd_moveout' => $_POST['ytd_moveout']
        );
        
        $reports->where(['id' => $_POST['report_id']])->update(array('whatedit' => $_POST['whatedit']));
        $reports->where(['id' => $_POST['report_id']])->update($reportsData);
        
        foreach ($_POST as $key => $value) {
            if(stripos($key, 'Inquiries_description') != false) {
                if(stripos($key, ',') != false) {
                    $getinfo = explode(',',$key);
                    foreach ($_POST as $row => $val) {
                        if(stripos($row, 'Inquiries_count,'.$getinfo[1]) != false) {
                            $rowData = array(
                                'description' => $value,
                                'number' => $val
                            );
                            $inquiries->where(['id' => $getinfo[2]])->update($rowData);
                        } 
                    }
                } else {
                    $getinfo = explode('-',$key);
                    foreach ($_POST as $row => $val) {
                        if(stripos($row, 'Inquiries_count-'.$getinfo[1]) != false) {
                            $rowData = array(
                                'report_id' => $_POST['report_id'],
                                'description' => $value,
                                'number' => $val
                            );
                            $inquiries->insert($rowData);
                        } 
                    }
                }
            } else if(stripos($key, 'moveouts_description') != false) {
                if(stripos($key, ',') != false) {
                    $getinfo = explode(',',$key);
                    foreach ($_POST as $row => $val) {
                        if(stripos($row, 'moveouts_number,'.$getinfo[1]) != false) {
                            $rowData = array(
                                'description' => $value,
                                'number' => $val
                            );
                            $moveouts->where(['description' => $getinfo[2]])->update($rowData);
                        } 
                    }
                } else {
                    $getinfo = explode('-',$key);
                    foreach ($_POST as $row => $val) {
                        if(stripos($row, 'moveouts_number-'.$getinfo[1]) != false) {
                            $rowData = array(
                                'report_id' => $_POST['report_id'],
                                'description' => $value,
                                'number' => $val
                            );
                            $moveouts->insert($rowData);
                        } 
                    }
                }
            } else if(stripos($key, 'census') != false) {
                if(stripos($key, ',old') != false) {
                    $getinfo = explode(',',$key);
                    $rowData = array(
                        'census' => $_POST[$key],
                        'capacity' => $_POST['_capacity,'.$getinfo[1].',old']
                    );
                    $result = $cencaps->where(['report_id' => $_POST['report_id'], 'building_id' => $_POST['_buildingid,'.$getinfo[1].',old']])->update($rowData);
                } else {
                    $getinfo = explode(',',$key);
                    $rowData = array(
                        'report_id' => $_POST['report_id'],
                        'building_id' => $_POST['_buildingid,'.$getinfo[1]],
                        'census' => $_POST[$key],
                        'capacity' => $_POST['_capacity,'.$getinfo[1]]
                    );
                    $result = $cencaps->insert($rowData);
                }
            }
        }

        Session::flash('info',$_POST['community_id'].','.$_POST['period_id']);
        return view('ViewReports');
    }
    public function removeinquries() {
        $inquiries = new inquiries;
        $inquiries->where('id', '=', $_POST['id'])->delete();
        print_r('sccuss');
    }
    public function removemoveouts() {
        $moveouts = new moveouts;
        $moveouts->where(['description' => $_POST['description'], 'report_id' =>  $_POST['report_id']])->delete();
        print_r('sccuss');
    }
    public function removecc() {
        $cencaps = new cencaps;
        $cencaps->where(['report_id' => $_POST['report_id'], 'building_id' =>  $_POST['building_id'], 'census' => $_POST['census'], 'capacity' =>  $_POST['capacity']])->delete();
        print_r('sccuss');
    }
    public function editprofile()
    {
        $id = DB::table('users')->leftjoin('logins', 'users.id', '=', 'logins.user_id')
        ->where('users.email', '=', $_POST['oldemail'])
        ->where('logins.username', '=', $_POST['oldname'])
        ->get(
            array(
                'users.id'
            )
        )->toArray();
        if(count($id) > 0) {
            $_POST['value1'];
            $pass = explode(',',Session::get('session'))[1];
            Session::put('session', $_POST['value1'].','.$pass);
            $users = new users;
            $logins = new logins;
            $users->where('id', '=', $id[0]->id)->update(array('email' => $_POST['value2']));
            $logins->where('user_id', '=', $id[0]->id)->update(array('username' => $_POST['value1']));
            // Session::put('session', $_POST['username']. ','. $password);
        }
    }
    public function getchartinfodata()
    {
        $cencaps = new cencaps;
        $buildings = (new buildings)->get('name')->toArray();
        $currentCensus = $cencaps
        ->leftjoin('buildings', 'buildings.id', '=', 'cencaps.building_id')
        ->take('100')
        ->orderBy('report_id', 'DESC')
        ->get()->toArray();
        return compact(
            'currentCensus',
            'buildings'
        );
    }
}


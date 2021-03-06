@extends('layouts.container')

@section('contents')
<?php
    use App\model\Communities;
    use App\model\periods;
    $viewitems = ( new Communities )->get();
    $perioditems = ( new periods )->orderBy('id','desc')->limit(48)->get();
    $oneItem = json_decode($perioditems);
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
?>
<script src="/assets/js/jquery.min.js"></script>
<script>
    var df =  "<?php echo $oneItem[0]->caption; ?>";
    var df1 =  "<?php echo $oneItem[0]->id; ?>";
    var df2 =  "<?php echo $oneItem[0]->starting; ?>";
    var dt =  "<?php echo $oneItem[0]->caption; ?>";
    var dt1 =  "<?php echo $oneItem[0]->id; ?>";
    var dt2 =  "<?php echo $oneItem[0]->starting; ?>";
    if(localStorage.getItem('period_id_from') == "" || localStorage.getItem('period_id_from') == null || localStorage.getItem('period_id_from') == 'Select correct date' ) {
        localStorage.setItem('period_id_from', df);
        localStorage.setItem('period_id_from1', df1);
        localStorage.setItem('period_id_from2', df2);
    }
    if(localStorage.getItem('period_id_to') == "" || localStorage.getItem('period_id_to') == null || localStorage.getItem('period_id_to') == 'Select correct date' ) {
        localStorage.setItem('period_id_to', dt);
        localStorage.setItem('period_id_to1', dt1);
        localStorage.setItem('period_id_to2', dt2);
    }
</script>
<script> 
    var communities = <?php echo $viewitems; ?>;
</script>
<div class="col-xl-12 TitleHeaderBar">
    <hr>
</div>
<div class="row jcfe w-100">
    <div class="col-md-3 my-2 my-md-0">
        <div class="d-flex align-items-center">
            <label class="mr-3 mb-0 d-none d-md-block vewCompany">
                From:&nbsp;
            </label>
            <input type="button" class="span2 btn-rounded period_id_from" date="{{ $oneItem[0]->id }}" value="" onchange="setValFrom(this)" id="dp1">
        </div>
    </div>
    
    <div class="col-md-3 my-2 my-md-0">
        <div class="d-flex align-items-center">
            <label class="mr-3 mb-0 d-none d-md-block vewCompany">
                To:&nbsp;
            </label>
            <input type="button" class="span2 btn-rounded period_id_to" date="{{ $oneItem[0]->id }}" value="" onchange="setValTo(this)" id="dp2">
        </div>
    </div>
    <input id="inp_temp" style="width: 1px;opacity: 0;"/>
</div>
<script>
    setTimeout(function(){
        df2 = localStorage.getItem('period_id_from2').split('-');
        dt2 = localStorage.getItem('period_id_to2').split('-');
        $('#dp1').datepicker('setDate', new Date(parseInt(df2[0]), parseInt(df2[1]) - 1, parseInt(df2[2])));
        $('#dp1').datepicker('update');
        $('#dp2').datepicker('setDate', new Date(parseInt(dt2[0]), parseInt(dt2[1]) - 1, parseInt(dt2[2])));
        $('#dp2').datepicker('update');
    },500)
    $('.period_id_from').attr('value', localStorage.getItem('period_id_from'));
    $('.period_id_from').attr('date', localStorage.getItem('period_id_from1'));
    $('.period_id_to').attr('value', localStorage.getItem('period_id_to'));
    $('.period_id_to').attr('date', localStorage.getItem('period_id_to1'));
</script>
<div class="col-xl-12 TitleHeaderBar">
    <h3 class="landingtitle">View Reports for Any Community</h3>
</div>

<div class="col-xl-10 ContentBar">
    <div class="col-lg-12 col-xl-12">
        <form action="/reportSummary" method="post">
            @csrf
            <div class="row align-items-center">
                @if($userData[0]->levelreport > 0 )
                    <div class="col-md-6 my-2 my-md-0">
                        <div class="d-flex align-items-center">
                            <label class="mr-3 mb-0 d-none d-md-block" style="width: 25%;"><strong>View</strong></label>
                            <div class="dropdown bootstrap-select form-control">
                                <div class="dropdown bootstrap-select form-control">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-9 col-sm-12">
                                            <div class="dropdown bootstrap-select form-control dropdownC">
                                                @foreach ($viewitems as $key => $item)
                                                    @if ($key == 0)
                                                        <input name="community_id" value={{ $item->id }} class="dn com">
                                                    @endif
                                                @endforeach
                                                @if($userData[0]->levelreport > 0 )
                                                    @foreach ($viewitems as $item)
                                                        @if($item->id != 10)
                                                            @if($item->id == $userData[0]->community_id)
                                                                <button type="button" tabindex="-1" class="btn dropdown-toggle btn-light" data-toggle="dropdown" role="combobox" aria-owns="bs-select-2" aria-haspopup="listbox" aria-expanded="true" title="{{ $item->name }}">
                                                                    <div class="filter-option">
                                                                        <div class="filter-option-inner">
                                                                            <div class="filter-option-inner-inner">{{ $item->name }}</div>
                                                                        </div>
                                                                    </div>
                                                                </button>
                                                            @endif
                                                        @endif
                                                    @endforeach
                                                @endif
                                                @if($userData[0]->levelreport > 1 )
                                                    <select class="form-control selectpicker" data-live-search="true" tabindex="null">
                                                        @foreach ($viewitems as $item)
                                                            @if($item->id != 10)
                                                                @if($item->id == $userData[0]->community_id)
                                                                    <option data-tokens="mustard" selected="selected">
                                                                        {{ $item->name }}
                                                                    </option>
                                                                @else
                                                                    <option data-tokens="mustard">
                                                                        {{ $item->name }}
                                                                    </option>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    @foreach ($viewitems as $key => $item)
                        @if ($key == 0)
                            <input name="community_id" value={{ $item->id }} class="dn com">
                        @endif
                    @endforeach
                @endif
                @if($userData[0]->levelreport > 1 )
                    <div class="col-md-3 my-2 my-md-0">
                        <div class="input-icon">
                            <input name="period_id" class="dn period_id">
                            <input class="dn submitInput" type="submit">
                            <button class="ViewReportsOne goBtn btn-rounded" option1="community_id" type="button">
                                <span class="iconify" data-icon="logos:go" data-inline="false"></span>
                            </button>
                        </div>
                    </div>
                @else
                    <div><div><input name="period_id" class="dn period_id"></div></div>
                @endif
                @if($userData[0]->leveledit >= 2 )
                    <div class="col-md-3 my-2 my-md-0">
                        <div class="input-icon">
                            <input class="dn submitInput" type="submit">
                            <button class="ViewReportsOne goBtn btn-rounded" type="button" option="edit" option1="community_id" style="color: #00acd7 !important;">
                                Edit
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </form>
    </div>
</div>
@if($userData[0]->levelreport > 1 )
    <div class="col-xl-10 ContentBar">
        <div class="col-lg-12 col-xl-12">
            <form action="/reportSummarySecond" method="post">
                @csrf
                <div class="row align-items-center">
                    
                    <div class="col-md-6 my-2 my-md-0">
                        <div class="d-flex align-items-center">
                            <label class="mr-3 mb-0 d-none d-md-block" style="width: 25%;"><strong>Trend Report</strong></label>
                            <div class="dropdown bootstrap-select form-control">
                                <div class="dropdown bootstrap-select form-control">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-9 col-sm-12">
                                            <div class="dropdown bootstrap-select form-control dropdownC">
                                                @foreach ($viewitems as $key => $item)
                                                    @if ($key == 0)
                                                        <input name="community_id" value={{ $item->id }} class="dn com">
                                                    @endif
                                                @endforeach
                                                @if($userData[0]->levelreport == 1 )
                                                    <div class="dropdown bootstrap-select form-control">
                                                        @foreach ($viewitems as $item)
                                                            @if($item->id == $userData[0]->community_id)
                                                                <button type="button" tabindex="-1" class="btn dropdown-toggle btn-light" data-toggle="dropdown" role="combobox" aria-owns="bs-select-2" aria-haspopup="listbox" aria-expanded="true" title="{{ $item->name }}">
                                                                    <div class="filter-option">
                                                                        <div class="filter-option-inner">
                                                                            <div class="filter-option-inner-inner">{{ $item->name }}</div>
                                                                        </div>
                                                                    </div>
                                                                </button>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                @endif
                                                @if($userData[0]->levelreport > 1 )
                                                    <select class="form-control selectpicker" data-live-search="true" tabindex="null">
                                                        @foreach ($viewitems as $item)
                                                            @if($item->id != 10)
                                                                @if($item->id == $userData[0]->community_id)
                                                                    <option data-tokens="mustard" selected="selected">
                                                                        {{ $item->name }}
                                                                    </option>
                                                                @else
                                                                    <option data-tokens="mustard">
                                                                        {{ $item->name }}
                                                                    </option>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 my-2 my-md-0">
                        <div class="input-icon">
                            <input name="period_id_from" class="dn">
                            <input name="period_id_to" class="dn">
                            <input class="dn submitInput1" type="submit">
                            <button class="goBtn btn-rounded" type="button" option1="community_id">
                                <span class="iconify" data-icon="logos:go" data-inline="false"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endif
@if($userData[0]->levelcompany > 1 )
    <div class="col-xl-12 TitleHeaderBar">
        <h3 class="landingtitle">Company Reports</h3>
    </div>
    <div class="col-xl-10 ContentBar">
        <div class="col-lg-12 col-xl-12">
            <form action="creports" method="POST">
                @csrf
                <div class="row align-items-center">
                    <div class="col-md-6 my-2 my-md-0">
                        <div class="d-flex align-items-center">
                            <label class="mr-3 mb-0 d-none d-md-block vewCompany">
                                <strong>View Company Summary for Period:</strong>&nbsp;
                            </label>
                        </div>
                    </div>
                    <div class="col-md-3 my-2 my-md-0">
                        <div class="input-icon">
                            <input name="period_id" class="dn">
                            <input class="dn submitInput" type="submit">
                            <button class="goBtn btn-rounded" type="button">
                                <span class="iconify" data-icon="logos:go" data-inline="false"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-xl-10 ContentBar">
        <div class="col-lg-12 col-xl-12">
            <form action="creportsSec" method="POST">
                @csrf
                <div class="row align-items-center">
                    <div class="col-md-6 my-2 my-md-0">
                        <label class="mr-3 mb-0 d-none d-md-block vewCompany">
                            <strong>View Company Trend Report </strong>&nbsp;&nbsp;&nbsp;&nbsp;
                        </label>
                    </div>
                    <div class="col-md-3 my-2 my-md-0">
                        <div class="input-icon">
                            <input name="period_id_from" class="dn">
                            <input name="period_id_to" class="dn">
                            <input class="dn submitInput1" type="submit">
                            <button class="goBtn btn-rounded" type="button">
                                <span class="iconify" data-icon="logos:go" data-inline="false"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endif
<div class="col-xl-12">
    <div class="col-xl-12 TitleHeaderBar">
        <hr>
    </div>
    <div class="col-md-5 di">
        <h3> <span style="color: #8950FC !important;">Current</span> <span style="color:#1BC5BD !important;">Census</span></h3>
        <div id="chart_12" class="d-flex justify-content-center"></div>
    </div>
    <div class="col-md-6 di">
        <h3> <span style="color: #1BC5BD !important;">Census</span> vs <span style="color:#8950FC !important;">Capacity</span></h3>
        <div id="chart_3"></div>
    </div>
    <div class="col-xl-12 TitleHeaderBar">
        <hr>
    </div>
</div>

@endsection

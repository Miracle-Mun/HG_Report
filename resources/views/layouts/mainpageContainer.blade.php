@extends('layouts.container')

@section('contents')
<?php
    use App\model\Communities;
    use App\model\periods;
    $viewitems = ( new Communities )->get();
    $perioditems = ( new periods )->orderBy('id','desc')->limit(48)->get();
    $oneItem = json_decode($perioditems);
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    var df =  "<?php echo $oneItem[0]->caption; ?>";
    var dt =  "<?php echo $oneItem[0]->caption; ?>";
    if(localStorage.getItem('period_id_from') == "" || localStorage.getItem('period_id_from') == null || localStorage.getItem('period_id_from') == 'Select correct date' ) {
        localStorage.setItem('period_id_from', df);
    }
    if(localStorage.getItem('period_id_to') == "" || localStorage.getItem('period_id_to') == null || localStorage.getItem('period_id_to') == 'Select correct date' ) {
        localStorage.setItem('period_id_to', dt);
    }
</script>
<script> 
    var communities = <?php echo $viewitems; ?>;
</script>
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
    $('.period_id_from').attr('value', localStorage.getItem('period_id_from'));
    $('.period_id_to').attr('value', localStorage.getItem('period_id_to'));    
</script>
<div class="col-xl-10 TitleHeaderBar">
    <h3 class="landingtitle">View Reports for Any Community</h3>
</div>

<div class="col-xl-10 ContentBar">
    <div class="col-lg-12 col-xl-12">
        <form action="/reportSummary" method="post">
            @csrf
            <div class="row align-items-center">
                <div class="col-md-6 my-2 my-md-0">
                    <div class="d-flex align-items-center">
                        <label class="mr-3 mb-0 d-none d-md-block">View</label>
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
                                            <select class="form-control selectpicker" data-live-search="true" tabindex="null">
                                                @foreach ($viewitems as $item)
                                                    <option data-tokens="mustard">
                                                        {{ $item->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 my-2 my-md-0">
                    <div class="input-icon">
                        <input name="period_id" class="dn period_id">
                        <input class="dn submitInput" type="submit">
                        <button class="ViewReportsOne goBtn btn-rounded" option1="community_id" type="button">
                            <span class="iconify" data-icon="logos:go" data-inline="false"></span>
                        </button>
                    </div>
                </div>
                <div class="col-md-3 my-2 my-md-0">
                    <div class="input-icon">
                        <input class="dn submitInput" type="submit">
                        <button class="ViewReportsOne goBtn btn-rounded" type="button" option="edit" option1="community_id" style="color: #00acd7 !important;">
                            Edit
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="col-xl-10 ContentBar">
    <div class="col-lg-12 col-xl-12">
        <form action="/reportSummarySecond" method="post">
            @csrf
            <div class="row align-items-center">
                
                <div class="col-md-6 my-2 my-md-0">
                    <div class="d-flex align-items-center">
                        <label class="mr-3 mb-0 d-none d-md-block">View</label>
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
                                            <select class="form-control selectpicker" data-live-search="true" tabindex="null">
                                                @foreach ($viewitems as $item)
                                                    <option data-tokens="mustard">
                                                        {{ $item->name }}
                                                    </option>
                                                @endforeach
                                            </select>
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
<div class="col-xl-10 TitleHeaderBar">
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
                            View Company Summary for Period:&nbsp;
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
                        View Company Trend Report &nbsp;&nbsp;&nbsp;&nbsp;
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

@endsection

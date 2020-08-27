@extends('layouts.container')

@section('contents')

    <?php
        use App\model\reports;
        use App\model\periods;
        use App\model\cencaps;
        use App\model\buildings;
        use App\model\moveouts;
        use App\model\inquiries;
        use App\model\Communities;

        $reports = new reports;
        $periods = new periods;
        $cencaps = new cencaps;
        $buildings = new buildings;
        $moveouts = new moveouts;
        $inquiries = new inquiries;
        $Communities = new Communities;

        $info = explode(',', Session::get('info'));
        $reportsData = json_decode($reports->where(['community_id' => $info[0], 'period_id' => $info[1]])->get());
        $cencapsData = json_decode($cencaps->where(['report_id' => $reportsData[0]->id])->get());
        $moveoutsData = json_decode($moveouts->where(['report_id' => $reportsData[0]->id])->get());
        $inquiriesData = json_decode($inquiries->where(['report_id' => $reportsData[0]->id])->get());

        $viewitems = ( new Communities )->get();
    ?>

    <script> 
        var communities = <?php echo $viewitems; ?>;
    </script>

    <div class="row summarycontainer">
        <table class="table table-borderless viewtable table-hover">
            <thead>
                <tr>
                    <form method="POST" action="reportSummary">
                        @csrf
                        <h3 class="px-2 w-100">
                            Report Summary for
                            @foreach ($viewitems as $key => $item)
                                @if ($key == 0)
                                    <input name="community_id" value={{ $item->id }} class="dn com">
                                @endif
                            @endforeach
                            <select class="form-control selectpicker w-20 viewreportcommon" data-live-search="true" tabindex="null">
                                @foreach ($viewitems as $item)
                                    @if($Communities->where(['id' => $info[0]])->get())[0]->id == $item->id)
                                        <option data-tokens="mustard" selected="selected">
                                            {{ $item->name }}
                                        </option>
                                    @else
                                        <option data-tokens="mustard">
                                            {{ $item->name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            from
                            <input class="dn" name="period_id" value="{{ json_decode($periods->where(['id' => $info[1]])->get())[0]->id }}">
                            <input class="dn" type="submit">
                            <input type="button" class="span2 btn-rounded period_id" date="{{ json_decode($periods->where(['id' => $info[1]])->get())[0]->id }}" value="{{ json_decode($periods->where(['id' => $info[1]])->get())[0]->caption }}" onchange="refresh(this)" id="dp1">
                        </h3>
                    </form>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th rowspan="{{ count($cencapsData) + 2 }}" class="MainTitle">Census</th>
                    <th></th>
                    <th>Census</th>
                    <th>Capacity</th>
                    <th>%</th>
                </tr>

                <?php $iNum = 0; $cencusSum = 0; $capacitySum = 0;?>
                @foreach ($cencapsData as $item)
                    <?php
                        $cencusSum += $item->census;
                        $capacitySum += $item->capacity;
                    ?>
                    <tr>
                        <td>
                            {{ json_decode($buildings->where(['id' => $item->building_id])->get())[0]->name }}
                        </td>
                        <td>{{ $item->census }}</td>
                        <td>{{ $item->capacity }}</td>
                        <td>{{ number_format(100 * $item->census/$item->capacity, 2, '.', "") . '%' }}</td>
                    </tr>
                    <?php $iNum++; ?>
                    @if ( $iNum == count($cencapsData))
                        <tr>
                            <th>Total</th>
                            <th>{{ $cencusSum }}</th>
                            <th>{{ $capacitySum }}</th>
                            <th>{{ number_format(100 * $cencusSum/$capacitySum, 2, '.', "") . '%' }}</th>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

        @if (count($inquiriesData) > 0)
            <table class="table table-borderless viewtable table-hover">
                <tbody>
                    <tr>
                        <th rowspan="{{ count($inquiriesData) + 2 }}" class="MainTitle">Inquiries</th>
                        <th>Type</th>
                        <th>Count</th>
                    </tr>
                    <?php $iNum = 0; $numSum = 0;?>
                    @foreach ($inquiriesData as $item)
                        <tr>
                            <td>{{ $item->description }}</td>
                            <td>{{ $item->number }}</td>
                        </tr>
                        <?php $iNum++; $numSum += $item->number; ?>
                        @if ( $iNum == count($inquiriesData))
                            <tr>
                                <th>Total</th>
                                <th>{{ $numSum }}</th>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        @endif

        @if (count($moveoutsData) > 0)
            <table class="table table-borderless viewtable table-hover">
                <tbody>
                    <tr>
                        <th rowspan="{{ count($moveoutsData) + 2 }}" class="MainTitle">Move-Outs</th>
                        <th>Type</th>
                        <th>Count</th>
                    </tr>
                    <?php $iNum = 0; $numSum = 0;?>
                    @foreach ($moveoutsData as $item)
                        <tr>
                            <td>{{ $item->description }}</td>
                            <td>{{ $item->number }}</td>
                        </tr>
                        <?php $iNum++; $numSum += $item->number; ?>
                        @if ( $iNum == count($moveoutsData))
                            <tr>
                                <th>Total</th>
                                <th>{{ $numSum }}</th>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        @endif
        <table class="table table-borderless viewtable table-hover">
            <tbody>
                <tr>
                    <th rowspan="6" class="MainTitle">Statistics</th>
                    <td>Unqualified</td>
                    <td>{{ $reportsData[0]->unqualified }}</td>
                </tr>
                <tr>
                    <td>Tours</td>
                    <td>{{ $reportsData[0]->tours }}</td>
                </tr>
                <tr>
                    <td>Deposits</td>
                    <td>{{ $reportsData[0]->deposits }}</td>
                </tr>
                <tr>
                    <td>Inquiries to Tours</td>
                    @if ($reportsData[0]->deposits == 0)
                        <td>0 %</td>
                    @else
                        <td>{{ number_format( $reportsData[0]->tours / $reportsData[0]->deposits, 2, '.', '') }} %</td>
                    @endif
                </tr>
                <tr>
                    <td>Tours to Deposits</td>
                    @if ($reportsData[0]->tours == 0)
                        <td>0 %</td>
                    @else
                        <td>{{ $reportsData[0]->deposits / $reportsData[0]->tours }} %</td>
                    @endif
                </tr>
            </tbody>
        </table>
        <table class="table table-borderless viewtable table-hover">
            <tbody>
                <tr>
                    <th rowspan="6" class="MainTitle">Move In/Out</th>
                    <td>WTD Move-Ins</td>
                    <td>{{ $reportsData[0]->wtd_movein }}</td>
                </tr>
                <tr>
                    <td>WTD Move-Outs</td>
                    <td>{{ $reportsData[0]->wtd_moveout }}</td>
                </tr>
                <tr>
                    <td>WTD Net Residents</td>
                    <td>{{ $reportsData[0]->wtd_movein - $reportsData[0]->wtd_moveout }}</td>
                </tr>
                <tr>
                    <td>YTD Move-Ins</td>
                    <td>{{ $reportsData[0]->ytd_movein }}</td>
                </tr>
                <tr>
                    <td>YTD Move-Outs</td>
                    <td>{{ $reportsData[0]->ytd_moveout }}</td>
                </tr>
                <tr>
                    <td>YTD Net Residents</td>
                    <td>{{ $reportsData[0]->ytd_movein - $reportsData[0]->ytd_moveout }}</td>
                </tr>
            </tbody>
        </table>
    </div>

@endsection

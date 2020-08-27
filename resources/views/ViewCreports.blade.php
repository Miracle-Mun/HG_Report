@extends('layouts.container')

@section('contents')

    @php
        use App\model\reports;
        use App\model\periods;
        use App\model\cencaps;
        use App\model\buildings;
        use App\model\moveouts;
        use App\model\Communities;

        $reports = new reports;
        $periods = new periods;
        $cencaps = new cencaps;
        $buildings = new buildings;
        $buildingsData = $buildings->get();
        $moveouts = new moveouts;
        $Communities = new Communities;
        $pId = Session::get('period');
        $reportsData = json_decode($reports->where(['period_id' => $pId])->orderBy('community_id')->get());
    @endphp

    <div class="row summarycontainer">
        <table class="table table-borderless viewtable mycontroltable table-sm table-hover">
            @php $sumc = []; $sump = []; @endphp
            <tbody>
                <tr>
                    <th style="font-size: 15px !important; font-weight:bold !important;" rowspan="{{ count($reportsData) + 3 }}" class="MainTitletwo">Current<br>Census</th>
                    <th></th>
                    @foreach ($reportsData as $item)
                        <th>{{ json_decode($Communities->where(['id' => $item->community_id])->get())[0]->name }}</th>
                    @endforeach
                    <th>Total</th>
                </tr>
                @php $wholeSum = [];  @endphp
                @foreach ($buildingsData as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        @php $sum = 0; $oneSum = []; @endphp
                        @foreach ($reportsData as $row)
                            @php $cencapsData = $cencaps->where(['report_id' => $row->id])->get(); $Checkflag = false; @endphp
                            @foreach ($cencapsData as $cencpD)
                                @if ($cencpD->building_id == $item->id && count($oneSum) < 9)
                                    @php $Checkflag = true; $sum += $cencpD->census; array_push($oneSum, $cencpD->census); @endphp
                                    <td>{{ $cencpD->census }}</td>
                                @endif
                            @endforeach
                            @if ($Checkflag == false && count($oneSum) < 9)
                                @php array_push($oneSum, 0); @endphp
                                <td></td>
                            @else
                                @php $Checkflag = false; @endphp
                            @endif
                        @endforeach
                        @php array_push($wholeSum, $oneSum ); @endphp
                        <td>{{ $sum }}</td>
                    </tr>
                @endforeach
                <tr>
                    <th>Total</th>
                    @php $sumas = 0; @endphp
                    @foreach ($wholeSum[0] as $row => $item)
                        @php $suma = 0; @endphp
                        @foreach ($wholeSum as $col => $item)
                            @php $suma += $wholeSum[$col][$row]; @endphp
                        @endforeach
                        @php $sumas += $suma; array_push($sumc, $suma); @endphp
                        <th>{{ $suma }}</th>
                    @endforeach
                    @php array_push($sumc, $sumas); @endphp
                    <th>{{ $sumas }}</th>
                </tr>
            </tbody>
            <tbody>
                @php $wholeSum1 = []; $inum = 0; @endphp
                @foreach ($buildingsData as $item)
                    <tr>
                        @if ($inum == 0)
                            <th style="font-size: 15px !important; font-weight:bold !important;" rowspan="{{ count($reportsData) + 3 }}" class="MainTitletwo">Total<br>Capacity</th>
                            @php $inum++; @endphp
                        @endif
                        <td>{{ $item->name }}</td>
                        @php $sum = 0; $oneSum = []; @endphp
                        @foreach ($reportsData as $row)
                            @php $cencapsData = $cencaps->where(['report_id' => $row->id])->get(); $Checkflag = false; @endphp
                            @foreach ($cencapsData as $cencpD)
                                @if ($cencpD->building_id == $item->id && count($oneSum) < 9)
                                    @php $Checkflag = true; $sum += $cencpD->capacity; array_push($oneSum, $cencpD->capacity); @endphp
                                    <td>{{ $cencpD->capacity }}</td>
                                @endif
                            @endforeach
                            @if ($Checkflag == false && count($oneSum) < 9)
                                @php array_push($oneSum, 0); @endphp
                                <td></td>
                            @else
                                @php $Checkflag = false; @endphp
                            @endif
                        @endforeach
                        @php array_push($wholeSum1, $oneSum ); @endphp
                        <td>{{ $sum }}</td>
                    </tr>
                @endforeach
                <tr>
                    <th>Total</th>
                    @php $sumas = 0; @endphp
                    @foreach ($wholeSum1[0] as $row => $item)
                        @php $suma = 0; @endphp
                        @foreach ($wholeSum1 as $col => $item)
                            @php $suma += $wholeSum1[$col][$row]; @endphp
                        @endforeach
                        @php $sumas += $suma; array_push($sump, $suma); @endphp
                        <th>{{ $suma }}</th>
                    @endforeach
                    @php array_push($sump, $sumas); @endphp
                    <th>{{ $sumas }}</th>
                </tr>
            </tbody>
            <tbody>
                @php $inum = 0; @endphp
                @foreach ($buildingsData as $item)
                    <tr>
                        @if ($inum == 0)
                            <th style="font-size: 15px !important; font-weight:bold !important;" rowspan="{{ count($reportsData) + 3 }}" class="MainTitletwo">Census<br>vs<br>Capacity</th>
                            @php $inum++; @endphp
                        @endif
                        <td>{{ $item->name }}</td>
                        @php $sum1 = 0; $sum2 = 0; $number = 0;@endphp
                        @foreach ($reportsData as $row)
                            @php $cencapsData = $cencaps->where(['report_id' => $row->id])->get(); $Checkflag = false; @endphp
                            @foreach ($cencapsData as $cencpD)
                                @if ($cencpD->building_id == $item->id && $number < 9)
                                    @php $number++; @endphp
                                    @php $Checkflag = true; $sum1 += $cencpD->census;  $sum2 += $cencpD->capacity; @endphp
                                    <td>{{ number_format( 100 * $cencpD->census / $cencpD->capacity, 2, '.', '' ) }} %</td>
                                @endif
                            @endforeach
                            @if ($Checkflag == false && $number < 9)
                                @php $number++; @endphp
                                <td></td>
                            @else
                                @php $Checkflag = false; @endphp
                            @endif
                        @endforeach
                        <td>{{ number_format( 100 * $sum1 / $sum2 , 2, '.', '') }} %</td>
                    </tr>
                @endforeach
                <tr>
                    <th>Total</th>
                    @foreach ($sumc as $key => $item)
                        <th>{{ number_format( 100 * $item / $sump[$key], 2, '.', '') }} %</th>
                    @endforeach
                </tr>
            </tbody>
        </table>
        
        <table class="table table-borderless viewtable mycontroltable table-sm table-hover">
            <tbody>
                <tr>
                    <th style="font-size: 15px !important; font-weight:bold !important;" rowspan="{{ count($reportsData) + 3 }}" class="MainTitletwo">Move-Out<br>Reasons</th>
                    <th></th>
                    @foreach ($reportsData as $item)
                        <th>{{ json_decode($Communities->where(['id' => $item->community_id])->get())[0]->name }}</th>
                    @endforeach
                    <th>Total</th>
                </tr>
                @php $ttArr = []; @endphp
                @foreach ($reportsData as $item)
                    @php $moveOutData = $moveouts->where(['report_id' => $item->id])->get(); @endphp
                    @if (count($moveOutData) > 0)
                        @foreach ($moveOutData as $item)
                            @if(gettype(array_search($item->description, $ttArr)) == 'boolean')
                                @php array_push($ttArr, $item->description); @endphp
                            @endif
                        @endforeach
                    @endif
                @endforeach
                @php $wholeSumArr = []; @endphp
                @foreach ($ttArr as $item)
                    <tr>
                        <td>
                            {{ $item }}
                        </td>
                        @php $sum = 0; $sum_1Arr = []; @endphp
                        @foreach ($reportsData as $row1)
                            @php $moveOutData = $moveouts->where(['report_id' => $row1->id])->get(); $igetNum = 0; @endphp
                            @if (count($moveOutData) > 0)
                                @foreach ($moveOutData as $row)
                                    @if( $item == $row->description && count($sum_1Arr) < 9)  
                                        @php $igetNum++; array_push($sum_1Arr, $row->number); $sum += $row->number;@endphp
                                        <td>{{ $row->number }}</td>
                                    @endif
                                @endforeach
                            @endif
                            @if ($igetNum > 0)
                                @php $igetNum = 0; @endphp
                            @else
                                @if(count($sum_1Arr) < 9)
                                    @php array_push($sum_1Arr, 0); @endphp
                                    <td></td>
                                @endif
                            @endif
                        @endforeach
                        <th>{{ $sum }}</th>
                        @php array_push($sum_1Arr, $sum); array_push($wholeSumArr, $sum_1Arr); $sum_1Arr = []; @endphp
                    </tr>
                @endforeach
                <tr>
                    <th>Total</th>
                    @foreach ($wholeSumArr[0] as $row => $item)
                        @php $sumPart = 0; @endphp
                        @foreach ($wholeSumArr as $col => $item)
                            @php $sumPart += $wholeSumArr[$col][$row]; @endphp
                        @endforeach
                        <th>{{ $sumPart }}</th>
                    @endforeach
                </tr>
            </tbody>
        </table>

        <table class="table table-borderless viewtable mycontroltable table-sm table-hover">
            <tbody>
                <tr>
                    <th style="font-size: 15px !important; font-weight:bold !important;" rowspan="{{ count($reportsData) + 3 }}" class="MainTitletwo">Statistics</th>
                    <th></th>
                    @foreach ($reportsData as $item)
                        <th>{{ json_decode($Communities->where(['id' => $item->community_id])->get())[0]->name }}</th>
                    @endforeach
                    <th>Total</th>
                </tr>
                <tr>
                    <td>Inqueries</td>
                    @php $moveSum = 0; @endphp
                    @foreach ($reportsData as $item)
                        @php $moveSum += $item->unqualified; @endphp
                        <td>{{ $item->unqualified }}</td>
                    @endforeach
                    <td>{{ $moveSum }}</td>
                </tr>
                <tr>
                    <td>Unqualified</td>
                    @php $moveSum = 0; @endphp
                    @foreach ($reportsData as $item)
                        @php $moveSum += $item->unqualified; @endphp
                        <td>{{ $item->unqualified }}</td>
                    @endforeach
                    <td>{{ $moveSum }}</td>
                </tr>
                <tr>
                    <td>Tours</td>
                    @php $moveSum = 0; @endphp
                    @foreach ($reportsData as $item)
                        @php $moveSum += $item->tours; @endphp
                        <td>{{ $item->tours }}</td>
                    @endforeach
                    <td>{{ $moveSum }}</td>
                </tr>
                <tr>
                    <td>Deposits</td>
                    @php $moveSum = 0; @endphp
                    @foreach ($reportsData as $item)
                        @php $moveSum += $item->deposits; @endphp
                        <td>{{ $item->deposits }}</td>
                    @endforeach
                    <td>{{ $moveSum }}</td>
                </tr>
                <tr>
                    <td>Inquiries to Tour</td>
                    @php $moveSum = 0; @endphp
                    @foreach ($reportsData as $item)
                        @if ($item->tours == 0)
                            <td>0 %</td>
                        @else
                            @php $moveSum += $item->deposits / $item->tours; @endphp
                            <td>{{ $item->deposits / $item->tours }} %</td>
                        @endif
                    @endforeach
                    <td>{{ $moveSum }}</td>
                </tr>
                <tr>
                    <td>Tours to Deposits</td>
                    @php $moveSum = 0; @endphp
                    @foreach ($reportsData as $item)
                        @if ($item->tours == 0)
                            <td>0 %</td>
                        @else
                            @php $moveSum += $item->deposits / $item->tours; @endphp
                            <td>{{ $item->deposits / $item->tours }} %</td>
                        @endif
                    @endforeach
                    <td>{{ $moveSum }}</td>
                </tr>
            </tbody>
        </table>

        <table class="table table-borderless viewtable table-sm table-hover">
            <tbody>
                <tr class="titledate">
                    <th class="MainTitletwo" rowspan="{{ count($reportsData) + 10 }}">Move In/Out</th>
                    <th></th>
                    @foreach ($reportsData as $item)
                        <th>{{ json_decode($Communities->where(['id' => $item->community_id])->get())[0]->name }}</th>
                    @endforeach
                    <th>Total</th>
                </tr>
                <tr>
                    <td>WTD Move-Ins</td>
                    @php $moveSum = 0; @endphp
                    @foreach ($reportsData as $item)
                        @php $moveSum += $item->wtd_movein; @endphp
                        <td>{{ $item->wtd_movein }}</td>
                    @endforeach
                    <td>{{ $moveSum }}</td>
                </tr>
                <tr>
                    <td>WTD Move-Outs</td>
                    @php $moveSum = 0; @endphp
                    @foreach ($reportsData as $item)
                        @php $moveSum += $item->wtd_moveout; @endphp
                        <td>{{ $item->wtd_moveout }}</td>
                    @endforeach
                    <td>{{ $moveSum }}</td>
                </tr>
                <tr>
                    <td>WTD Net Residents</td>
                    @php $moveSum = 0; @endphp
                    @foreach ($reportsData as $item)
                        @php $moveSum += $item->wtd_movein - $item->wtd_moveout; @endphp
                        <td>{{ $item->wtd_movein - $item->wtd_moveout }}</td>
                    @endforeach
                    <td>{{ $moveSum }}</td>
                </tr>
                <tr>
                    <td>YTD Move-Ins</td>
                    @php $moveSum = 0; @endphp
                    @foreach ($reportsData as $item)
                        @php $moveSum += $item->ytd_movein; @endphp
                        <td>{{ $item->ytd_movein }}</td>
                    @endforeach
                    <td>{{ $moveSum }}</td>
                </tr>
                <tr>
                    <td>YTD Move-Outs</td>
                    @php $moveSum = 0; @endphp
                    @foreach ($reportsData as $item)
                        @php $moveSum += $item->ytd_moveout; @endphp
                        <td>{{ $item->ytd_moveout }}</td>
                    @endforeach
                    <td>{{ $moveSum }}</td>
                </tr>
                <tr>
                    <td>YTD Net Residents</td>
                    @php $moveSum = 0; @endphp
                    @foreach ($reportsData as $item)
                        @php $moveSum += $item->ytd_movein - $item->ytd_moveout; @endphp
                        <td>{{ $item->ytd_movein - $item->ytd_moveout }}</td>
                    @endforeach
                    <td>{{ $moveSum }}</td>
                </tr>
            </tbody>
        </table>

    </div>

@endsection

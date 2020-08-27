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
        $reportsData = json_decode($reports->where(['community_id' => $info[0], ['period_id', '>=', $info[1]],  ['period_id', '<=', $info[2]] ])->get());
        $mainPeriod = json_decode($periods->where([['id', '>=', $info[1]],  ['id', '<=', $info[2]] ])->get());
        $inquiriesData2 = [];
        foreach ($reportsData as $key => $value) {
            $row = json_decode($inquiries->where(['report_id' => $value->id])->groupBy('report_id')->get()); 
            array_push($inquiriesData2, $row);                         
        }

        $finalArr = [];
        foreach($reportsData as $knowNumber => $item) {

            $data = json_decode($cencaps->where(['report_id' => $item->id])->get());

            $idArr = [];
            for( $i = count($data) - 1 ; $i >= 0 ; $i--) {
                if(gettype(array_search($data[$i]->building_id, $idArr)) == 'boolean') {
                    array_push($finalArr, $data[$i]);
                }
                array_push($idArr, $data[$i]->building_id);
            }

        }
        $idArr = [];
        $oneArr = [];
        for( $i = 0 ; $i < count($finalArr) ; $i++) {
            $myId = $finalArr[$i]->building_id;
            if(gettype(array_search($myId, $idArr)) == 'boolean') {
                $oneArr[$myId] = [];
                array_push($idArr, $myId);
                array_push($oneArr[$myId], $finalArr[$i]);
            }
            else {
                array_push($oneArr[$myId], $finalArr[$i]);
            }
        }
        $sumArrFinal = [];

        $moveoutDates = [];
        foreach ($mainPeriod as $key => $value) {
            array_push($moveoutDates, $value->caption);
            if($key == count($mainPeriod) - 1) {
                array_push($moveoutDates, 'Total');
                array_push($moveoutDates, 'Average');
            }
        }
        $moveoutDescriptions = [];
        foreach ($reportsData as $key => $value) {
            $moveoutsData = json_decode($moveouts->where(['report_id' => $value->id])->get());
            if(count($moveoutsData) > 0) {
                array_push($moveoutDescriptions, $moveoutsData[0]->description);
            }
        }
    ?>

    <div class="row summarycontainer">
        <table class="table table-borderless viewtable mycontroltable  table-sm table-hover">
            <tbody>
                <tr class="headbang">
                    <th style="font-size: 15px !important; font-weight:bold !important;" rowspan="{{ count($reportsData) + 3 }}" class="MainTitletwo">Current<br>Census</th>
                    <th></th>
                    @foreach ($mainPeriod as $key => $item)
                        <th>{{ $item->caption }}</th>
                    @endforeach
                    <th style="font-size: 15px !important; font-weight:bold !important;">Average</th>
                </tr>
                <?php $AllArr = []; $mainSum1 = 0; $i_num1 = 0;?>
                @foreach ($oneArr as $key => $item)
                    <tr>
                        <td>{{ json_decode($buildings->where( [ 'id' => $key ] )->get())[0]->name }}</td>
                        <?php $sum = 0; $onArr = [];?>
                        @foreach ($item as $row)
                            <?php $sum += $row->census; array_push($onArr, $row->census); ?>
                            <td>{{ $row->census }}</td>
                        @endforeach
                        <?php array_push($AllArr, $onArr); $mainSum1 += number_format($sum / count($item), 2, '.', "") ;?>
                        <td>{{ number_format($sum / count($item), 2, '.', "") }}</td>
                    </tr>
                    <?php $i_num1++; ?>
                    @if ($i_num1 == count($oneArr))
                        <tr>
                            <th>Total</th>
                            @foreach ($AllArr[0] as $mainkey => $one)
                                <?php $allSum = 0; ?>
                                @foreach ($AllArr as $key_val => $Arr)
                                    <?php $allSum += $AllArr[$key_val][$mainkey]; ?>
                                @endforeach
                                <?php array_push($sumArrFinal, $allSum); ?>
                                <td>{{ $allSum }}</td>
                            @endforeach
                            <td>{{ $mainSum1 }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
            <tbody>
                <?php $AllArr = []; $mainSum2 = 0; $i_num2 = 0;?>
                @foreach ($oneArr as $key => $item)
                    <tr>
                        @if ($mainSum2 == 0)
                            <th style="font-size: 15px !important; font-weight:bold !important;" rowspan="{{ count($reportsData) + 3 }}" class="MainTitletwo">Total<br>Capacity</th>
                        @endif
                        <td>{{ json_decode($buildings->where( [ 'id' => $key ] )->get())[0]->name }}</td>
                        <?php $sum = 0; $onArr = [];?>
                        @foreach ($item as $row)
                            <?php $sum += $row->capacity; array_push($onArr, $row->capacity); ?>
                            <td>{{ $row->capacity }}</td>
                        @endforeach
                        <?php array_push($AllArr, $onArr); $mainSum2 += number_format($sum / count($item), 2, '.', "") ;?>
                        <td>{{ number_format($sum / count($item), 2, '.', "") }}</td>
                    </tr>
                    <?php $i_num2++; ?>
                    @if ($i_num2 == count($oneArr))
                        <tr>
                            <th>Total</th>
                            @foreach ($AllArr[0] as $mainkey => $one)
                                <?php $allSum = 0; ?>
                                @foreach ($AllArr as $key_val => $Arr)
                                    <?php $allSum += $AllArr[$key_val][$mainkey]; ?>
                                @endforeach
                                <?php $sumArrFinal[$mainkey] = number_format( 100 * $sumArrFinal[$mainkey] / $allSum, 2, '.', "") ; ?>
                                <td>{{ $allSum }}</td>
                            @endforeach
                            <td>{{ $mainSum2 }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
            <tbody>
                <?php $AllArr = []; $mainSum = 0; $i_num3 = 0;?>
                @foreach ($oneArr as $key => $item)
                    <tr>
                        @if ($i_num3 == 0)
                            <th style="font-size: 15px !important; font-weight:bold !important;" rowspan="{{ count($reportsData) + 3 }}" class="MainTitletwo">Census<br> vs<br> Capacity</th>
                        @endif
                        <td>{{ json_decode($buildings->where( [ 'id' => $key ] )->get())[0]->name }}</td>
                        <?php $sum = 0; $onArr = [];?>
                        @foreach ($item as $row)
                            <?php $sum += number_format($row->census * 100 / $row->capacity, 2, '.', ""); array_push($onArr, number_format($row->census * 100 / $row->capacity, 2, '.', "")); ?>
                            <td>{{ number_format($row->census * 100 / $row->capacity, 2, '.', "") }} %</td>
                        @endforeach
                        <?php array_push($AllArr, $onArr); $mainSum += number_format($sum / count($item), 2, '.', "") ;?>
                        <td>{{ number_format($sum / count($item), 2, '.', "") }} %</td>
                    </tr>
                    <?php $i_num3++; ?>
                    @if ($i_num3 == count($oneArr))
                        <tr>
                            <th>Total</th>
                            @foreach ($sumArrFinal as $mainkey => $one)
                                <td>{{ $one }} %</td>
                            @endforeach
                            <td>{{ number_format( 100 * $mainSum1 / $mainSum2, 2, '.', "") }} %</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        @if (count($inquiriesData2) > 0)
            <table class="table table-borderless viewtable mycontroltable  table-sm table-hover">
                <tbody>
                    <tr class="titledate">
                        <th class="MainTitletwo" rowspan="{{ count($inquiriesData2) + 10 }}">Type <br> of <br> Inquiries</th>
                        <td></td>
                        @foreach ($moveoutDates as $item)
                            <td>{{ $item }}</td>
                        @endforeach
                    </tr>
                    @foreach ($ownmainData as $item)
                        <tr>
                            <td>{{ $item->description }}</td>
                            @php $sum = 0; @endphp
                            @foreach ($periodsData2 as $da)
                                @if ($da['id'] == $item->period_id)
                                    @php $sum += $item->sum; @endphp
                                    <td>{{ $item->sum }}</td>
                                @else
                                    <td>0</td>
                                @endif
                            @endforeach
                            <td>{{ $sum }}</td>
                            <td>{{ number_format($sum/count($periodsData2), 2, '.', '') }}</td>
                        </tr>
                    @endforeach
                    <tr>
                        <th>Total</th>
                        @foreach ($periodsData2 as $da)
                            @php $sum = 0; @endphp
                            @foreach ($WholeSum as $item)
                                @if ($da['id'] == $item->period_id)
                                    @php $sum += $item->sum; @endphp
                                    <td>{{ $item->sum }}</td>
                                @else
                                    <td>0</td>
                                @endif
                            @endforeach
                        @endforeach
                        <td>{{ $sum }}</td>
                        <td>{{ number_format($sum/count($periodsData2), 2, '.', '') }}</td>
                    </tr>
                </tbody>
            </table>
        @endif
        @if(count($moveoutDescriptions) > 0)
            <table class="table table-borderless viewtable mycontroltable  table-sm table-hover">
                <tbody>
                    <tr class="titledate">
                        <th class="MainTitletwo" rowspan="{{ count($moveoutDescriptions) + 3 }}">Move-Out <br> Reasons</th>
                        <td></td>
                        @foreach ($moveoutDates as $item)
                            <td>{{ $item }}</td>
                        @endforeach
                    </tr>
                    @foreach ($moveoutDescriptions as $item)
                        <tr>
                            <td>{{ $item }}</td>
                            <?php  $myval = 0; ?>
                            @foreach ($reportsData as $value)
                                <?php $moveoutsData = json_decode($moveouts->where(['report_id' => $value->id])->get());?>
                                @if(count($moveoutsData) > 0 && $moveoutsData[0]->description == $item)
                                    <?php $myval += $moveoutsData[0]->number; ?>
                                    <td>{{ $moveoutsData[0]->number }}</td>
                                @else
                                    <td></td>
                                @endif
                            @endforeach
                            <td>{{ $myval }}</td>
                            <td>{{ number_format( $myval / count($moveoutDates), 2,'.', '' ) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        <table class="table table-borderless viewtable mycontroltable  table-sm table-hover">
            <tbody>
                <tr class="titledate">
                    <th class="MainTitletwo" rowspan="{{ count($moveoutDescriptions) + 10 }}">Statistics</th>
                    <td></td>
                    @foreach ($moveoutDates as $item)
                        <td>{{ $item }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td>Inqueries</td>
                    <?php $moveSum = 0; ?>
                    @foreach ($reportsData as $item)
                        <?php $moveSum += $item->unqualified; ?>
                        <td>{{ $item->unqualified }}</td>
                    @endforeach
                    <td>{{ $moveSum }}</td>
                    <td>{{ number_format( $moveSum / count($reportsData), 2, '.', '') }}</td>
                </tr>
                <tr>
                    <td>Unqualified</td>
                    <?php $moveSum = 0; ?>
                    @foreach ($reportsData as $item)
                        <?php $moveSum += $item->unqualified; ?>
                        <td>{{ $item->unqualified }}</td>
                    @endforeach
                    <td>{{ $moveSum }}</td>
                    <td>{{ number_format( $moveSum / count($reportsData), 2, '.', '') }}</td>
                </tr>
                <tr>
                    <td>Tours</td>
                    <?php $moveSum = 0; ?>
                    @foreach ($reportsData as $item)
                        <?php $moveSum += $item->tours; ?>
                        <td>{{ $item->tours }}</td>
                    @endforeach
                    <td>{{ $moveSum }}</td>
                    <td>{{ number_format( $moveSum / count($reportsData), 2, '.', '') }}</td>
                </tr>
                <tr>
                    <td>Deposits</td>
                    <?php $moveSum = 0; ?>
                    @foreach ($reportsData as $item)
                        <?php $moveSum += $item->deposits; ?>
                        <td>{{ $item->deposits }}</td>
                    @endforeach
                    <td>{{ $moveSum }}</td>
                    <td>{{ number_format( $moveSum / count($reportsData), 2, '.', '') }}</td>
                </tr>
                <tr>
                    <td>Inquiries to Tour</td>
                    <?php $moveSum = 0; ?>
                    @foreach ($reportsData as $item)
                        @if ($item->tours == 0)
                            <td>0 %</td>
                        @else
                            <?php $moveSum += $item->deposits / $item->tours; ?>
                            <td>{{ $item->deposits / $item->tours }} %</td>
                        @endif
                    @endforeach
                    <td>{{ $moveSum }}</td>
                    <td>{{ number_format( $moveSum / count($reportsData), 2, '.', '') }}</td>
                </tr>
                <tr>
                    <td>Tours to Deposits</td>
                    <?php $moveSum = 0; ?>
                    @foreach ($reportsData as $item)
                        @if ($item->tours == 0)
                            <td>0 %</td>
                        @else
                            <?php $moveSum += $item->deposits / $item->tours; ?>
                            <td>{{ $item->deposits / $item->tours }} %</td>
                        @endif
                    @endforeach
                    <td>{{ $moveSum }}</td>
                    <td>{{ number_format( $moveSum / count($reportsData), 2, '.', '') }}</td>
                </tr>
            </tbody>
        </table>

        <table class="table table-borderless viewtable  table-sm table-hover">
            <tbody>
                <tr class="titledate">
                    <th class="MainTitletwo" rowspan="{{ count($moveoutDescriptions) + 10 }}">Move In/Out</th>
                    <td></td>
                    @foreach ($moveoutDates as $item)
                        <td>{{ $item }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td>WTD Move-Ins</td>
                    <?php $moveSum = 0; ?>
                    @foreach ($reportsData as $item)
                        <?php $moveSum += $item->wtd_movein; ?>
                        <td>{{ $item->wtd_movein }}</td>
                    @endforeach
                    <td>{{ $moveSum }}</td>
                    <td>{{ number_format( $moveSum / count($reportsData), 2, '.', '') }}</td>
                </tr>
                <tr>
                    <td>WTD Move-Outs</td>
                    <?php $moveSum = 0; ?>
                    @foreach ($reportsData as $item)
                        <?php $moveSum += $item->wtd_moveout; ?>
                        <td>{{ $item->wtd_moveout }}</td>
                    @endforeach
                    <td>{{ $moveSum }}</td>
                    <td>{{ number_format( $moveSum / count($reportsData), 2, '.', '') }}</td>
                </tr>
                <tr>
                    <td>WTD Net Residents</td>
                    <?php $moveSum = 0; ?>
                    @foreach ($reportsData as $item)
                        <?php $moveSum += $item->wtd_movein - $item->wtd_moveout; ?>
                        <td>{{ $item->wtd_movein - $item->wtd_moveout }}</td>
                    @endforeach
                    <td>{{ $moveSum }}</td>
                    <td>{{ number_format( $moveSum / count($reportsData), 2, '.', '') }}</td>
                </tr>
                <tr>
                    <td>YTD Move-Ins</td>
                    <?php $moveSum = 0; ?>
                    @foreach ($reportsData as $item)
                        <?php $moveSum += $item->ytd_movein; ?>
                        <td>{{ $item->ytd_movein }}</td>
                    @endforeach
                    <td>{{ $moveSum }}</td>
                    <td>{{ number_format( $moveSum / count($reportsData), 2, '.', '') }}</td>
                </tr>
                <tr>
                    <td>YTD Move-Outs</td>
                    <?php $moveSum = 0; ?>
                    @foreach ($reportsData as $item)
                        <?php $moveSum += $item->ytd_moveout; ?>
                        <td>{{ $item->ytd_moveout }}</td>
                    @endforeach
                    <td>{{ $moveSum }}</td>
                    <td>{{ number_format( $moveSum / count($reportsData), 2, '.', '') }}</td>
                </tr>
                <tr>
                    <td>YTD Net Residents</td>
                    <?php $moveSum = 0; ?>
                    @foreach ($reportsData as $item)
                        <?php $moveSum += $item->ytd_movein - $item->ytd_moveout; ?>
                        <td>{{ $item->ytd_movein - $item->ytd_moveout }}</td>
                    @endforeach
                    <td>{{ $moveSum }}</td>
                    <td>{{ number_format( $moveSum / count($reportsData), 2, '.', '') }}</td>
                </tr>
            </tbody>
        </table>
        
    </div>
@endsection

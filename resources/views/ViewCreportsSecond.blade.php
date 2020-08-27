@extends('layouts.container')

@section('contents')

    <div class="row summarycontainer">
        <table class="table table-borderless viewtable table-sm table-hover">
            <tbody>
                <tr>
                    <th rowspan="{{ count($wholeData) + 3 }}"  class="MainTitletwo">
                        Current<br> Census
                    </th>
                    <th></th>
                    @foreach ($periodsData as $item)
                        <th>{{ $item->caption }}</th>
                    @endforeach
                    <th>Average</th>
                </tr>
                @foreach ($wholeData as $key1 => $items)
                    <tr>
                        <td>{{ $buildingsData[$key1]->name }}</td>
                        @foreach ($items[0] as $item)
                            @foreach ($item as $val)
                                <td>{{ $val }}</td>
                            @endforeach
                        @endforeach
                        @foreach ($items[1] as $item)
                            @foreach ($item as $val)
                                <th>{{ number_format( $val / count($items[0]), 2, '.', '' ) }}</th>
                            @endforeach
                        @endforeach
                    </tr>
                @endforeach
                <tr>
                    <th>Total</th>
                    @foreach ($totalData as $key1 => $items)
                        @foreach ($items as $item)
                            @foreach ($item as $val)
                                <th>{{ $val }}</th>
                            @endforeach
                        @endforeach
                    @endforeach
                    @foreach ($data as $key1 => $items)
                        @foreach ($items as $item)
                            <th>{{ number_format( $item / count($totalData), 2, '.', '' ) }}</th>
                        @endforeach
                    @endforeach
                </tr>
            </tbody>
            
            <tbody>
                @foreach ($wholeData1 as $key1 => $items)
                    <tr>
                        @if ($key1 == 0)
                            <th rowspan="{{ count($wholeData1) + 3 }}"  class="MainTitletwo">
                                Total<br> Capacity
                            </th>
                        @endif
                        <td>{{ $buildingsData[$key1]->name }}</td>
                        @foreach ($items[0] as $item)
                            @foreach ($item as $val)
                                <td>{{ $val }}</td>
                            @endforeach
                        @endforeach
                        @foreach ($items[1] as $item)
                            @foreach ($item as $val)
                                <th>{{ number_format( $val / count($items[0]), 2, '.', '' ) }}</th>
                            @endforeach
                        @endforeach
                    </tr>
                @endforeach
                <tr>
                    <th>Total</th>
                    @foreach ($totalData1 as $key1 => $items)
                        @foreach ($items as $item)
                            @foreach ($item as $val)
                                <th>{{ $val }}</th>
                            @endforeach
                        @endforeach
                    @endforeach
                    @foreach ($data1 as $key1 => $items)
                        @foreach ($items as $item)
                            <th>{{ number_format( $item / count($totalData1), 2, '.', '' ) }}</th>
                        @endforeach
                    @endforeach
                </tr>
            </tbody>

            <tbody>
                @foreach ($wholeData2 as $key1 => $items)
                    <tr>
                        @if ($key1 == 0)
                            <th rowspan="{{ count($wholeData2) + 3 }}"  class="MainTitletwo">
                                Total<br> Capacity
                            </th>
                        @endif
                        <td>{{ $buildingsData[$key1]->name }}</td>
                        @foreach ($items[0] as $item)
                            @foreach ($item as $val)
                                <td>{{ number_format(100*$val, 2,'.','') }} %</td>
                            @endforeach
                        @endforeach
                        @foreach ($items[1] as $item)
                            @foreach ($item as $val)
                                <th>{{ number_format( 100 * $val , 2, '.', '' ) }} %</th>
                            @endforeach
                        @endforeach
                    </tr>
                @endforeach
                <tr>
                    <th>Total</th>
                    @foreach ($totalData2 as $key1 => $items)
                        @foreach ($items as $item)
                            @foreach ($item as $val)
                                <th>{{ number_format(100 * $val, 2,'.','') }} %</th>
                            @endforeach
                        @endforeach
                    @endforeach
                    @foreach ($data2 as $key1 => $items)
                        @foreach ($items as $item)
                            <th>{{ number_format(100*$item, 2,'.','') }} %</th>
                        @endforeach
                    @endforeach
                </tr>
            </tbody>

        </table>
        <table class="table table-borderless viewtable mycontroltable table-sm table-hover">
            <tbody>
                <tr>
                    <th rowspan="{{ count($MoveoutData) + 3 }}"  class="MainTitletwo">
                        Move-Out <br> Reasons
                    </th>
                    <th></th>
                    @foreach ($periodsData as $item)
                        <th>{{ $item->caption }}</th>
                    @endforeach
                    <th>Total</th>
                    <th>Average</th>
                </tr>
                @foreach ($MoveoutData as $row)
                    <tr>
                        <td>
                            {{ $row->description }}
                        </td>
                        @foreach ($periodsData2 as $items)
                            @php
                                $flag = false;
                            @endphp
                            @foreach ($MoveoutData2 as $item)
                                @if ($items['id'] == $item->period_id && $row->description == $item->description)
                                    <td>
                                        {{ $item->sum }}
                                    </td>
                                    @php
                                        $flag = true;
                                    @endphp
                                @endif
                            @endforeach
                            @if ($flag == false)
                                <td></td>
                            @endif
                        @endforeach
                        <td>{{ $row->sum }}</td>
                        <td>{{ number_format( $row->sum / count($periodsData2), 1, '.', '' )  }}</td>
                    </tr>
                @endforeach
                <tr>
                    <th>Total</th>
                    @foreach ($finaltotalData as $item)
                        <th>{{ $item->sum }}</th>
                    @endforeach
                    @foreach ($finalwholetotalData as $item)
                        <th>{{ $item->sum }}</th>
                        <th>{{ number_format( $item->sum / count($finaltotalData) , 1, '.', '') }}</th>
                    @endforeach
                </tr>
            </tbody>
        </table>
        <table class="table table-borderless viewtable mycontroltable table-sm table-hover">
            <tbody>
                <tr>
                    <th rowspan="{{ count($MoveoutData) + 3 }}"  class="MainTitletwo">
                        Statistics
                    </th>
                    <th></th>
                    @foreach ($periodsData as $item)
                        <th>{{ $item->caption }}</th>
                    @endforeach
                    <th>Total</th>
                    <th>Average</th>
                </tr>
                <tr>
                    <td>Inqueries</td>
                    @foreach ($reportsData as $item)
                        <td>{{ $item->total_unqualified }}</td>
                    @endforeach
                    @foreach ($reportsData1 as $item)
                        <td>{{ $item->total_unqualified }}</td>
                        <td>{{ number_format($item->total_unqualified/count($reportsData),0,'.','') }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td>Unqualified</td>
                    @foreach ($reportsData as $item)
                        <td>{{ $item->total_unqualified }}</td>
                    @endforeach
                    @foreach ($reportsData1 as $item)
                        <td>{{ $item->total_unqualified }}</td>
                        <td>{{ number_format($item->total_unqualified/count($reportsData),0,'.','') }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td>Tours</td>
                    @foreach ($reportsData as $item)
                        <td>{{ $item->total_tours }}</td>
                    @endforeach
                    @foreach ($reportsData1 as $item)
                        <td>{{ $item->total_tours }}</td>
                        <td>{{ number_format($item->total_tours/count($reportsData),0,'.','') }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td>Deposits</td>
                    @foreach ($reportsData as $item)
                        <td>{{ $item->total_deposits }}</td>
                    @endforeach
                    @foreach ($reportsData1 as $item)
                        <td>{{ $item->total_deposits }}</td>
                        <td>{{ number_format($item->total_deposits/count($reportsData),0,'.','') }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td>Inquiries to Tour</td>
                    @foreach ($reportsData as $item)
                        @if ($item->total_tours == 0)
                            <td>0 %</td>
                        @else
                            <td>{{ $item->total_deposits / $item->total_tours }} %</td>
                        @endif
                    @endforeach
                    <td></td>
                    <td>0 %</td>
                </tr>
                <tr>
                    <td>Tours to Deposits</td>
                    @foreach ($reportsData as $item)
                        @if ($item->total_deposits == 0)
                            <td>0 %</td>
                        @else
                            <td>{{ $item->total_tours / $item->total_deposits }} %</td>
                        @endif
                    @endforeach
                    <td></td>
                    <td>0 %</td>
                </tr>
            </tbody>
        </table>
        <table class="table table-borderless viewtable mycontroltable table-sm table-hover">
            <tbody>
                <tr>
                    <th rowspan="{{ count($MoveoutData) + 3 }}"  class="MainTitletwo">
                        Move <br> In/Out
                    </th>
                    <th></th>
                    @foreach ($periodsData as $item)
                        <th>{{ $item->caption }}</th>
                    @endforeach
                    <th>Total</th>
                    <th>Average</th>
                </tr>
                <tr>
                    <td>WTD Move-Ins</td>
                    @foreach ($reportsData as $item)
                        <td>{{ $item->total_wtd_movein }}</td>
                    @endforeach
                    @foreach ($reportsData1 as $item)
                        <td>{{ $item->total_wtd_movein }}</td>
                        <td>{{ number_format($item->total_wtd_movein/count($reportsData),1,'.','') }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td>WTD Move-Outs</td>
                    @foreach ($reportsData as $item)
                        <td>{{ $item->total_wtd_moveout }}</td>
                    @endforeach
                    @foreach ($reportsData1 as $item)
                        <td>{{ $item->total_wtd_moveout }}</td>
                        <td>{{ number_format($item->total_wtd_moveout/count($reportsData),1,'.','') }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td>WTD Net Residents</td>
                    @foreach ($reportsData as $item)
                        <td>{{ $item->total_wtd_movein - $item->total_wtd_moveout }}</td>
                    @endforeach
                    @foreach ($reportsData1 as $item)
                        <td>{{ $item->total_wtd_movein - $item->total_wtd_moveout }}</td>
                        <td>{{ number_format(($item->total_wtd_movein - $item->total_wtd_moveout)/count($reportsData), 1, '.','') }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td>YTD Move-Ins</td>
                    @foreach ($reportsData as $item)
                        <td>{{ $item->total_ytd_movein }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td>YTD Move-Outs</td>
                    @foreach ($reportsData as $item)
                        <td>{{ $item->total_ytd_moveout }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td>YTD Net Residents</td>
                    @foreach ($reportsData as $item)
                        <td>{{ $item->total_ytd_movein - $item->total_ytd_moveout }}</td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    </div>
@endsection

@extends('layouts.container')

@section('contents')

<!-- Button trigger modal-->
<button type="button" class="btn btn-primary dn uploadBtn" data-toggle="modal" data-target="#exampleModalCustomScrollable">
    Launch demo modal
</button>

<!-- Modal-->
<div class="modal fade" id="exampleModalCustomScrollable" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">File Upload</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <div data-scroll="true" data-height="300">
                    <div class="container mt-5">
                        <form action="{{route('fileUpload')}}" method="post" enctype="multipart/form-data">
                            <h3 class="text-center mb-5">Please upload only "csv" file</h3>
                                @csrf
                                @if ($message = Session::get('success'))
                                <div class="alert alert-success">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @endif
                        
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                    
                            <div class="custom-file">
                                <input type="file" name="file" class="custom-file-input" id="chooseFile">
                                <label class="custom-file-label" for="chooseFile">Select file</label>
                            </div>
                    
                            <button type="submit" name="submit" class="btn btn-primary btn-block mt-4">
                                Upload File
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card card-custom card-stretch" id="kt_page_stretched_card">
    <div class="card-header">
        <div class="card-title">
            <h3 class="card-label">{{ $userData->name }}'s Profile</small></h3>
        </div>
    </div>
    <div class="card-body">
        <div class="card-scroll w-100">
            <div class="row w-100">
                <div class="col-md-3">
                    <div class="card-label tac fwb">Name</div>
                </div>
                <div class="col-md-3">
                    <div class="card-label tac fwb">Email</div>
                </div>
                <div class="col-md-3">
                </div>
                <div class="col-md-3">
                </div>
            </div>
            <div class="row w-100">
                <div class="col-md-3">
                    <input type="text" class="form-control profileuser" value="{{ $userData->username }}">
                </div>
                <div class="col-md-3">
                    <input type="text" class="form-control profileemail" value="{{ $userData->email }}">
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary changePass" type="button">Change Password</button>
                    <button class="btn btn-primary cancellBtn" style="display: none;" type="button">Cancel</button>
                </div>
                <div class="col-md-3">
                    <form action="/changepass" method="POST">
                        @csrf
                        <input type="submit" class="dn changeConfirmBtn">
                        <input style="display: none;" name="mainId" value="{{ $userData->user_id }}" />
                        <input style="display: none;" name="username" value="{{ $userData->username }}" />
                        <div>
                            <input class="form-control h-auto form-control-solid py-4 px-8" style="display: none;" type="password" id="changePass" placeholder="Password" name="changePass" required />
                            <input class="form-control h-auto form-control-solid py-4 px-8" style="display: none;" type="password" id="ConfirmPass" placeholder="Confirm Password" name="cpassword" required />
                        </div>
                    </form>
                </div>
            </div>
            <div>
                <hr>
            </div>
            <div class="row w-100">
                <div class="col-md-3">
                    <div class="card-label tac">
                        <span class="fwb">
                            location : 
                        </span>
                        <input type="text" class="form-control" disabled="disabled" value="{{ $userData->name }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card-label tac">
                        <span class="fwb">
                            Position : 
                        </span>
                        <input type="text" class="form-control" disabled="disabled" value="{{ $userData->position }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card-label tac">
                        <span class="fwb">
                            last log in : 
                        </span>
                        <input type="text" class="form-control" disabled="disabled" value="{{ $userData->last_login }}">
                    </div>
                </div>
                <div class="col-md-3">
                </div>
            </div>
            <div>
                <hr>
            </div>
            <div class="row w-100 tac" style="font-size: 30px; font-weight: bold; display: block;">
                Your last reports
            </div>
            <div class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded" id="kt_datatable" style="height: 70% !important;">
                <table class="datatable-table  table-sm table-hover" id="kt_datatable2" style="display: block; height: 100% ;">
                    <thead class="datatable-head">
                        <tr class="datatable-row sortEmotic" SDType="profileSD" style="left: 0px;">
                            <th id="sortname0" data-field="RecordID" style="width: 5%;" class="datatable-cell-left datatable-cell datatable-cell-sort datatable-cell-sorted" data-sort="asc">
                                <span>#</span>
                            </th>
                            <th id="sortname1" data-field="Name" style="width: 25%;" class="datatable-cell datatable-cell-sort">
                                <span>Location of the report</span>
                            </th>
                            <th id="sortname2" data-field="Community" style="width: 20%;" class="datatable-cell datatable-cell-sort">
                                <span>Date of the report</span>
                            </th>
                            <th id="sortname3" data-field="Position" style="width: 5%;" class="datatable-cell datatable-cell-sort">
                                <span>Status</span>
                            </th>
                            <th id="sortname4" data-field="password" style="width: 15%;" class="datatable-cell datatable-cell-sort">
                                <span>Time of the edit</span>
                            </th>
                            <th id="sortname5" data-field="Status" style="width: 15%;" class="datatable-cell datatable-cell-sort">
                                <span>What was edit</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="datatable-body" style="height: 100% !important;  overflow: auto;">
                        <tr></tr>
                        @foreach ($reportsData as $key => $item)
                            <tr data-row="0" class="datatable-row" style="left: 0px;">
                                <td class="datatable-cell-sorted datatable-cell-left datatable-cell" style="width: 5%;" data-field="RecordID" aria-label="1">
                                    <span>
                                        <span class="font-weight-bolder">{{ $key + 1 }}</span>
                                    </span>
                                </td>
                                <td data-field="Country" aria-label="Brazil" style="width: 25%;" class="datatable-cell">
                                    <span>
                                        <div class="font-weight-bolder font-size-lg mb-0">{{ $item->name }}</div>
                                    </span>
                                </td>
                                <td data-field="ShipDate" aria-label="10/15/2017" style="width: 20%;" class="datatable-cell">
                                    <span>
                                        <div class="font-weight-bolder text-primary mb-0">{{ $item->caption }}</div>
                                    </span>
                                </td>
                                <td data-field="Actions" data-autohide-disabled="false" style="width: 5%;" aria-label="null" class="datatable-cell">
                                    <form action="editaction" method="POST" class="dn">
                                        @csrf
                                        <input type="text" name="community_id" value="{{ $item->community_id }}">
                                        <input type="text" name="period_id" value="{{ $item->period_id }}">
                                        <input type="submit" class="cpeBtn">
                                    </form>
                                    @if (date('w') == 4)
                                        <span style="overflow: visible; position: relative;display:inline-block;" class="addBtn" data-toggle="tooltip" data-theme="dark" title="Add">
                                            <a href="javascript:;" class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon mr-2 changePasswordModal" title="Edit details">
                                                <span class="svg-icon svg-icon-md">
                                                    <span class="svg-icon svg-icon-primary svg-icon-2x">
                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <polygon points="0 0 24 0 24 24 0 24"/>
                                                                <path d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                                                <path d="M11,14 L9,14 C8.44771525,14 8,13.5522847 8,13 C8,12.4477153 8.44771525,12 9,12 L11,12 L11,10 C11,9.44771525 11.4477153,9 12,9 C12.5522847,9 13,9.44771525 13,10 L13,12 L15,12 C15.5522847,12 16,12.4477153 16,13 C16,13.5522847 15.5522847,14 15,14 L13,14 L13,16 C13,16.5522847 12.5522847,17 12,17 C11.4477153,17 11,16.5522847 11,16 L11,14 Z" fill="#000000"/>
                                                            </g>
                                                        </svg>
                                                    </span>
                                                </span>
                                            </a>
                                        </span>
                                    @else
                                        <span style="overflow: visible; position: relative;display:inline-block;" data-toggle="tooltip" data-theme="dark" title="Edit">
                                            <a href="javascript:;" class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon mr-2 changeReportBtn" title="Edit details">
                                                <span class="svg-icon svg-icon-md">
                                                    <svg
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24" height="24"></rect>
                                                            <path d="M12.2674799,18.2323597 L12.0084872,5.45852451 C12.0004303,5.06114792 12.1504154,4.6768183 12.4255037,4.38993949 L15.0030167,1.70195304 L17.5910752,4.40093695 C17.8599071,4.6812911 18.0095067,5.05499603 18.0083938,5.44341307 L17.9718262,18.2062508 C17.9694575,19.0329966 17.2985816,19.701953 16.4718324,19.701953 L13.7671717,19.701953 C12.9505952,19.701953 12.2840328,19.0487684 12.2674799,18.2323597 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.701953, 10.701953) rotate(-135.000000) translate(-14.701953, -10.701953) "></path>
                                                            <path d="M12.9,2 C13.4522847,2 13.9,2.44771525 13.9,3 C13.9,3.55228475 13.4522847,4 12.9,4 L6,4 C4.8954305,4 4,4.8954305 4,6 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,6 C2,3.790861 3.790861,2 6,2 L12.9,2 Z" fill="#000000" fill-rule="nonzero" opacity="0.3"></path>
                                                        </g>
                                                    </svg>
                                                </span>
                                            </a>
                                        </span>
                                    @endif
                                </td>
                                <td data-field="CompanyName" style="width: 15%;" aria-label="Casper-Kerluke" class="datatable-cell">
                                    <span>
                                        <div class="font-weight-bold ">
                                            {{ $item->edit_time }}
                                        </div>
                                    </span>
                                </td>
                                <td data-field="CompanyName" style="width: 15%;" aria-label="Casper-Kerluke" class="datatable-cell">
                                    <span>
                                        <div class="font-weight-bold ">
                                            @php $editchild = explode(',',$item->whatedit); @endphp
                                            @foreach ($editchild as $key => $im)
                                                @if($key == 0)
                                                    {{ $EditedData[(int)$im] }}
                                                @else
                                                    , {{ $EditedData[(int)$im] }}
                                                @endif
                                            @endforeach
                                        </div>
                                    </span>
                                </td>
                                <td style="display: none;">
                                    {{-- <span id="infoCenter" style="display: none;" type0="{{ $item->username }}" type1="{{ $item->community_id }}" type2="{{ $item->name }}" type3="{{ $item->email }}" type4="{{ $item->position }}" type5="{{ $item->leveledit }}" type6="{{ $item->levelreport }}" type7="{{ $item->levelcompany }}" type8="{{ $item->leveluser }}" type9="{{ $item->leveladd }}"></span> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<form method="POST" action="/profile" class="dn">
    @csrf
    <input name="type1" id="sortType">
    <input name="sortTypeagain1" id="sortTypeagain" value="null">
    <input type="submit" class="clickMeforReload" />
</form>

@endsection
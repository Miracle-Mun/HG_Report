@extends('layouts.app')

@section('content')
<div class="card card-custom" style="margin-top: 30px;">
    <!--begin::Header-->
    @if (Session::get('doesntmatch') != null)
        <h4>{{ Session::get('doesntmatch') }}</h4>
    @endif
    <div class="card-header flex-wrap border-0 pt-6 pb-0">
        <div class="card-title" style="width: 35%;">
            <div class="col-md-6 manageheader">
                <h3 class="card-label">
                    <a href="usermanage" class="bb">User Management</a>
                </h3>
            </div>
            <div class="col-md-6 manageheader">
                <h3 class="card-label">
                    <a href="reportmanage">Report Management</a>
                </h3>
            </div>
        </div>
        @if ($userData[0]->leveladd != 0 || $userData[0]->community_id == 10)
            <div class="card-toolbar">
                <!--begin::Button-->
                <a href="#" class="btn-rounded font-weight-bolder newUser">
                    <span class="svg-icon svg-icon-md">
                        <!--begin::Svg Icon | path:/metronic/themes/metronic/theme/html/demo2/distassets/media/svg/icons/Design/Flatten.svg-->
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24"></rect>
                                <circle fill="#000000" cx="9" cy="15" r="6"></circle>
                                <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3"></path>
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>	New User
                </a>
                <!--end::Button-->
            </div>
        @endif
    </div>
    <!--end::Header-->
    <!--begin::Body-->
    <div class="card-body">
        <!--begin: Datatable-->
        <div class="datatable datatable-bordered datatable-head-custom datatable-default datatable-primary datatable-loaded" id="kt_datatable" style="">
            <table class="datatable-table  table-sm table-hover" id="kt_datatable2" style="display: block;">
                <thead class="datatable-head">
                    <tr class="datatable-row spanloadtr" style="left: 0px;">
                        <th data-field="RecordID" style="width: 5%;" class="datatable-cell-left datatable-cell datatable-cell-sort datatable-cell-sorted" data-sort="asc">
                            <span>#</span>
                        </th>
                        <th data-field="Name" style="width: 30%;" class="datatable-cell datatable-cell-sort thforsort" type="name">
                            <span>Name</span>
                        </th>
                        <th data-field="state" style="width: 5%;" class="datatable-cell datatable-cell-sort thforsort" type="state">
                            <span>state</span>
                        </th>
                        <th data-field="Community" style="width: 10%;" class="datatable-cell datatable-cell-sort thforsort" type="Community">
                            <span>Community</span>
                        </th>
                        <th data-field="Position" style="width: 10%;" class="datatable-cell datatable-cell-sort thforsort" type="Position">
                            <span>Position</span>
                        </th>
                        <th data-field="password" style="width: 10%;" class="datatable-cell datatable-cell-sort thforsort" type="Password">
                            <span>Password</span>
                        </th>
                        <th data-field="Status" style="width: 10%;" class="datatable-cell datatable-cell-sort thforsort" type="Status">
                            <span>Status</span>
                        </th>
                        <th data-field="Status" style="width: 10%;" class="datatable-cell datatable-cell-sort thforsort" type="CreatedDate">
                            <span>Created Date</span>
                        </th>
                        <th data-field="Status" style="width: 10%;" class="datatable-cell datatable-cell-sort thforsort" type="LastLogin">
                            <span>Last Login</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="datatable-body" style="">
                    <tr></tr>
                    @foreach ($result as $item)
                        <tr data-row="0" class="datatable-row spanloadtr" style="left: 0px;" nameValue = "{{ $item->name }}" id-value = "{{ $item->user_id }}">
                            <td class="datatable-cell-sorted datatable-cell-left datatable-cell" style="width: 5%;" data-field="RecordID" aria-label="1">
                                <span>
                                    <span class="font-weight-bolder">{{ $iNum++ }}</span>
                                </span>
                            </td>
                            <td data-field="OrderID" aria-label="64616-103" style="width: 30%; word-break: break-word;" class="datatable-cell OrderName">
                                <span>
                                    <div class="d-flex align-items-center">
                                        <div class="symbol symbol-40 symbol-light-{{ $arr[rand(0,3)] }} flex-shrink-0">
                                            <span class="symbol-label font-size-h4 font-weight-bold">{{ $item->name[0] }}</span>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-dark-75 font-weight-bolder font-size-lg mb-0">{{ $item->name }}</div>
                                            <a href="#" class="text-muted font-weight-bold text-hover-primary">{{ $item->email }}</a>
                                        </div>
                                    </div>
                                </span>
                            </td>
                            <td data-field="Country" aria-label="Brazil" style="width: 5%;" class="datatable-cell">
                                <span>
                                    <div class="font-weight-bolder font-size-lg mb-0">{{ $item->state }}</div>
                                </span>
                            </td>
                            <td data-field="Country" aria-label="Brazil" style="width: 10%;" class="datatable-cell">
                                <span>
                                    <div class="font-weight-bolder font-size-lg mb-0">
                                        @if ($item->community_id == 10)
                                            All
                                        @else
                                            {{ $item->community }}
                                        @endif
                                    </div>
                                </span>
                            </td>
                            <td data-field="ShipDate" style="width: 10%;" aria-label="10/15/2017" class="datatable-cell">
                                <span>
                                    <div class="font-weight-bolder text-primary mb-0">{{ $item->position }}</div>
                                </span>
                            </td>
                            <td data-field="Actions" style="width: 10%;" data-autohide-disabled="false" aria-label="null" class="datatable-cell">
                                <span style="overflow: visible; position: relative;">
                                    <a href="javascript:;" class="btn btn-sm btn-default btn-text-primary btn-hover-primary btn-icon mr-2 changePasswordModal" title="Edit details">
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
                            </td>
                            <td data-field="CompanyName" style="width: 10%;" aria-label="Casper-Kerluke" class="datatable-cell">
                                <span>
                                    <div class="font-weight-bold inactiveBtn">
                                        @if ( $item->inactive == 0 )
                                            Inactive
                                        @else
                                            Active
                                        @endif
                                    </div>
                                </span>
                            </td>
                            <td data-field="CompanyName" style="width: 10%;" aria-label="Casper-Kerluke" class="datatable-cell">
                                <span>
                                    <div class="font-weight-bold ">
                                        {{ $item->created_date }}
                                    </div>
                                </span>
                            </td>
                            <td data-field="CompanyName" style="width: 10%;" aria-label="Casper-Kerluke" class="datatable-cell">
                                <span>
                                    <div class="font-weight-bold ">
                                        {{ $item->last_login }}
                                    </div>
                                </span>
                            </td>
                            <td class="dn">
                                <span id="infoCenter" type0="{{ $item->username }}" type1="{{ $item->community_id }}" type2="{{ $item->name }}" type3="{{ $item->email }}" type4="{{ $item->position }}" type5="{{ $item->leveledit }}" type6="{{ $item->levelreport }}" type7="{{ $item->levelcompany }}" type8="{{ $item->leveluser }}" type9="{{ $item->leveladd }}"></span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!--end: Datatable-->
    </div>
    <!--end::Body-->
</div>

<!-- Button trigger modal-->
<button type="button" class="btn btn-primary dn" data-toggle="modal" id="changePasswordModal" data-target="#changePasswordModalCenter">
    change password
</button>
<button type="button" class="btn btn-primary dn" data-toggle="modal" id="AddUserModal" data-target="#AddUserModalCenter">
    new User
</button>
<button type="button" class="btn btn-primary dn" data-toggle="modal" id="UpdateUserModal" data-target="#UpdateUserModalCenter">
    update User
</button>

<!-- Modal-->

<div class="modal fade" id="changePasswordModalCenter" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form class="form" action="{{ URL::to('updatePassword') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h4 id="modalName"></h4>
                        <input class="dn" id="mainId" name="mainId" value="" />
                        <div class="form-group mb-5">
                            <input class="form-control h-auto form-control-solid py-4 px-8" type="password" id="changePass" placeholder="Password" name="changePass" required />
                        </div>
                        <div class="form-group mb-5">
                            <input class="form-control h-auto form-control-solid py-4 px-8" type="password" id="ConfirmPass" placeholder="Confirm Password" name="cpassword" required />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input value='Click me' id="sendUpdate" class="dn" type="submit" />
                        <button type="submit" id="PasswordUpdate" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Change</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="AddUserModalCenter" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add New User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form" action="{{ URL::to('signup') }}" method="POST">
                        @csrf
                        <input name="checkthisonlyadd" class="dn" value="true" />
                        <input class="dn" id="mainIdAdd" name="mainId" value="" />
                        <div class="form-group mb-5">
                            <input class="form-control h-auto form-control-solid py-4 px-8" type="text" placeholder="Username" name="username" required />
                        </div>
                        <div class="form-group mb-5">
                            <input class="form-control h-auto form-control-solid py-4 px-8" type="password" placeholder="Password" name="password" required />
                        </div>
                        <div class="form-group mb-5">
                            <input class="form-control h-auto form-control-solid py-4 px-8" type="password" placeholder="Confirm Password" name="cpassword" required />
                        </div>
                        <div class="form-group mb-5 communities">
                            <div class="btn-group">
                                {{-- <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Administration</button> --}}
                                <input class="dn" value="1" name="community_id">
                                <?php $options = DB::table('communities')->get(['name', 'id']); ?>
                                @if ($userData[0]->leveluser > 1)
                                    <div class="dropdown bootstrap-select form-control">
                                        @foreach ($options as $key => $item)
                                            @if ($key == 0)
                                                <input name="community_id" value={{ $item->id }} class="dn com">
                                            @endif
                                        @endforeach
                                        <select class="form-control selectpicker" data-live-search="true" tabindex="null">
                                            @foreach ($options as $item)
                                                <option data-tokens="mustard" cId="{{ $item->id }}">
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @else
                                    <div class="dropdown bootstrap-select form-control">
                                        @foreach ($options as $item)
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
                            </div>
                        </div>
                        <div class="form-group mb-5">
                            <input class="form-control h-auto form-control-solid py-4 px-8" type="text" placeholder="Name" name="name" required />
                        </div>
                        <div class="form-group mb-5">
                            <input class="form-control h-auto form-control-solid py-4 px-8" type="text" placeholder="Email" name="email" required />
                        </div>
                        <div class="form-group mb-5">
                            <input class="form-control h-auto form-control-solid py-4 px-8" type="text" placeholder="Position" name="position" required />
                        </div>
                        <div class="form-group mb-5 edits">
                            <div class="btn-group leveladdDropdown">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">No Adds</button>
                                <input class="dn" value="0" name="leveladd">
                                <div class="dropdown-menu">
                                    @if ($userData[0]->leveladd >= 0)
                                        <a class="dropdown-item" type="0" href="#">No Adds</a>
                                    @endif
                                    @if ($userData[0]->leveladd >= 1)
                                        <a class="dropdown-item" type="1" href="#">Add Non-Locked</a>
                                    @endif
                                    @if ($userData[0]->leveladd >= 2)
                                        <a class="dropdown-item" type="2" href="#">Add Local Locked</a>
                                    @endif
                                    @if ($userData[0]->leveladd >= 3)
                                        <a class="dropdown-item" type="3" href="#">Add Any</a>
                                    @endif
                                    @if ($userData[0]->leveladd >= 4)
                                        <a class="dropdown-item" type="4" href="#">Add Any (root)</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-5 edits">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">No Edits</button>
                                <input class="dn" value="0" name="leveledit">
                                <div class="dropdown-menu">
                                    @if ($userData[0]->leveledit >= 0)
                                        <a class="dropdown-item" type="0" href="#">No Edits</a>
                                    @endif
                                    @if ($userData[0]->leveledit >= 1)
                                        <a class="dropdown-item" type="1" href="#">Edit Non-Locked</a>
                                    @endif
                                    @if ($userData[0]->leveledit >= 2)
                                        <a class="dropdown-item" type="2" href="#">Edit Local Locked</a>
                                    @endif
                                    @if ($userData[0]->leveledit >= 3)
                                        <a class="dropdown-item" type="3" href="#">Edit Any</a>
                                    @endif
                                    @if ($userData[0]->leveledit >= 4)
                                        <a class="dropdown-item" type="4" href="#">Edit Any (root)</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-5 reports">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">No Reports</button>
                                <input class="dn" value="0" name="levelreport">
                                <div class="dropdown-menu">
                                    @if ($userData[0]->leveledit >= 0)
                                        <a class="dropdown-item" type="0" href="#">No Reports</a>
                                    @endif
                                    @if ($userData[0]->leveledit >= 1)
                                        <a class="dropdown-item" type="1" href="#">Local Report</a>
                                    @endif
                                    @if ($userData[0]->leveledit >= 2)
                                        <a class="dropdown-item" type="2" href="#">Any Location</a>
                                    @endif
                                    @if ($userData[0]->leveledit >= 3)
                                        <a class="dropdown-item" type="3" href="#">Any Location (root)</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-5 companyReports">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">No Company Reports</button>
                                <input class="dn" value="0" name="levelcompany">
                                <div class="dropdown-menu">
                                    @if ($userData[0]->levelcompany >= 0)
                                        <a class="dropdown-item" type="0" href="#">No Company Reports</a>
                                    @endif
                                    @if ($userData[0]->levelcompany >= 1)
                                        <a class="dropdown-item" type="1" href="#">Local Report</a>
                                    @endif
                                    @if ($userData[0]->levelcompany >= 2)
                                        <a class="dropdown-item" type="2" href="#">Company Wide</a>
                                    @endif
                                    @if ($userData[0]->levelcompany >= 3)
                                        <a class="dropdown-item" type="3" href="#">All Reports (root)</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group mb-5 role">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">No User Administration</button>
                                <input class="dn" value="0" name="leveluser">
                                <div class="dropdown-menu">
                                    @if ($userData[0]->leveluser >= 0)
                                        <a class="dropdown-item" type="0" href="#">No User Administration</a>
                                    @endif
                                    @if ($userData[0]->leveluser >= 1)
                                        <a class="dropdown-item" type="1" href="#">Local User Only</a>
                                    @endif
                                    @if ($userData[0]->leveluser >= 2)
                                        <a class="dropdown-item" type="2" href="#">All Locations</a>
                                    @endif
                                    @if ($userData[0]->leveluser >= 3)
                                        <a class="dropdown-item" type="3" href="#">All Locations (root)</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group d-flex flex-wrap flex-center mt-10">
                            <button type="button" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-2 kt_login_signup_submit_Btn">Report Manager</button>
                            <button id="login_signup_submit" type="submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-2">Add User</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<form method="POST" action="changeStatus" class="dn">
    @csrf
    <input id="activeId" value="" name="id">
    <input id="statuId" value="" name="statu">
    <input type="submit" value="changeactive" id="changeactive">
</form>

<div class="modal fade" id="UpdateUserModalCenter" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form" action="{{ URL::to('update') }}" method="POST">
                        @csrf
                        <input class="dn" id="mainIdUpdate" name="mainId" value="" />
                        
                        <div class="form-group mb-5 communities mCommunity_id_value">
                            <div class="btn-group">
                                {{-- <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Administration</button> --}}
                                <input value="1" name="community_id" class="com dn">
                                <?php $options = DB::table('communities')->get(['name', 'id']); ?>
                                <script>communitiess = '<?php echo $options; ?>';</script>
                                @if ($userData[0]->leveluser > 1)
                                    <div class="dropdown bootstrap-select form-control">
                                        @foreach ($options as $key => $item)
                                            @if ($key == 0)
                                                <input name="community_id" value={{ $item->id }} class="dn com">
                                            @endif
                                        @endforeach
                                        <select class="form-control selectpicker" data-live-search="true" tabindex="null">
                                            @foreach ($options as $item)
                                                <option data-tokens="mustard" cId="{{ $item->id }}">
                                                    {{ $item->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                @else
                                    <div class="dropdown bootstrap-select form-control">
                                        @foreach ($options as $item)
                                            @if ($item->id == $userData[0]->community_id)
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
                            </div>
                        </div>

                        <div class="form-group mb-5">
                            <input class="form-control h-auto form-control-solid py-4 px-8 mName" type="text" placeholder="Name" name="name" required />
                        </div>

                        <div class="form-group mb-5">
                            <input class="form-control h-auto form-control-solid py-4 px-8 mEmail" type="text" placeholder="Email" name="email" required />
                        </div>

                        <div class="form-group mb-5">
                            <input class="form-control h-auto form-control-solid py-4 px-8 mPosition" type="text" placeholder="Position" name="position" required />
                        </div>
                        
                        <div class="form-group mb-5 adds">
                            <div class="btn-group mLeveladd_value">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">No Adds</button>
                                <input class="mLeveladd dn" value="0" name="leveladd">
                                <div class="dropdown-menu">
                                    @if ($userData[0]->leveladd >= 0)
                                        <a class="dropdown-item" type="0" href="#">No Adds</a>
                                    @endif
                                    @if ($userData[0]->leveladd >= 1)
                                        <a class="dropdown-item" type="1" href="#">Add Non-Locked</a>
                                    @endif
                                    @if ($userData[0]->leveladd >= 2)
                                        <a class="dropdown-item" type="2" href="#">Add Local Locked</a>
                                    @endif
                                    @if ($userData[0]->leveladd >= 3)
                                        <a class="dropdown-item" type="3" href="#">Add Any</a>
                                    @endif
                                    @if ($userData[0]->leveladd >= 4)
                                        <a class="dropdown-item" type="4" href="#">Add Any (root)</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group mb-5 edits">
                            <div class="btn-group mLeveledit_value">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">No Edits</button>
                                <input class="mLeveledit dn" value="0" name="leveledit">
                                <div class="dropdown-menu">
                                    @if ($userData[0]->leveledit >= 0)
                                        <a class="dropdown-item" type="0" href="#">No Edits</a>
                                    @endif
                                    @if ($userData[0]->leveledit >= 1)
                                        <a class="dropdown-item" type="1" href="#">Edit Non-Locked</a>
                                    @endif
                                    @if ($userData[0]->leveledit >= 2)
                                        <a class="dropdown-item" type="2" href="#">Edit Local Locked</a>
                                    @endif
                                    @if ($userData[0]->leveledit >= 3)
                                        <a class="dropdown-item" type="3" href="#">Edit Any</a>
                                    @endif
                                    @if ($userData[0]->leveledit >= 4)
                                        <a class="dropdown-item" type="4" href="#">Edit Any (root)</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group mb-5 reports">
                            <div class="btn-group mLevelreport_value">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">No Reports</button>
                                <input value="0" class="mLevelreport dn" name="levelreport">
                                <div class="dropdown-menu">
                                    @if ($userData[0]->leveledit >= 0)
                                        <a class="dropdown-item" type="0" href="#">No Reports</a>
                                    @endif
                                    @if ($userData[0]->leveledit >= 1)
                                        <a class="dropdown-item" type="1" href="#">Local Report</a>
                                    @endif
                                    @if ($userData[0]->leveledit >= 2)
                                        <a class="dropdown-item" type="2" href="#">Any Location</a>
                                    @endif
                                    @if ($userData[0]->leveledit >= 3)
                                        <a class="dropdown-item" type="3" href="#">Any Location (root)</a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-5 companyReports mLevelcompany_value">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">No Company Reports</button>
                                <input value="0" class="mLevelcompany dn" name="levelcompany">
                                <div class="dropdown-menu">
                                    @if ($userData[0]->levelcompany >= 0)
                                        <a class="dropdown-item" type="0" href="#">No Company Reports</a>
                                    @endif
                                    @if ($userData[0]->levelcompany >= 1)
                                        <a class="dropdown-item" type="1" href="#">Local Report</a>
                                    @endif
                                    @if ($userData[0]->levelcompany >= 2)
                                        <a class="dropdown-item" type="2" href="#">Company Wide</a>
                                    @endif
                                    @if ($userData[0]->levelcompany >= 3)
                                        <a class="dropdown-item" type="3" href="#">All Reports (root)</a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-5 role">
                            <div class="btn-group mLeveluser_value">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">No User Administration</button>
                                <input value="0" class="mLeveluser dn" name="leveluser">
                                <div class="dropdown-menu">
                                    @if ($userData[0]->leveluser >= 0)
                                        <a class="dropdown-item" type="0" href="#">No User Administration</a>
                                    @endif
                                    @if ($userData[0]->leveluser >= 1)
                                        <a class="dropdown-item" type="1" href="#">Local User Only</a>
                                    @endif
                                    @if ($userData[0]->leveluser >= 2)
                                        <a class="dropdown-item" type="2" href="#">All Locations</a>
                                    @endif
                                    @if ($userData[0]->leveluser >= 3)
                                        <a class="dropdown-item" type="3" href="#">All Locations (root)</a>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group d-flex flex-wrap flex-center mt-10">
                            <button type="button" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-2 kt_login_signup_submit_Btn">Report Manager</button>
                            <button id="kt_login_signup_submit" type="submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-2">Update User</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<form method="POST" action="/usermanage" class="dn">
    @csrf
    <input name="type" id="sortType">
    <input name="sortTypeagain" id="sortTypeagain" value="null">
    <input type="submit" class="clickMeforReload" />
</form>

<form action="/usermanage">
    <input type="submit" class="dn reportmanageqq">
</form>

@endsection

@extends('layouts.container')

@section('contents')
<script>var buildingsData = <?php echo $BD; ?>; var communities = JSON.parse('<?php echo $viewitems; ?>');</script>
<form method="POST" action="editaction" class="w-100 editActionq">
	@csrf
	<h3 class="px-2 w-100">
		Report Summary for
		@foreach ($viewitems as $key => $item)
			@if ($key == 0)
				<input name="community_id" value={{ $item->id }} class="dn com">
			@endif
		@endforeach
		<select class="form-control selectpicker w-20 viewreportcommon1" data-live-search="true" tabindex="null">
			@foreach ($viewitems as $item)
				@if($info[0] == $item->id)
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
<form method="POST" action="savedata" style="width: 100%;">
	@csrf
	<input type="text" class="dn whateditC" name="whatedit" value="{{ $userData[0]->whatedit }}">
	@if (count($CCD) > 0)
		<div class="card card-custom cb" style="width: 100%;">
			<div class="card-header">
				<h3 class="card-title">Census and Capacity</h3>
			</div>
			<div class="card-body">
				<table class="table table-borderless viewtable table-sm table-hover">
					<tbody>
						<tr>
							<th>Building</th>
							<th>Census</th>
							<th>Capacity</th>
						</tr>
						@foreach ($CCD as $key => $item)
							<tr>
								<td class="w-30">
									@if($userData[0]->leveledit > 2 || $userData[0]->leveluser == 3)
										<div class="dropdown bootstrap-select form-control EditactionCencaps">
											<select class="form-control selectpicker" data-live-search="true" tabindex="null">
												@foreach ($BD as $bitem)
													@if($item->building_id == $bitem->id)
														<option data-tokens="mustard" selected="selected" cId="{{ $bitem->id }}">
															{{ $bitem->name }}
														</option>
													@else
														<option data-tokens="mustard" cId="{{ $bitem->id }}">
															{{ $bitem->name }}
														</option>
													@endif
												@endforeach
											</select>
										</div>
									@else
										<div class="dropdown bootstrap-select form-control EditactionCencaps">
											@foreach ($BD as $bitem)
												@if($item->building_id == $bitem->id)
													<button type="button" tabindex="-1" class="btn dropdown-toggle btn-light" data-toggle="dropdown" role="combobox" aria-owns="bs-select-2" aria-haspopup="listbox" aria-expanded="true" title="Cottage">
														<div class="filter-option">
															<div class="filter-option-inner">
																<div class="filter-option-inner-inner">{{ $bitem->name }}</div>
															</div>
														</div>
													</button>
												@endif
											@endforeach
										</div>
									@endif
									
									@if($userData[0]->leveledit > 2 || $userData[0]->leveluser == 3)
										<input onkeypress="whateditFunc(this)" eType="0" value="{{ $item->building_id }}" name="_buildingid,{{ $key }},old" class="dn bId">
									@else
										<input onkeypress="whateditFunc(this)" eType="0" value="{{ $item->building_id }}" readonly="true" name="_buildingid,{{ $key }},old" class="dn bId">
									@endif
								</td>
								<td class="w-30">
									@if($userData[0]->leveledit > 2 || $userData[0]->leveluser == 3) 
										<input onkeypress="whateditFunc(this)" eType="0" value="{{ $item->census }}" name="_census,{{ $key }},old" class="form-control form-control-solid">
									@else
										<input onkeypress="whateditFunc(this)" eType="0" value="{{ $item->census }}" name="_census,{{ $key }},old" readonly="true" class="form-control form-control-solid">
									@endif
								</td>
								<td class="w-30">
									@if($userData[0]->leveledit > 2 || $userData[0]->leveluser == 3) 
										<input onkeypress="whateditFunc(this)" eType="0" value="{{ $item->capacity }}" name="_capacity,{{ $key }},old" class="form-control form-control-solid">
									@else
										<input onkeypress="whateditFunc(this)" eType="0" value="{{ $item->capacity }}" name="_capacity,{{ $key }},old" readonly="true" class="form-control form-control-solid">
									@endif
								</td>
								@if($userData[0]->leveledit > 2 || $userData[0]->leveluser == 3)
									<td class="w-10">
										<a class="btn btn-sm btn-clean btn-icon debtn_1" href="javascript:;" title="Delete">
											<span class="svg-icon svg-icon-md">
												<svg height="24px" version="1.1" viewbox="0 0 24 24" width="24px" xmlns="http://www.w3.org/2000/svg">
													<g fill="none" fill-rule="evenodd" stroke="none" stroke-width="1">
														<rect height="24" width="24" x="0" y="0"></rect>
														<path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"></path>
														<path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"></path>
													</g>
												</svg>
											</span>
										</a>
									</td>
								@endif
							</tr>
						@endforeach
					</tbody>
				</table>
				@if($userData[0]->leveledit > 2 || $userData[0]->leveluser == 3)
					<div class="row jcc hs">
						<span class="svg-icon svg-icon-primary svg-icon-2x addbtn_1">
							<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
								<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
									<rect x="0" y="0" width="24" height="24"/>
									<path d="M3.5,21 L20.5,21 C21.3284271,21 22,20.3284271 22,19.5 L22,8.5 C22,7.67157288 21.3284271,7 20.5,7 L10,7 L7.43933983,4.43933983 C7.15803526,4.15803526 6.77650439,4 6.37867966,4 L3.5,4 C2.67157288,4 2,4.67157288 2,5.5 L2,19.5 C2,20.3284271 2.67157288,21 3.5,21 Z" fill="#000000" opacity="0.3"/>
									<path d="M11,13 L11,11 C11,10.4477153 11.4477153,10 12,10 C12.5522847,10 13,10.4477153 13,11 L13,13 L15,13 C15.5522847,13 16,13.4477153 16,14 C16,14.5522847 15.5522847,15 15,15 L13,15 L13,17 C13,17.5522847 12.5522847,18 12,18 C11.4477153,18 11,17.5522847 11,17 L11,15 L9,15 C8.44771525,15 8,14.5522847 8,14 C8,13.4477153 8.44771525,13 9,13 L11,13 Z" fill="#000000"/>
								</g>
							</svg>
						</span>
					</div>
				@endif
			</div>
		</div>
	@endif

	@if (count($ID) > 0)
		<div class="card card-custom cb" style="width: 100%;">
			<div class="card-header">
				<h3 class="card-title">Inquiries</h3>
			</div>
			<div class="card-body">
				<table class="table table-borderless viewtable table-sm table-hover">
					<tbody>
						<tr>
							<th>Type</th>
							<th>Count</th>
						</tr>
						@foreach ($ID as $key => $item)
							<tr>
								<td class="w-45">
									<input onkeypress="whateditFunc(this)" eType="1" name="idesctiption_Inquiries_description,{{ $key }},{{ $item->id }}" value="{{ $item->description }}" class="form-control form-control-solid">
								</td>
								<td class="w-45">
									<input onkeypress="whateditFunc(this)" eType="1" name="icount_Inquiries_count,{{ $key }},{{ $item->id }}" value="{{ $item->number }}" class="form-control form-control-solid">
								</td>
								<td class="w-10">
									<a class="btn btn-sm btn-clean btn-icon delBtn" type="inquries" href="javascript:;" title="Delete">
										<span class="svg-icon svg-icon-md">
											<svg height="24px" version="1.1" viewbox="0 0 24 24" width="24px" xmlns="http://www.w3.org/2000/svg">
												<g fill="none" fill-rule="evenodd" stroke="none" stroke-width="1">
													<rect height="24" width="24" x="0" y="0"></rect>
													<path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"></path>
													<path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"></path>
												</g>
											</svg>
										</span>
									</a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
				<div class="row jcc hs">
					<span class="svg-icon svg-icon-primary svg-icon-2x addbtn_2">
						<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
							<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
								<rect x="0" y="0" width="24" height="24"/>
								<path d="M3.5,21 L20.5,21 C21.3284271,21 22,20.3284271 22,19.5 L22,8.5 C22,7.67157288 21.3284271,7 20.5,7 L10,7 L7.43933983,4.43933983 C7.15803526,4.15803526 6.77650439,4 6.37867966,4 L3.5,4 C2.67157288,4 2,4.67157288 2,5.5 L2,19.5 C2,20.3284271 2.67157288,21 3.5,21 Z" fill="#000000" opacity="0.3"/>
								<path d="M11,13 L11,11 C11,10.4477153 11.4477153,10 12,10 C12.5522847,10 13,10.4477153 13,11 L13,13 L15,13 C15.5522847,13 16,13.4477153 16,14 C16,14.5522847 15.5522847,15 15,15 L13,15 L13,17 C13,17.5522847 12.5522847,18 12,18 C11.4477153,18 11,17.5522847 11,17 L11,15 L9,15 C8.44771525,15 8,14.5522847 8,14 C8,13.4477153 8.44771525,13 9,13 L11,13 Z" fill="#000000"/>
							</g>
						</svg>
					</span>
				</div>
			</div>
		</div>
	@endif

	@if (count($MD) > 0)
		<div class="card card-custom cb" style="width: 100%;">
			<div class="card-header">
				<h3 class="card-title">Moveouts</h3>
			</div>
			<div class="card-body">
				<table class="table table-borderless viewtable table-sm table-hover">
					<tbody>
						<tr>
							<th>Reason</th>
							<th>Count</th>
						</tr>
						@foreach ($MD as $key => $item)
							<tr>
								<td class="w-45">
									<input onkeypress="whateditFunc(this)" eType="2" name="md_moveouts_description,{{ $key }},{{ $item->description }}" value="{{ $item->description }}" class="form-control form-control-solid">
								</td>
								<td class="w-45">
									<input onkeypress="whateditFunc(this)" eType="2" name="md_moveouts_number,{{ $key }},{{ $item->description }}" value="{{ $item->number }}" class="form-control form-control-solid">
								</td>
								<td class="w-10">
									<a class="btn btn-sm btn-clean btn-icon delBtn" type="moveouts" href="javascript:;" title="Delete">
										<span class="svg-icon svg-icon-md">
											<svg height="24px" version="1.1" viewbox="0 0 24 24" width="24px" xmlns="http://www.w3.org/2000/svg">
												<g fill="none" fill-rule="evenodd" stroke="none" stroke-width="1">
													<rect height="24" width="24" x="0" y="0"></rect>
													<path d="M6,8 L6,20.5 C6,21.3284271 6.67157288,22 7.5,22 L16.5,22 C17.3284271,22 18,21.3284271 18,20.5 L18,8 L6,8 Z" fill="#000000" fill-rule="nonzero"></path>
													<path d="M14,4.5 L14,4 C14,3.44771525 13.5522847,3 13,3 L11,3 C10.4477153,3 10,3.44771525 10,4 L10,4.5 L5.5,4.5 C5.22385763,4.5 5,4.72385763 5,5 L5,5.5 C5,5.77614237 5.22385763,6 5.5,6 L18.5,6 C18.7761424,6 19,5.77614237 19,5.5 L19,5 C19,4.72385763 18.7761424,4.5 18.5,4.5 L14,4.5 Z" fill="#000000" opacity="0.3"></path>
												</g>
											</svg>
										</span>
									</a>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
				<div class="row jcc hs">
					<span class="svg-icon svg-icon-primary svg-icon-2x addbtn_3"><!--begin::Svg Icon | path:/home/keenthemes/www/metronic/themes/metronic/theme/html/demo2/dist/../src/media/svg/icons/Files/Folder-plus.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
						<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
							<rect x="0" y="0" width="24" height="24"/>
							<path d="M3.5,21 L20.5,21 C21.3284271,21 22,20.3284271 22,19.5 L22,8.5 C22,7.67157288 21.3284271,7 20.5,7 L10,7 L7.43933983,4.43933983 C7.15803526,4.15803526 6.77650439,4 6.37867966,4 L3.5,4 C2.67157288,4 2,4.67157288 2,5.5 L2,19.5 C2,20.3284271 2.67157288,21 3.5,21 Z" fill="#000000" opacity="0.3"/>
							<path d="M11,13 L11,11 C11,10.4477153 11.4477153,10 12,10 C12.5522847,10 13,10.4477153 13,11 L13,13 L15,13 C15.5522847,13 16,13.4477153 16,14 C16,14.5522847 15.5522847,15 15,15 L13,15 L13,17 C13,17.5522847 12.5522847,18 12,18 C11.4477153,18 11,17.5522847 11,17 L11,15 L9,15 C8.44771525,15 8,14.5522847 8,14 C8,13.4477153 8.44771525,13 9,13 L11,13 Z" fill="#000000"/>
						</g>
					</svg><!--end::Svg Icon--></span>
				</div>
			</div>
		</div>		
	@endif

	<div class="card card-custom cb" style="width: 100%;">
		<div class="card-header">
			<h3 class="card-title">Statistics</h3>
		</div>
		<div class="card-body">
			<table class="table table-borderless viewtable table-sm table-hover">
				<tbody>
					<tr></tr>
					<tr>
						<th class="w-50">Unqualified</th>
						<th class="w-50"><input onkeypress="whateditFunc(this)" eType="3" value="{{ $reportsData['unqualified'] }}" name="unqualified" class="form-control form-control-solid"></th>
					</tr>
					<tr>
						<th class="w-50">Tours</th>
						<th class="w-50"><input onkeypress="whateditFunc(this)" eType="3" value="{{ $reportsData['tours'] }}" name="tours" class="form-control form-control-solid"></th>
					</tr>
					<tr>
						<th class="w-50">Deposits</th>
						<th class="w-50"><input onkeypress="whateditFunc(this)" eType="3" value="{{ $reportsData['deposits'] }}" name="deposits" class="form-control form-control-solid"></th>
					</tr>
				</tbody>
			</table>
		</div>
	</div>

	<div class="card card-custom cb" style="width: 100%;">
		<div class="card-header">
			<h3 class="card-title">Move In/Out</h3>
		</div>
		<div class="card-body">
			<table class="table table-borderless viewtable table-sm table-hover">
				<tbody>
					<tr></tr>
					<tr>
						<th class="w-50">WTD Move-Ins</th>
						<th class="w-50"><input onkeypress="whateditFunc(this)" eType="4" value="{{ $reportsData['wtd_movein'] }}" name="wtd_movein" class="form-control form-control-solid"></th>
					</tr>
					<tr>
						<th class="w-50">WTD Move-Outs</th>
						<th class="w-50"><input onkeypress="whateditFunc(this)" eType="4" value="{{ $reportsData['wtd_moveout'] }}" name="wtd_moveout" class="form-control form-control-solid"></th>
					</tr>
					<tr>
						<th class="w-50">YTD Move-Ins</th>
						<th class="w-50"><input onkeypress="whateditFunc(this)" eType="4" value="{{ $reportsData['ytd_movein'] }}" name="ytd_movein" class="form-control form-control-solid"></th>
					</tr>
					<tr>
						<th class="w-50">YTD Move-Outs</th>
						<th class="w-50"><input onkeypress="whateditFunc(this)" eType="4" value="{{ $reportsData['ytd_moveout'] }}" name="ytd_moveout" class="form-control form-control-solid"></th>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div class="row jcc">
		<div class="col-md-6 tar">
			<button class="btn-rounded" style="color: white !important;" type="submit">
				Save
			</button>
		</div>
		<div class="col-md-6">
			<button class="btn-rounded" type="button">
				<a href="main" style="color: white !important;">                       
					Cancel
				</a>
			</button>
		</div>
	</div>
	<input id="community_id" name="community_id" value="{{ $CI }}" class="dn">
	<input id="period_id" name="period_id" value="{{ $PI }}" class="dn">
	<input id="report_id" name="report_id" value="{{ $reportsData['id'] }}" class="dn">
	<input id="inquiries_num" name="inquiries_num" value="{{ count($ID) }}" class="dn">
	<input id="moveouts_num" name="moveouts_num" value="{{ count($MD) }}" class="dn">
	<input id="ccs_num" name="ccs_num" value="{{ count($CCD) }}" class="dn">
</form>
@endsection
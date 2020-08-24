@extends('admin.master')
@section('content')
@section('title')
@lang('award.award_list')
@endsection
	<div class="container-fluid">
		<div class="row bg-title">
			<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			   <ol class="breadcrumb">
					<li class="active breadcrumbColor"><a href="{{ url('dashboard') }}"><i class="fa fa-home"></i> @lang('dashboard.dashboard')</a></li>
					<li>@yield('title')</li>
				</ol>
			</div>	
			<?php $employeeInfo = employeeInfo(); 
			if($employeeInfo[0]->user_name == "admin")
			{
			?>
			<div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
				<a href="{{ route('award.create') }}"  class="btn btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"> <i class="fa fa-plus-circle" aria-hidden="true"></i> @lang('award.add_new_award')</a>
			</div>	
			<?php
			}
			?>
		</div>
					
		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-info">
					<div class="panel-heading"><i class="mdi mdi-table fa-fw"></i> @yield('title')</div>
					<div class="panel-wrapper collapse in" aria-expanded="true">
						<div class="panel-body">
							@if(session()->has('success'))
								<div class="alert alert-success alert-dismissable">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
									<i class="cr-icon glyphicon glyphicon-ok"></i>&nbsp;<strong>{{ session()->get('success') }}</strong>
								</div>
							@endif
							@if(session()->has('error'))
								<div class="alert alert-danger alert-dismissable">
									<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
									<i class="glyphicon glyphicon-remove"></i>&nbsp;<strong>{{ session()->get('error') }}</strong>
								</div>
							@endif
							<div class="table-responsive">
								<table id="myTable" class="table table-bordered">
									<thead>
										 <tr class="tr_header">
											<th>@lang('common.serial')</th>
											 <th>@lang('award.award_name')</th>
											<th>@lang('common.month')</th>
											<th>@lang('award.file_list')</th>
											<?php $employeeInfo = employeeInfo(); 
											if($employeeInfo[0]->user_name == "admin")
											{
											?>
											<th>@lang('common.action')</th>
											<?php 
											}
											?>
										</tr>
									</thead>
									<tbody>
										{!! $sl=null !!}
										@foreach($results AS $value)
											<tr class="{!! $value->employee_award_id !!}">
												<td style="width: 100px;">{!! ++$sl !!}</td>
												<td>{!! $value->award_name !!}</td>
												<td>{!! convartMonthAndYearToWord($value->month) !!}</td>
												<td><a href='{{ asset("public/upload/$value->file_upload") }}'>
													{{ $value->file_upload }}</a></td>

												<?php $employeeInfo = employeeInfo(); 
												if($employeeInfo[0]->user_name == "admin")
												{
												?>
												<td style="width: 100px;">
													<a href="{!! route('award.edit',$value->employee_award_id ) !!}"  class="btn btn-success btn-xs btnColor">
														<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
													</a>
													<a href="{!!route('award.delete',$value->employee_award_id  )!!}" data-token="{!! csrf_token() !!}" data-id="{!! $value->employee_award_id !!}" class="delete btn btn-danger btn-xs deleteBtn btnColor"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
												</td>
												<?php
												}
												?>
											</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@extends('admin.master')
@section('content')
@section('title')
@lang('attendance.employee_attendance')
@endsection
<style>
	.departmentName{
		position: relative;
	}
	#department_id-error{
		position: absolute;
		top: 66px;
		left: 0;
		width: 100%he;
		width: 100%;
		height: 100%;
	}

	#columnhere {
  display: flex;
  flex-direction: column;
  justify-content: center;
  margin: 0 auto;
  text-align: center;
}


@media (min-width: 300px) {
  #timein {
  	margin-top: 20px;
    height: 55px;
    background: #41b3f9;
    border: none;
    outline: none;
    width: 100%;
    width: 90%;
    margin-left: 15px;
    margin-right: 15px;
  }
}

@media (min-width: 768px) {
  #timein {
    height: 55px;
    background: #41b3f9;
    border: none;
    outline: none;
    width: 200px;
    margin-left: 0;
    margin-right: 0;
  }
}

@media (min-width: 300px) {
  #timeout {
    margin-top: 20px;
    height: 55px;
    background: #41b3f9;
    border: none;
    outline: none;
    width: 90%;
    margin-left: 15px;
    margin-right: 15px;
  }
}

@media (min-width: 768px) {
  #timeout {
    height: 55px;
    background: #41b3f9;
    border: none;
    outline: none;
    width: 200px;
    margin-left: 0;
    margin-right: 0;
  }
}

#timein:hover, #timeout:hover {
	background: none;
	transition: 0.5s;
	border: 2px solid #41b3f9;
	color:rgb(14, 14, 14);
}

@media(min-width: 300px)
{
	#preview {
	max-width: 100%;
	max-height: 130%;
	}

}

@media(min-width: 768px)
{
	#preview {
	max-width: 100%;
	max-height: 100%;
	}

}

#yourInputFieldId {
	font-size: 1.3em;
	border-radius: 0px;
	text-align: center;
	border: 1px solid #41b3f9;
	margin-top: 20px;
}



</style>
<script>
    jQuery(function (){
        $("#employeeAttendance").validate();
    });

</script>
	<div class="container-fluid">
		<div class="row bg-title">
			<div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
			   <ol class="breadcrumb">
					<li class="active breadcrumbColor"><a href="{{ url('dashboard') }}"><i class="fa fa-home"></i> @lang('dashboard.dashboard')</a></li>
					<li>@yield('title')</li>
				</ol>
			</div>	
		</div>

<!-- 		<div class="row">
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
								<div class="row">
									<div id="searchBox">
										{{ Form::open(array('route' => 'manualAttendance.filter','id'=>'employeeAttendance','method'=>'GET')) }}
										<div class="col-md-2"></div>
										<div class="col-md-3">
											<div class="form-group departmentName">
												<label class="control-label" for="email">@lang('employee.department')<span class="validateRq">*</span></label>
												<select class="form-control employee_id select2 required" required name="department_id">
													<option value="">---- @lang('common.please_select') ----</option>
													@foreach($departmentList as $value)
														<option value="{{$value->department_id}}" @if(isset($_REQUEST['department_id'])) @if($_REQUEST['department_id'] == $value->department_id) {{"selected"}} @endif @endif>{{$value->department_name}} </option>
													@endforeach
												</select>
											</div>
										</div>
										<div class="col-md-3">
											<label class="control-label" for="email">@lang('common.date')<span class="validateRq">*</span></label>
											<div class="input-group">
												<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
												<input type="text" class="form-control dateField required" readonly placeholder="@lang('common.date')"  name="date" value="@if(isset($_REQUEST['date'])) {{$_REQUEST['date']}}@else{{dateConvertDBtoForm(date('Y-m-d'))}}@endif">
											</div>
										</div>

										<div class="col-md-2">
											<div class="form-group">
												<input type="submit" id="filter" style="margin-top: 25px; width: 100px;" class="btn btn-info " value="@lang('common.filter')">
											</div>
										</div>
										{{ Form::close() }}
									</div>
								</div>
								<hr>
							@if(isset($attendanceData))
							{{ Form::open(array('route' => 'manualAttendance.store','id'=>'employeeAttendance')) }}

							<input  type="hidden"  name="department_id" value="{{$_REQUEST['department_id']}}">
							<input  type="hidden"  name="date" value="{{$_REQUEST['date']}}">

							<div class="table-responsive">
								<table  class="table table-bordered" style="margin-bottom: 47px">
									<thead class="tr_header">
										<tr>
											<th>@lang('common.serial')</th>
											<th>@lang('employee.finger_print_no')</th>
											<th>@lang('common.employee_name')</th>
											<th>@lang('attendance.in_time')</th>
											<th>O@lang('attendance.out_time')</th>
										</tr>
									</thead>
									<tbody>
										@if(count($attendanceData) > 0)
											@foreach($attendanceData as $value)
												<tr>
													<td>1</td>
													<td>{{$value->finger_id}}</td>
													<td>{{$value->fullName}}</td>
													<td style="width: 300px">
														<div class="input-group">
															<div class="input-group-addon">
																<i class="fa fa-clock-o"></i>
															</div>
															<div class="bootstrap-timepicker">
																<input  type="hidden"  name="finger_print_id[]" value="{{$value->finger_id}}">
																<input class="form-control timePicker" type="text" placeholder="@lang('attendance.in_time')" name="inTime[]" value="{{$value->inTime}}" readonly>
															</div>
														</div>
													</td>
													<td style="width: 300px">
														<div class="input-group">
															<div class="input-group-addon">
																<i class="fa fa-clock-o"></i>
															</div>
															<div class="bootstrap-timepicker">
																<input class="form-control timePicker" type="text" placeholder="@lang('attendance.out_time')" name="outTime[]" value="{{$value->outTime}}" readonly>
															</div>
														</div>
													</td>
												</tr>
											@endforeach
										@else
											<tr>
												<td colspan="5">@lang('attendance.no_data_available')</td>
											</tr>
										@endif
									</tbody>
								</table>
							</div>
							@if(count($attendanceData) > 0)
								<div class="form-actions">
									<div class="row">
										<div class="col-md-12 ">
											<button type="submit" class="btn btn-info btn_style"><i class="fa fa-check"></i> @lang('common.save')</button>
										</div>
									</div>
								</div>
							@endif
							{{ Form::close() }}
							@endif
						</div>
					</div>
				</div>
			</div>
		</div> -->
		<div class="row">
			<div class="col-sm-12">
				<div class="panel panel-info">
					<div class="panel-heading"><i class="mdi mdi-table fa-fw"></i> @yield('title')</div>
					<div class="panel-wrapper collapse in" aria-expanded="true">
						<div class="panel-body">

									
							<div class="col" id="columnhere">


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

							{{ Form::open(array('route' => 'manualAttendance.store','id'=>'employeeAttendance')) }}
								<?php date_default_timezone_set('Asia/Manila'); ?>
					         	
					         	<div><video id="preview"></video></div>
					         	<script type="text/javascript">
								      let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
								      scanner.addListener('scan', function (content) {
								        document.getElementById("yourInputFieldId").value = content; // Pass the scanned content value to an input field
								      });
								      Instascan.Camera.getCameras().then(function (cameras) {
								        if (cameras.length > 0) {
								          scanner.start(cameras[0]);
								        } else {
								          console.error('No cameras found.');
								        }
								      }).catch(function (e) {
								        console.error(e);
								      });
								    </script>

								<input id="yourInputFieldId" type="text" name="fingerid[]" placeholder="ID Number" readonly>
								<input type="hidden"  name="date" value="<?php echo date('Y-m-d'); ?>">
								<input class="form-control" type="hidden" placeholder="@lang('attendance.in_time')" name="inTime[]" value="<?php echo date('h:i:s'); ?>">
								<input class="form-control" type="hidden" placeholder="@lang('attendance.out_time')" name="outTime[]" value="<?php echo date('h:i:s'); ?>">
								<div><button class="btn btn-primary" id="timein" type="submit" name="timein" value="timein">TIME IN &nbsp;&nbsp;<i class="fa fa-sign-in"></i></button></div>
					            <div><button class="btn btn-primary" id="timeout" type="submit" name="timeout" value="timeout">&nbsp; TIME OUT &nbsp;&nbsp;<i class="fa fa-sign-out"></i></button></div>
							{{ Form::close() }}
					        </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

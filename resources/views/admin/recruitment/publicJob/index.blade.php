<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="{!! asset('admin_assets/img/logo.png') !!}" type="image/x-icon"/>
    <title>@yield('title')</title>
    <!-- Bootstrap Core CSS -->
    <!-- <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}"> -->
    <!-- Menu CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="{!! asset('admin_assets/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css') !!}"
          rel="stylesheet">
    <!-- toast CSS -->
    <link href="{!! asset('admin_assets/plugins/bower_components/toast-master/css/jquery.toast.css') !!}"
          rel="stylesheet">
    <!-- morris CSS -->
    <link href="{!! asset('admin_assets/plugins/bower_components/morrisjs/morris.css') !!}" rel="stylesheet">
    <!-- animation CSS -->
    <link href="{!! asset('admin_assets/css/animate.css') !!}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{!! asset('admin_assets/css/style.css') !!}" rel="stylesheet">
    <!-- color CSS -->
    <link href="{!! asset('admin_assets/css/colors/megna-dark.css') !!}" id="theme" rel="stylesheet">
    <!-- data table CSS -->
    <link href="{!! asset('admin_assets/plugins/bower_components/datatables/jquery.dataTables.min.css') !!}"
          rel="stylesheet" type="text/css"/>

    <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet"
          type="text/css"/>
    <!-- Date Picker -->
    <link rel="stylesheet" href="{!! asset('admin_assets/plugins/bower_components/datepicker/datepicker3.css') !!}">
    <!-- Daterange picker -->
    <link rel="stylesheet"
          href="{!! asset('admin_assets/plugins/bower_components/daterangepicker/daterangepicker-bs3.css') !!}">
    <!-- time picker-->
    <link rel="stylesheet"
          href="{!! asset('admin_assets/plugins/bower_components/timepicker/bootstrap-timepicker.min.css') !!}">
    <!-- sweetalert-->
    <link rel="stylesheet" href="{!! asset('admin_assets/plugins/bower_components/sweetalert/sweetalert.css') !!}">
    <!-- select 2 -->
    <link rel="stylesheet" href="{!! asset('admin_assets/plugins/bower_components/select2/select2.min.css') !!}">
    <!-- toast CSS -->
    <link href="{!! asset('admin_assets/plugins/bower_components/toast-master/css/jquery.toast.css') !!}"
          rel="stylesheet">
    <!-- Star Ratings -->
    <link href="{!! asset('admin_assets/plugins/bower_components/rateyo/jquery.rateyo.min.css') !!}" rel="stylesheet">
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
	
    <script src="{!! asset('admin_assets/plugins/bower_components/jquery/dist/jquery.min.js')!!}"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
          rel="stylesheet">



        <!-- Here's the camera preview -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

    <script type="text/javascript">
        var base_url = "{{ url('/').'/' }}";
    </script>
    <style>
        /*for yellow bg*/

        .navbar-header {
            background: #222a48;
        }
        #side-menu li a {
            color: #fff;
            border-left: 0px solid #2f323e;
        }
        .top-left-part .dark-logo {
            display: block;

        }
        .tiMenu{
            color: #fff;
        }
        .sidebar {
            background: #27333e;;
            box-shadow: 1px 0px 20px rgba(0, 0, 0, 0.08);
        }
        .hideMenu{
            color: #fff;
        }
        #side-menu ul > li > a.active {
            color: #EDDF10;
            font-weight: 400;
        }
        #side-menu ul > li > a:hover {
            color: #fff;
        }
        /*for yellow bg*/

        .bg-title .breadcrumb {
            background: 0 0;
            margin-bottom: 0;
            float: none;
            padding: 0;
            margin-bottom: 9px;
            font-weight: 700;
            color: #777;
        }

        .select2-container .select2-selection--single .select2-selection__rendered {
            height: auto;
            margin-top: -6px;
            padding-left: 0;
            padding-right: 0;
        }

        .select2-container .select2-selection--single {
            box-sizing: border-box;
            cursor: pointer;
            display: block;
            height: 35px;
        }

        .select2-container--default .select2-selection--single, .select2-selection .select2-selection--single {
            border: 1px solid #d2d6de;
            border-radius: 0;
            padding: 8px 11px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 26px;
            position: absolute;
            top: 4px;
            right: 1px;
            width: 20px;
        }

        .breadcrumbColor a {
            color: #41b3f9 !important;
        }

        tr td {
            color: black !important;
        }

        .tr_header {
            background-color: #EDF1F5;
        }

        table.dataTable thead th, table.dataTable thead td {
            padding: 10px 18px;
            border-bottom: 1px solid #e4e7ea;
        }

        .btnColor {
            color: #fff !important;
        }

        .validateRq {
            color: red;
        }

        .panel .panel-heading {
            border-radius: 0;
            font-weight: 500;
            font-size: 16px;
            padding: 10px 25px;
        }

        .btn_style {
            width: 106px;
        }

        .error {
            color: red;
        }
        
        #titlejob:hover
        {
            text-decoration:underline;
        }


    </style>
</head>
<body class="fix-header" onload="addMenuClass()">
	<div class="container-fluid">
		<div class="row bg-title">
			<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
			  <div><img class="img-fluid" id="lnslogo" src="https://sample.hris.livewire365.com/LEENTech%20Official%20Logo%202.png"></div>
			</div>
		</div>
	</div>
			
	<div class="container">
		<div class="row">
		    
			<div class="col-md-12">
				<div class="panel panel-info">
					<div class="panel-heading"><i class="mdi mdi-clipboard-text fa-fw"></i>List of Jobs</div>
					<div class="panel-wrapper collapse in" aria-expanded="true">
					    
										
						<div class="panel-body">
						    
						    	<div class="row">
										<div class="col-md-offset-2 col-md-8">
											@if($errors->any())
												<div class="alert alert-danger alert-dismissible" role="alert">
													<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
													@foreach($errors->all() as $error)
														<strong>{!! $error !!}</strong><br>
													@endforeach
												</div>
											@endif
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
										</div>
									</div>
									
						     
							<div class="col-md-offset-0 col-md-12">
								<div class="white-box">

								     @foreach($result as $result)
									<div class="comment-center p-t-10">
										<div class="comment-body">
											<div class="user-img">  </div>
											<div class="">
										 
										    <a href="{{route('jobPublic.show',$result->job_id)}}">
											<h3 id="titlejob" style="font-size:1.5em; font-weight: 700"> {{$result->job_title}}</h3>
											</a>
												<span class="time">@lang('recruitement.job_post') : {{$result->post}}</span><br>
												<span class="time">@lang('recruitement.job_publish_date') : {{date(" d M Y", strtotime($result->created_at))}} </span><br>
												<br/><span class="mail-desc">
													{!! $result->job_description !!}
												</span>
											</div>
											<br>
											<div class="test-center">
												<p style="font-weight:400 ">@lang('recruitement.application_end_date') : {{date(" d M Y ", strtotime($result->application_end_date))}}</p>
											</div>
										</div>
									</div>
										@endforeach
								</div>
							</div>
									
						</div>

					</div>
				</div>
			</div>
			
									
		</div>
	</div>
    
    <div style="background:white; padding-top:30px; padding-bottom:30px;">
    <footer class="text-center">
        {{date('Y')}} &copy; <strong><a href="http://leentechsystems.com/" target="_blank">LEENTech Network Solutions</a>
        </strong> All rights reserved.
    </footer>
    </div>

<!-- Bootstrap Core JavaScript -->

<script src="{!! asset('admin_assets/bootstrap/dist/js/bootstrap.min.js') !!}"></script>
<!-- Menu Plugin JavaScript -->
<script src="{!! asset('admin_assets/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js') !!}"></script>
<!--slimscroll JavaScript -->
<script src="{!! asset('admin_assets/js/jquery.slimscroll.js') !!}"></script>
<!--Wave Effects -->
<script src="{!! asset('admin_assets/js/waves.js') !!}"></script>
<!--Counter js -->
<script src="{!! asset('admin_assets/plugins/bower_components/waypoints/lib/jquery.waypoints.js') !!}"></script>
<script src="{!! asset('admin_assets/plugins/bower_components/counterup/jquery.counterup.min.js') !!}"></script>
<!-- Sparkline chart JavaScript -->
<script src="{!! asset('admin_assets/plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js') !!}"></script>
<!-- Custom Theme JavaScript -->
<script src="{!! asset('admin_assets/js/custom.min.js') !!}"></script>
<script src="{!! asset('admin_assets/js/dashboard1.js') !!}"></script>
<script src="{!! asset('admin_assets/plugins/bower_components/toast-master/js/jquery.toast.js') !!}"></script>
<script src="{!! asset('admin_assets/plugins/bower_components/datatables/jquery.dataTables.min.js') !!}"></script>
<script src="{!! asset('admin_assets/plugins/bower_components/sweetalert/sweetalert-dev.js') !!}"></script>
<!-- bootstrap-datepicker -->
<script src="{!! asset('admin_assets/plugins/bower_components/datepicker/bootstrap-datepicker.js')!!}"></script>
<!--TIme picker js-->
<script src="{!! asset('admin_assets/plugins/bower_components/timepicker/bootstrap-timepicker.min.js')!!}"></script>
<!-- select2 -->
<script src="{!! asset('admin_assets/plugins/bower_components/select2/select2.full.min.js')!!}"></script>

<script src="{!! asset('admin_assets/plugins/bower_components/toast-master/js/jquery.toast.js')!!}"></script>
<script src="{!! asset('admin_assets/js/toastr.js')!!}"></script>

<!-- jquery-validator -->
<script type="text/javascript"
        src="{!! asset('admin_assets/plugins/bower_components/jquery-validator/jquery-validator.1.15.0.js')!!}"></script>
<script type="text/javascript"
        src="{!! asset('admin_assets/plugins/bower_components/jquery-validator/jquery-additional-method.1.15.0.min.js')!!}"></script>
<!-- Star Ratings -->
<script src="{!! asset('admin_assets/plugins/bower_components/rateyo/jquery.rateyo.js')!!}"></script>


</body>

</html>

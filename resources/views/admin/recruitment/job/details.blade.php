@extends('admin.master')
@section('content')
@section('title')
@lang('recruitement.description')
@endsection
	<div class="container-fluid">
		<div class="row bg-title">
			<div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
				<ol class="breadcrumb">
					<li class="active breadcrumbColor"><a href="{{ url('dashboard') }}"><i class="fa fa-home"></i> @lang('dashboard.dashboard')</a></li>
					<li>@yield('title')</li>
				</ol>
			</div>
			<div class="col-lg-9 col-md-8 col-sm-8 col-xs-12">
				<a href="{{route('jobPost.index')}}"  class="btn btn-success pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"><i class="fa fa-list-ul" aria-hidden="true"></i>  View Job  </a>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-info">
					<div class="panel-heading"><i class="mdi mdi-clipboard-text fa-fw"></i>@yield('title')</div>
					<div class="panel-wrapper collapse in" aria-expanded="true">
						<div class="panel-body">
							<div class="col-md-offset-1 col-md-11">
							
									    	  
								<div class="white-box">
									<div class="comment-center p-t-10">
										<div class="comment-body">
											<div class="user-img">  </div>
											<div class="">
										 
											<h3 style="font-size:2em; font-weight: 700"> {{$result->job_title}}</h3><br>
											</a>
												<span class="time"><strong>@lang('recruitement.job_post') :</strong> {{$result->post}}</span><br><br>
												<span class="time"><strong>@lang('recruitement.job_publish_date') :</strong> {{date(" d M Y", strtotime($result->created_at))}} </span><br>
												<br/><span class="mail-desc">
												    <strong> @lang('recruitement.description') : </strong>
													{!! $result->job_description !!}
												</span>
												<br/><br/><span class="mail-desc">
											    	<strong> @lang('recruitement.requirements') : </strong> {!! $result->requirements !!}
												</span>
												<br>
												<span class="time"><strong>@lang('recruitement.salary') :</strong> {{$result->salary}}</span><br>
											</div>
											<br>
											<div class="test-center">
												<p style="font-weight:300 "><strong>@lang('recruitement.application_end_date') :</strong> {{date(" d M Y ", strtotime($result->application_end_date))}}</p>
											</div>
											<br>
										<div>	<iframe src="https://www.facebook.com/plugins/share_button.php?href=https://hris.livewire365.com/jobPublic/{{$result->job_id}}&layout=button&size=large&appId=360898128282376&width=77&height=28" width="77" height="28" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe></div>
										</div>
									</div>
								</div>
								
								
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	
	</div>
@endsection


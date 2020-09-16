@extends('admin.header')

@section ('show')
		<div class="row">
		    
			<div class="col-md-12">
				<div class="panel panel-info">
					<div class="panel-heading"><i class="mdi mdi-clipboard-text fa-fw"></i>List of Jobs</div>
					<div class="panel-wrapper collapse in" aria-expanded="true">
					    
										
						<div class="panel-body">
						     
							<div class="col-md-offset-0 col-md-12">
							    
							    	<div class="row">
										<div class="col-md-offset-2 col-md-6">
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
									
							    	  
								<div class="white-box">
									<div class="comment-center p-t-10">
										<div class="comment-body">
											<div class="user-img">  </div>
											<div class="">
										 
											<h3 style="font-size:2em; font-weight: 700"> {{$result->job_title}}</h3><br>
											</a>
												<span class="time"><strong>@lang('recruitement.job_post') :</strong> {{$result->post}}</span><br><br>
												<span class="time"><strong>@lang('recruitement.job_publish_date') :</strong> {{date(" d M Y", strtotime($result->publish_date))}} </span><br>
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
											<a  title="View Details" href="{{route('jobPublic.storeapp',$result->job_id)}}" class="btn btn-info" id="formSubmit" style="color:white; font-size:1.2em; padding-left: 20px; padding-right:20px;">
														@lang('recruitement.apply')
											</a>
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

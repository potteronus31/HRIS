@extends('admin.header')

@section('lnsjobs')
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
												<span class="time">@lang('recruitement.job_publish_date') : {{date(" d M Y", strtotime($result->publish_date))}} </span><br>
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
@endsection
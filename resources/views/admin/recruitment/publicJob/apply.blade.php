@extends('admin.header')

@section ('apply')

	<div class="row">
		    
			<div class="col-md-12">
				<div class="panel panel-info">
					<div class="panel-heading"><i class="mdi mdi-clipboard-text fa-fw"></i>@lang('recruitement.app_form')</div>
					<div class="panel-wrapper collapse in" aria-expanded="true">
					    
										
						<div class="panel-body">

								{{ Form::open(array('route' => 'job.store','enctype'=>'multipart/form-data','class'=>'form-horizontal','id'=>'jobPostForm')) }}
							
								<div class="form-body">
								    
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
									
                                    @if(isset($result->job_id))
                                        <input type="text" value="{{$result->job_id}}" name="job_id" hidden>
                                  @endif
                                    

									<div class="row">
										<div class="col-md-10">
											<div class="form-group">
												<label class="control-label col-md-3">@lang('recruitement.applicant')<span class="validateRq">*</span></label>
												<div class="col-md-9">
													{!! Form::text('applicant_name', Input::old('applicant_name'), $attributes = array('class'=>'form-control required applicant_name','id'=>'applicant','placeholder'=>__('recruitement.applicant'))) !!}
												</div>
											</div>
										</div>
									</div>
										<div class="row">
										<div class="col-md-10">
											<div class="form-group">
												<label class="control-label col-md-3">@lang('recruitement.app_email')<span class="validateRq">*</span></label>
												<div class="col-md-9">
													{!! Form::text('applicant_email', Input::old('applicant_email'), $attributes = array('class'=>'form-control required applicant_email','id'=>'app_email','placeholder'=>__('recruitement.app_email'))) !!}
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-10">
											<div class="form-group">
												<label class="control-label col-md-3">@lang('recruitement.phone')<span class="validateRq">*</span></label>
												<div class="col-md-9">
													{!!Form::number('phone', null, ['class' => 'number form-control required phone', 'id' => 'numberField', 'placeholder'=> 'Phone Number'])!!}
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-10">
											<div class="form-group">
												<label class="control-label col-md-3">@lang('recruitement.address')<span class="validateRq">*</span></label>
												<div class="col-md-9">
													{!! Form::text('address', Input::old('address'), $attributes = array('class'=>'form-control required address','id'=>'address','placeholder'=>__('recruitement.address'))) !!}
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-10">
											<div class="form-group">
												<label class="control-label col-md-3">@lang('recruitement.cov_letter')<span class="validateRq">*</span></label>
												<div class="col-md-9">
													{!! Form::textarea('cover_letter',Input::old('cover_letter'), $attributes = array('class'=>'form-control textarea_editor required','rows'=>'15','id'=>'cov_letter','placeholder'=>__('recruitement.cov_letter'))) !!}
												</div>
											</div>
										</div>
								    </div>
								    <div class="row">
										<div class="col-md-10">
											<div class="form-group">
												<label class="control-label col-md-3">@lang('recruitement.resume')<span class="validateRq">*</span></label>
													<div class="col-md-9">
													<div class="input-group">
														<div class="input-group-addon"><i class="fa fa-files-o"></i></div>
														{!! Form::file('attach_file',$attributes = array('class'=>'form-control')) !!}
													</div>
												</div>
											</div>
										</div>
								    </div>
								    
								<div class="form-actions">
									<div class="row">
										<div class="col-md-10">
											<div class="row">
												<div class="col-md-offset-3 col-md-8">
														<button type="submit" class="btn btn-info"><i class="fa fa-check"></i> Submit Application</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							{{ Form::close() }}
						</div>

					</div>
				</div>
			</div>
			
									
		</div>
	</div>
 
 @endsection
@extends('layouts.common') @include('layouts.head') @section('section')
<section class="future-forecast">
	@include('layouts.sidebar')
	<div class="mainpanel">
		@include('layouts.containerhead')

		<div class="pageheader clearfix">
			<div class="col-md-12 no-icon no_padding">
				<h2>{{ trans('passwords.change_password') }}</h2>
			</div>
		</div>
		@if (session()->has('password'))
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<span>{{ session('password') }}</span>
		</div>
		@endif
		<div class="contentpanel no_title">
			<div class="form-page s_table">
				<div class="form-page-content">
					<div class="inner-content clearfix">
					<form name="" method="post" action="{{url('changepassword')}}" enctype="multipart/form-data">
					{{ csrf_field() }}
					<div class="row">
						<div class="col-sm-9 ">
							<div class="form-group @if ($errors->has('old_password')) has-error @endif">
								<div class="form-group">
									<div class="col-md-4">
										<label class="label_name label_block">	{{trans('passwords.old_password')}}<span class="asterisk">*</span></label>
									</div>
									<div class="col-md-8">
										<input type="password" class="form-control" name="old_password"> @if ($errors->has('old_password'))
										<p class="help-block">{{ $errors->first('old_password') }}</p> @endif
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-9 ">
							<div class="form-group @if ($errors->has('new_password')) has-error @endif">
								<div class="col-md-4">
									<label class="label_name label_block">{{trans('passwords.new_password')}}<span class="asterisk">*</span></label>
								</div>
								<div class="col-md-8">
									<input type="password" class="form-control" name="new_password"> @if ($errors->has('new_password'))
									<p class="help-block">{{ $errors->first('new_password') }}</p> @endif
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-9 ">
							<div class="form-group @if ($errors->has('confirm_password')) has-error @endif">
								<div class="col-md-4">
									<label class="label_name label_block">{{trans('passwords.confirm_password')}}<span class="asterisk">*</span></label>
								</div>
								<div class="col-md-8">
									<input type="password" class="form-control" name="confirm_password"> @if ($errors->has('confirm_password'))
									<p class="help-block">{{ $errors->first('confirm_password') }}</p> @endif
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-12 col-xs-12 col-sm-12 bottom text-right">
						<a class="btn-default btn btn_wt_bg" href="{{url('receiptvoucher')}}">{{ trans('general.cancel') }}</a>
						<input type="submit" class="btn blue-button btn_w_bg" value="Submit" />
                    </div>
				</form>
			</div>
			</div>
		</div>
	</div>
</div>
</section>
@section('scripts')

<script>
	window.setTimeout(function () {
		$(".alert").fadeTo(500, 0).slideUp(500, function () {
			$(this).remove();
		});
	}, 2500);
</script>
<script type="text/javascript" src="{{asset('assets/js/lib/jquery.dd.js')}}"></script>
<script src="{{asset('assets/js/modules/base/requestFactory.js')}}"></script>
<script src="{{asset('assets/js/modules/base/notificationDirective.js')}}"></script>
@endsection
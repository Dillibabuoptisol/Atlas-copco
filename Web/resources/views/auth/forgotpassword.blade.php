@extends('layouts.login')

@section('content')
<div class="login-template" data-ng-controller="forgotPasswordController as forgotPasswordCtrl">
	<div class="left-side">
		<h1 class="logo">
		<img src="{{asset('assets/images/Atlaslogo.png')}}">
		</h1>
		@include('layouts.notifications')
		
		<form data-base-validator data-ng-submit="forgotPasswordCtrl.forgotPassword($event)" >
			<h3>Forgot Password</h3>
			<div class="form-group" data-ng-class="{'has-error': errors.email.has}">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group has-feedback">
							<input type="text" class="form-control" data-ng-model="forgotPasswordCtrl.userData.email" id="email" placeholder="Email">
							<span class="icon-user form-control-feedback"><span class="path1"></span><span class="path2"></span></span>
							<p class="help-block" data-ng-show="errors.email.has">
								@{{errors.email.message }}
							</p>
						</div>
					</div>
				</div>
			</div>

			 <div class="text-center ">
				<button type="submit" data-ng-disabled="submitBtn" class="button">Submit</button>
				<a href="{{url('/login')}}" type="submit" class="back-to-login">Back to Login</a>
			</div>
		</form>
	</div>
</div>
@section('scripts')
<script src="{{asset('assets/js/lib/custom.js')}}"></script>
<script src="{{asset('assets/js/modules/base/requestFactory.js')}}"></script>
<script src="{{asset('assets/js/modules/base/notificationDirective.js')}}"></script>
<script src="{{asset('assets/js/modules/base/Validate.js')}}"></script>
<script src="{{asset('assets/js/modules/base/validatorDirective.js')}}"></script>
<script src="{{asset('assets/js/modules/forgotpassword/app.js')}}"></script>
@endsection
@endsection

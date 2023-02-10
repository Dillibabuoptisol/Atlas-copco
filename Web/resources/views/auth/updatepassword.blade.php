@extends('layouts.login')
@section('content')
<div class="login-template" data-ng-controller="forgotPasswordController as forgotPasswordCtrl">
	<div class="left-side">
		<h1 class="logo">
		<img src="{{asset('assets/images/Atlaslogo.png')}}">
		</h1>
		@include('layouts.notifications')
		<toaster-container toaster-options="{'limit':1}"></toaster-container>
		<form data-base-validator data-ng-submit="forgotPasswordCtrl.resetPassword($event)" >
			<h3>Reset Password</h3>
			<div class="form-group" data-ng-class="{'has-error': errors.password.has}">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group has-feedback">
							<input type="password" class="form-control" data-ng-model="forgotPasswordCtrl.userData.password" id="password" placeholder="New Password">
							<span class="icon-lock form-control-feedback"><span class="path1"></span><span class="path2"></span></span>
							<p class="help-block" data-ng-show="errors.password.has">
								@{{errors.password.message }}
							</p>
						</div>
					</div>
				</div>
			</div>
			<div class="form-group" data-ng-class="{'has-error': errors.password_confirmation.has}">
				<div class="row">
					<div class="col-md-12">
						<div class="form-group has-feedback">
							<input type="password" class="form-control" data-ng-model="forgotPasswordCtrl.userData.password_confirmation" id="password_confirmation" placeholder="Confirm password">
							<span class="icon-lock form-control-feedback"><span class="path1"></span><span class="path2"></span></span>
							<p class="help-block" data-ng-show="errors.password_confirmation.has">
								@{{errors.password_confirmation.message }}
							</p>
						</div>
					</div>
				</div>
			</div>
			<div class="text-center ">
				<button type="submit" class="button">Submit</button>
				<a href="{{url('/login')}}" type="submit" class="back-to-login">Back to Login</a>
			</div>
		</form>
		<div class="login-footer">
			<p>
				{{trans('general.login.footer_quote')}}
				<span>{{trans('general.login.all_rights')}}</span>
			</p>
		</div>
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
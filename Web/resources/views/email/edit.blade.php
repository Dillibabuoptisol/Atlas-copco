@extends('layouts.common')
@section('section')
<section class="create-new">
	@include('layouts.sidebar')
	<div class="mainpanel">
		@include('layouts.containerhead') 
		@include('layouts.notifications')
		<div class="pageheader clearfix">
			<div class="col-md-12 no-icon no_padding">
				<h2>{{ trans('general.edit') }}</h2>
			</div>
		</div>
<div class="contentpanel">
	<div class="form-page s_table">
    <div class="form-page-header">
		<i class="icon-create-new"></i> {{ trans('email.edit_email_template') }}
	</div>
    @include('layouts.errors')
    <div class="form-page-content">
    <div class="inner-content clearfix" data-ng-controller="EmailController as emailCtrl" data-ng-init="emailCtrl.fetchSingleInfo({{$id}})" >
            <form method="post" data-base-validator data-ng-submit = "emailCtrl.save($event)" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-12">
                <div class="form-group" data-ng-class="{'has-error': errors.name.has}">
                        <div class="col-md-2">
                            <label class="label-name">{{ trans('email.name') }}<span class="asterisk">*</span></label>
                        </div>
                        <div class="col-md-6">
                            <input class="form-control" data-validation-name="{{ trans('email.name') }}" name="name" data-ng-model="emailCtrl.email.name" />
                            <p class="help-block" data-ng-show="errors.name.has">@{{ errors.name.message }}</p>
                        </div>
                    </div>
                    <div class="form-group" data-ng-class="{'has-error': errors.subject.has}">
                        <div class="col-md-2">
                            <label class="label-name">{{ trans('email.subject') }}<span class="asterisk">*</span></label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" data-validation-name="{{ trans('email.subject') }}" name="subject" data-ng-model='emailCtrl.email.subject'>
                            <p class="help-block" data-ng-show="errors.subject.has">@{{ errors.subject.message }}</p>
                        </div>
                    </div>
                    <div class="form-group" data-ng-class="{'has-error': errors.body.has}">
                        <div class="col-md-2">
                            <label class="label-name">{{ trans('email.body') }}</label>
                        </div>
                        <div class="col-md-10">
                            <textarea  ui-tinymce="tinymceOptions" rows='14' class="form-control" data-ng-model="emailCtrl.email.body" data-ng-model="emailCtrl.email.body" name='body'></textarea>
                            <p class="help-block" data-ng-show="errors.body.has">@{{ errors.body.message }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-xs-12 col-sm-12 bottom text-right">
				<a href="{{url('email')}}" class="btn-default btn_wt_bg btn" onclick="goBack()">{{ trans('general.cancel') }}</a>								
				<input type="submit" class="btn blue-button btn_w_bg" value="{{ trans('general.submit') }}"/>
			</div>
            </form>
        </div>
    </div>
</div>
</div>
</div>
</section>
@endsection
@section('scripts')
<script src="{{asset('assets/js/modules/base/requestFactory.js')}}"></script> 
<script src="{{asset('assets/js/modules/base/Validate.js')}}"></script>
<script src="{{asset('assets/js/modules/base/validatorDirective.js')}}"></script>
<script src="{{asset('assets/js/modules/base/notificationDirective.js')}}"></script>
<script src="{{asset('assets/js/lib/tinymce/tinymce.min.js')}}"></script>
<script src="{{asset('assets/js/lib/tinymce/tinymce.js')}}"></script>
<script src="{{asset('assets/js/modules/email/app.js')}}"></script>
<script src="{{asset('assets/js/lib/wysihtml5-0.3.0.min.js')}}"></script>
<script src="{{asset('assets/js/lib/bootstrap-wysihtml5.js')}}"></script>
@endsection
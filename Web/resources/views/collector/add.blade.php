@extends('layouts.common')
@section('section')
<section class="create-new">
	@include('layouts.sidebar')
	<div class="mainpanel">
		@include('layouts.containerhead') 
		@include('layouts.notifications')
<div class="pageheader clearfix">
	<div class="col-md-12 no-icon no_padding">
		<h2>{{trans('general.manage_collector')}}</h2>
	</div>
</div>
   <div class="contentpanel">
   	<div class="form-page s_table">
   		<div class="form-page-header">
			<i class="icon-create-new"></i> {{trans('user.add_collector')}}
		</div>
   @include('layouts.errors')
   <div class="form-page-content">
	   <div class="inner-content clearfix" data-ng-controller="CollectorUserController as collectorCtrl" data-ng-init = "collectorCtrl.fetchAddformRules()">
	      <form method="post" data-base-validator data-ng-submit = "collectorCtrl.save($event)" enctype="multipart/form-data">
	         {{ csrf_field() }}
		         	<div class="row">
		         		<div class="col-md-12">
                            <div class="form-group" data-ng-class="{'has-error': errors.name.has}">
                                <div class="col-md-2">
                                    <label class="label-name">{{ trans('general.name') }}<span class="asterisk">*</span></label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" data-validation-name="{{ trans('general.name') }}" data-ng-model='collectorCtrl.Collector.name' name="name">
		                              <p class="help-block" data-ng-show="errors.name.has">@{{ errors.name.message }}</p>
                                </div>
                            </div>
                            <div class="form-group" data-ng-class="{'has-error': errors.mobile_number.has}">
                                <div class="col-md-2">
                                    <label class="label-name">{{ trans('general.phone_number') }}<span class="asterisk">*</span></label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" data-validation-name="Phone Number" name="mobile_number" data-ng-model='collectorCtrl.Collector.mobile_number'>
		                              <p class="help-block" data-ng-show="errors.mobile_number.has">@{{ errors.mobile_number.message }}</p>
                                </div>
                            </div>
                            <div class="form-group" data-ng-class="{'has-error': errors.email.has}">
                                <div class="col-md-2">
                                    <label class="label-name">{{ trans('general.email') }}<span class="asterisk">*</span></label>
                                </div>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" data-ng-model='collectorCtrl.Collector.email' data-validation-name="{{ trans('general.email') }}" name="email">
		                              <p class="help-block" data-ng-show="errors.email.has">@{{ errors.email.message }}</p>
                                </div>
                            </div>
                            <div class="form-group" data-ng-class="{'has-error': errors.collector_id.has}">
                                <div class="col-md-2">
                                    <label class="label-name">{{ trans('general.collector_id') }}<span class="asterisk">*</span></label>
                                </div>
                                <div class="col-md-6">
                                    <input type="collector_id" class="form-control" data-ng-model='collectorCtrl.Collector.collector_id' data-validation-name="{{ trans('general.collector_id') }}" name="collector_id">
		                              <p class="help-block" data-ng-show="errors.collector_id.has">@{{ errors.collector_id.message }}</p>
                                </div>
                            </div>
                            <div class="form-group" data-ng-class="{'has-error': errors.name.has}">
                                <div class="col-md-2">
                                    <label class="label_block no_margin">{{ trans('general.status') }}<span class="asterisk">*</span></label>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-3 nopadding">
			                           <div class="rdio rdio-primary">
			                              <input type="radio" id="acive-freelancer" data-ng-value="1" name="is_active" data-ng-model='collectorCtrl.Collector.is_active'>                                
			                              <label for="acive-freelancer">{{ trans('general.active') }}</label>
			                           </div>
			                        </div>
			                        <div class="col-md-3 nopadding">
			                           <div class="rdio rdio-primary">
			                              <input type="radio" id="inactive-freelancer" data-ng-value="0" name="is_active" data-ng-model='collectorCtrl.Collector.is_active'>
			                              <label for="inactive-freelancer">{{ trans('general.inactive') }}</label>
			                           </div>
			                        </div>
                                </div>
                            </div>
                        </div>

		              
		         </div>			
				<div class="col-md-12 col-xs-12 col-sm-12 bottom text-right">
					<a href="{{url('collector')}}" class="btn-default btn_wt_bg btn" onclick="goBack()">{{trans('general.cancel')}}</a><input type="submit" class="btn blue-button btn_w_bg" value="{{trans('general.submit')}}"/>
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
<script src="{{asset('assets/js/modules/base/Uploader.js')}}"></script>
<script src="{{asset('assets/js/modules/collector/app.js')}}"></script>
@endsection
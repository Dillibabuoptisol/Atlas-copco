@extends('layouts.common')
@section('section')
<section class="create-new">
	@include('layouts.sidebar')
	<div class="mainpanel">
		@include('layouts.containerhead') 
		@include('layouts.notifications')
		<div class="pageheader clearfix">
			<div class="col-md-12 no-icon no_padding">
				<h2>{{trans('partsmaster.create_new')}}</h2>
			</div>
		</div>
<div class="contentpanel">
	<div class="form-page s_table">
	<div class="form-page-header">
		<i class="icon-create-new"></i> {{trans('user.add_roles')}}
	</div>
    @include('layouts.errors')
    <div class="form-page-content">
        <div class="inner-content clearfix" data-ng-controller="RoleController as roleCtrl" data-ng-init="roleCtrl.fetchInfo()">
            <form name="roleForm" data-base-validator data-ng-submit="roleCtrl.save($event)">
                <div class="col-md-6">
                   <div class="form-group" data-ng-class="{'has-error': errors.name.has}" >
                        <div class="col-md-5">
                            <label class="label-name top_m">Role Name<span class="asterisk">*</span></label>
                        </div>
                        <div class="col-md-7">
                            <input data-ng-model="roleCtrl.userRole.name" type="text" class="form-control" name="name">
                            <p class="help-block" data-ng-show="errors.name.has">@{{ errors.name.message }}</p>
                        </div>
                    </div>
                    
                     <div class="form-group" data-ng-class="{'has-error': errors.permissions.has}">
                        <div class="col-md-5">
                            <label class="label-name top_m">User Permissions<span class="asterisk">*</span></label>
                        </div>
                       <div class="col-md-7">                        
                       <multiselect ng-model="roleCtrl.userRole.permissions" name="permissions" options="options" show-select-all="true" show-unselect-all="true"></multiselect>
                       <p class="help-block" data-ng-show="errors.permissions.has">@{{ errors.name.message }}</p>
                       <p class="help-block" style="color: #a94442" data-ng-show="roleCtrl.permissionsMsg">The User permission is required.</p>
                       </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="col-md-5">
                            <label>Status<span class="asterisk">*</span></label>
                        </div>
                        <div class="col-md-7">
                            <div class="col-md-4 nopadding">
                                <div class="rdio rdio-primary">
                                  <input data-ng-model="roleCtrl.userRole.is_active" type="radio" id="active" data-ng-value="1" name="is_active">                                
                                    <label for="active">{{trans('general.active')}}</label>
                                </div>
                            </div>
                            <div class="col-md-4 nopadding">
                                <div class="rdio rdio-primary">
                                  <input data-ng-model="roleCtrl.userRole.is_active" type="radio" id="inactive" data-ng-value="0" name="is_active">
                                  <label for="inactive">{{trans('general.inactive')}}</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-xs-12 col-sm-12 bottom text-right">
					<a href="{{url('userrole')}}" class="btn-default btn_wt_bg btn" onclick="goBack()">{{trans('general.cancel')}}</a>								
					<input type="submit" class="btn blue-button btn_w_bg" value="{{trans('general.submit')}}"/>
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
<script src="{{asset('assets/js/lib/angular-bootstrap-multiselect.min.js')}}"></script>
<script src="{{asset('assets/js/modules/base/requestFactory.js')}}"></script>
<script src="{{asset('assets/js/modules/base/Validate.js')}}"></script>
<script src="{{asset('assets/js/modules/base/validatorDirective.js')}}"></script>
<script src="{{asset('assets/js/modules/base/notificationDirective.js')}}"></script>
<script src="{{asset('assets/js/modules/userrole/app.js')}}"></script>
@endsection
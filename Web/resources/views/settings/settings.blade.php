@extends('layouts.common')
@section('section')
<section class="create-new">
	@include('layouts.sidebar')
	<div class="mainpanel">
		@include('layouts.containerhead')
		@include('layouts.notifications')
		<div class="pageheader clearfix">
			<div class="col-md-12 no-icon no_padding">
				<h2>{{trans('general.settings')}}</h2>
			</div>
		</div>
		<div class="contentpanel">
			<div class="form-page s_table table-content-change">
				<div class="form-page-header">
					<i class="icon-create-new"></i> {{trans('settings.general_settings')}}
				</div>
				@include('layouts.errors')
				<div class="form-page-content">
					<div class="inner-content clearfix">
						<form name="userForm" method="POST" action="{{url('settings/update')}}" enctype="multipart/form-data">
							{!! csrf_field() !!}
							<div class="row">
                                <div class="col-md-12">
                                	@foreach($settingsField as $key => $value)
                                	@foreach($value['category'] as $key => $settingDetail)
									<h4 class="pannel-body-title">{{ $settingDetail->name }}</h4>
									@foreach($settingDetail['settings'] as $key => $setting)
                                    <div class="form-group" data-ng-class="{'has-error': errors.name.has} @if($setting->is_hidden) hide @endif">
                                        <div class="col-md-2">
                                            <label class="label-name">{{ $setting->display_name }}</label>
                                        </div>
                                        <div class="col-md-6">
											<input required name="{{$settingDetail->slug.'__'.$setting->setting_name}}" class="form-control" id="{{$setting->setting_name}}" value="{{old($setting->setting_name, $setting->setting_value)}}">
											@if($setting->description)
											<p class="help-block">{{$setting->description}}</p>
											@endif
                                        </div>
                                    </div>
                                    @endforeach
									@endforeach
									@endforeach
                                </div>
                            </div>

                            <div class="col-md-12 col-xs-12 col-sm-12 bottom text-right">
                                <input type="submit" class="btn blue-button btn_w_bg" value="{{trans('general.submit')}}"/>
                            </div>
							
							
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>
	@endsection
	@section('scripts')
	<script>
	window.setTimeout(function() {
	$(".alert").fadeTo(500, 0).slideUp(500, function(){
	$(this).remove();
	});
	}, 2500);
	</script>
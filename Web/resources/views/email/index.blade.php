@extends('layouts.common')
@section('section')
<section class="create-new">
	@include('layouts.sidebar')
	<div class="mainpanel">
		@include('layouts.containerhead') 
		@include('layouts.notifications')
    <div class="contentpanel">
        <div class="content clearfix">
            <div data-grid-view 
                 data-rows-per-page="10"
                 data-template-name="email"
                 data-module-name="emailtemplate"
                 data-request-service="admin"
            ></div>        
        </div>
    </div>
  </div>
</section>        
@endsection

@section('scripts')    
    <script type="text/javascript" src="{{asset('assets/js/lib/moment.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/lib/jquery.dd.js')}}"></script>    
    <script type="text/javascript" src="{{asset('assets/js/lib/tablesaw.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/lib/tablesaw-init.js')}}"></script>
    <script src="{{asset('assets/js/modules/base/requestFactory.js')}}"></script>
    <script src="{{asset('assets/js/modules/base/notificationDirective.js')}}"></script>
    <script src="{{asset('assets/js/modules/base/gridView.js')}}"></script>
    <script src="{{asset('assets/js/modules/base/grid.js')}}"></script>
@endsection
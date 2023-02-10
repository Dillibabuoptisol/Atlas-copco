@include('layouts.head')
@section('section-heading')
@endsection
    <!-- Preloader -->
    <div id="preloader">
        <div id="status">
            <div class="loader-box">
                
    <div class="lable">Loading </div>
    <div class="loader">
        <img src="{{asset('assets/images/loader.gif')}}" height="70">

    </div>
</div>
        </div>
    </div>
<section class="future-forecast">
	@include('layouts.sidebar')
	<div class="mainpanel">
		@include('layouts.containerhead')
		@include('layouts.notifications')
    <div class="contentpanel">
        <div class="content clearfix">
            <div data-grid-view 
                 data-rows-per-page="10"
                 data-module-name="admin"
            ></div>        
        </div>
    </div>        
</div>
</section>

@section('scripts')    
    <script type="text/javascript" src="{{asset('assets/js/lib/jquery.dd.js')}}"></script> <script src="{{asset('assets/js/modules/base/requestFactory.js')}}"></script>
    <script src="{{asset('assets/js/modules/base/notificationDirective.js')}}"></script>
    <script src="{{asset('assets/js/modules/base/gridView.js')}}"></script>
    <script src="{{asset('assets/js/modules/base/grid.js')}}"></script>
@endsection
        @include('layouts.footer')       
        @section('scripts')
        @show
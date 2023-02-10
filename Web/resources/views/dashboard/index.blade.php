@extends('layouts.default')
@section('content')
	@include('layouts.errors')
    <div class="contentpanel dashboard" style="text-align: center;">
        <h1>{{ trans('general.dashboard') }}</h1>
        <p>{{ trans('general.coming_soon') }}</p>
    </div>   
@endsection

@section('scripts')
<script>
window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 2500);
</script>    
    <script type="text/javascript" src="{{asset('assets/js/lib/moment.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/lib/jquery.dd.js')}}"></script>    
    <script src="{{asset('assets/js/modules/base/requestFactory.js')}}"></script>
    <script src="{{asset('assets/js/modules/base/notificationDirective.js')}}"></script>
    <script src="{{asset('assets/js/modules/base/gridView.js')}}"></script>
    <script src="{{asset('assets/js/modules/base/grid.js')}}"></script>
@endsection
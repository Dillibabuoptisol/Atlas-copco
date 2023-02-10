<!DOCTYPE>
<html>
   @include('layouts.head')
    <body>
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
	@yield('section')
	
        @include('layouts.footer')       
        @section('scripts')
        @show
        
    </body>
</html>
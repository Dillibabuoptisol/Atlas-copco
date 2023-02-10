<!DOCTYPE>
<html>
   @include('layouts.head')
    <body>
	<!-- Preloader -->
	<div id="preloader">
		<div id="status">
			<div class="loader-box">
                
	<div class="lable">Loading Please Wait ... <b class="percentage_value">80%</b></div>
	<div class="loader">
        <div class="element-animation">
            <img src="{{asset('assets/images/car_loader.png')}}"  width="997" height="70" />
        </div>

	</div>
</div>
		</div>
	</div>

	<section class="parts-master">
            @include('layouts.sidebar')
            <div class="mainpanel">
                @include('layouts.containerhead')                
                @include('layouts.notifications')
                @yield('content')
            </div>          
        </section>
        @include('layouts.footer')       
        @section('scripts')
        @show
        
        
    </body>
</html>
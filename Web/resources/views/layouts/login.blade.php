 @include('layouts.head')
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
  <section class="clearfix">
   @yield('content')
  </section>
  @include('layouts.footer')
  @section('scripts')
  @show
 </body>
</html>
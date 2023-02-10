    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>	
	<script src="{{asset('assets/js/lib/bootstrap.min.js')}}"></script>
	<script src="{{asset('assets/js/lib/jquery.sparkline.min.js')}}"></script>
    <script src="{{asset('assets/js/lib/jquery-ui-1.10.3.min.js')}}"></script>
	<script src="{{asset('assets/js/lib/toggles.min.js')}}"></script>
    <script src="{{asset('assets/js/lib/tablesaw.js')}}"></script>
    <script src="{{asset('assets/js/lib/tablesaw-init.js')}}"></script> 
    <script src="{{asset('assets/js/lib/dropzone.min.js')}}"></script>
    <script src="{{asset('assets/js/lib/chosen.jquery.min.js')}}"></script>
	<script src="{{asset('assets/js/lib/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<!--     <script src="{{asset('assets/js/modules/base/toaster.js')}}"></script> -->
	<script type="text/javascript" src="{{asset('assets/js/lib/angular.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/js/lib/angular-ui-router.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/js/lib/moment.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/js/lib/daterangepicker.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/js/lib/bootstrap-datetimepicker.js')}}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.5.0/js/bootstrap-datepicker.js"></script>	
    <script>
        (function($){
			$(window).load(function(){

            $('.side-bar-scroll, .tablesaw-columntoggle-popup').mCustomScrollbar({ 
                    theme:"dark-3"        
            });

            $('.children').mCustomScrollbar({ 
                    theme:"dark-3"        
            });
       });
		})(jQuery);
        
        $(document).click(function(){
           if($("body").hasClass("leftpanel-collapsed")) {
               $("body").removeClass("leftpanel-open")
           }
            else {
                 $("body").addClass("leftpanel-open");
                
            }
            if($("body").hasClass("leftpanel-open")) {
            $('.children > .mCustomScrollBox ').css("max-height", "");;
            }
        });
        
        $(".menutoggle").click(function() {
           $($("li").removeClass("nav-active")) 
        });
        
        $(document).ready(function() {
        	$(".chosen").chosen({disable_search: true});
            
            $('.datepicker').datepicker();
            
            $(document).ready(function() {
                 $('thead th .ckbox input').click(function(event) {  //on click 
                    if(this.checked) { // check select status
                        $('td .ckbox input').each(function() { //loop through each checkbox
                            this.checked = true;  //select all checkboxes with class "checkbox1"               
                        });
                    }else{
                        $('td .ckbox input').each(function() { //loop through each checkbox
                            this.checked = false; //deselect all checkboxes with class "checkbox1"  
                        });         
                    }
                });
                $(".ckbox input").click(function() {
                    if ($('thead th .ckbox input').is(':checked')) {
                        $(".options-drop").show();
                    }
                    else
                        $(".options-drop").hide();
                });
            });

        });
                                      
        $(document).ready(function () {
            $('#yearpicker').datepicker({
                minViewMode: 'years',
                autoclose: true,
                format: 'yyyy'
            });  
        
        });
		$(document).ready(function () {
            $('#monthpicker').datepicker({
                minViewMode: 1,
                autoclose: true,
     	        format: 'MM'
            });
        });
   $("input#collector_default_password").on({
          keydown: function(e) {
            if (e.which === 32)
              return false;
          },
          change: function() {
            this.value = this.value.replace(/\s/g, "");
          }
        });
    </script>
    <script src="{{asset('assets/js/lib/custom.js')}}"></script>
	<!--<script src="js/dashboard.js"></script>-->	

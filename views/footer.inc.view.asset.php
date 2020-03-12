
<script type="text/javascript" src="../js/general.js"></script>
<script type="text/javascript" src="../js/jq_plugins/select2/js/select2.full.min.js"></script>
<link rel="stylesheet" href="../js/jq_plugins/select2/css/select2.css" />

<script type="text/javascript" src="../js/jq_plugins/jquery.blockUI.js"></script>
<script type="text/javascript"
	src="../js/jq_plugins/jasny-bootstrap/js/jasny-bootstrap.min.js"></script>
<script type="text/javascript" src="../js/jq_plugins/autoNumeric.js"></script>

<script>

	$(function(){

		$(".hora").inputmask({ mask: '99:99' });            
	    $(".decimal").autoNumeric('init', { aSep: ',', aDec: '.' });
	    $(".decimalComa").autoNumeric('init', { aSep: '.', aDec: ',' });
	    $(".moneda").autoNumeric('init', { aSep: ',', aDec: '.', mDec: '0', aSign: '$ ' });
	    $(".monedaComa2Dec").autoNumeric('init', { aSep: '.', aDec: ',', mDec: '2', aSign: '' });
	    $(".entero").autoNumeric('init', { aSep: '', mDec: '0' });
	    $(".tip").tooltip({ 'delay': { show: 500, hide: 1000 } });         
		
		$("#btnMenu").on("click",function(){
			$("#menu").slideToggle("200",function(){
				//console.log("Entro al toggle")
				if($("#menu").is(":visible")){
					//console.log("esta visible")					
					$("#main").removeClass("");
					//console.log($("#main").attr("class"));
					$("#main").attr("class", "");
					$("#main").addClass("col-md-9 ml-sm-auto col-lg-10 px-4");
				}else{
					//console.log("nooooo esta visible")
					//console.log($("#main").attr("class"));
					$("#main").attr("class", "");
					$("#main").removeClass("");
					$("#main").addClass("col-12");
				}

			});
					
		});
		
	})
	
	</script>

  <!-- Icons 
  <script src="https://unpkg.com/feather-icons/dist/feather.min.js"></script>
  <script>
    feather.replace()
  </script>
  -->


  <!-- jQuery 3 
  <script src="assets/vendor_components/jquery/dist/jquery.js"></script>
  -->
  <!-- jQuery UI 1.11.4 
  <script src="assets/vendor_components/jquery-ui/jquery-ui.js"></script>
  -->
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip 
  <script>
    $.widget.bridge('uibutton', $.ui.button);
  </script>
  -->
  


  <!-- FLOT CHARTS 
  <script src="assets/vendor_components/Flot/jquery.flot.js"></script>
  -->
  <!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized
  <script src="assets/vendor_components/Flot/jquery.flot.resize.js"></script>
   -->

  <!-- FLOT PIE PLUGIN - also used to draw donut charts 
  <script src="assets/vendor_components/Flot/jquery.flot.pie.js"></script>
  -->
  <!-- FLOT CATEGORIES PLUGIN - Used to draw bar charts 
  <script src="assets/vendor_components/Flot/jquery.flot.categories.js"></script>
  -->
  <!-- ChartJS 
  <script src="assets/vendor_components/chart-js/chart.js"></script>
  -->

  <!-- Sparkline 
  <script
    src="assets/vendor_components/jquery-sparkline/dist/jquery.sparkline.js"></script>
  -->
  <!-- jvectormap 
  <script
    src="assets/vendor_plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
  <script
    src="assets/vendor_plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    -->
  <!-- jQuery Knob Chart 
  <script src="assets/vendor_components/jquery-knob/js/jquery.knob.js"></script>
  -->
  <!-- daterangepicker 
  <script src="assets/vendor_components/moment/min/moment.min.js"></script>
  <script
    src="assets/vendor_components/bootstrap-daterangepicker/daterangepicker.js"></script>
    -->
  <!-- datepicker
  <script
    src="assets/vendor_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.js"></script>
    -->
  <!-- Bootstrap WYSIHTML5 
  <script
    src="assets/vendor_plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.js"></script>
    -->
  <!-- Slimscroll -->
  <script
    src="../js/jquery.slimscroll.js"></script>

  <!-- FastClick 
  <script src="assets/vendor_components/fastclick/lib/fastclick.js"></script>
    -->
  <!-- apro_admin App -->
  <script src="../js/template.js"></script>

  <!-- apro_admin dashboard demo (This is only for demo purposes) 
  <script src="../js/dashboard.js"></script>-->

  <!-- apro_admin for demo purposes 
  <script src="js/demo.js"></script>
    -->
  <!-- apro_admin for Chart purposes 
  <script src="js/pages/widget-charts.js"></script>
    -->

  <!-- weather for demo purposes 
  <script src="assets/vendor_plugins/weather-icons/WeatherIcon.js"></script>

  <script type="text/javascript">
  
    WeatherIcon.add('icon1' , WeatherIcon.SLEET , {stroke:false , shadow:false , animated:true } );
    WeatherIcon.add('icon2' , WeatherIcon.SNOW , {stroke:false , shadow:false , animated:true } );
    WeatherIcon.add('icon3' , WeatherIcon.LIGHTRAINTHUNDER , {stroke:false , shadow:false , animated:true } );

  </script>
  -->


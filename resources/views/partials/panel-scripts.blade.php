    <!-- google web fonts -->
<script>
    WebFontConfig = {
        google: {
            families: [
                'Source+Code+Pro:400,700:latin',
                'Roboto:400,300,500,700,400italic:latin'
            ]
        }
    };
    (function() {
        var wf = document.createElement('script');
        wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
        '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
        wf.type = 'text/javascript';
        wf.async = 'true';
        var s = document.getElementsByTagName('script')[0];
        s.parentNode.insertBefore(wf, s);
    })();
</script>
<script src="js/jquery.min.js" type="text/javascript"></script>
<!-- common functions -->
<script src={{asset("/js/common.min.js")}}></script>
<!-- uikit functions -->
<script src={{asset("/js/uikit_custom.min.js")}}></script>
<!-- altair common functions/helpers -->
<script src={{asset("/js/altair_admin_common.min.js")}}></script>

<!-- page specific plugins -->
<!-- d3 -->
<script src={{asset("/bower_components/d3/d3.min.js")}}></script>
<!-- metrics graphics (charts) -->
<script src={{asset("/bower_components/metrics-graphics/dist/metricsgraphics.min.js")}}></script>
<!-- chartist (charts) -->
<script src={{asset("/bower_components/chartist/dist/chartist.min.js")}}></script>
<!-- maplace (google maps) -->
<script src={{asset("http://maps.google.com/maps/api/js")}}></script>
<script src={{asset("/bower_components/maplace-js/dist/maplace.min.js")}}></script>
<!-- peity (small charts) -->
<script src={{asset("/bower_components/peity/jquery.peity.min.js")}}></script>
<!-- easy-pie-chart (circular statistics) -->
<script src={{asset("/bower_components/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js")}}></script>
<!-- countUp -->
<script src={{asset("/bower_components/countUp.js/dist/countUp.min.js")}}></script>
<!-- handlebars.js -->
<script src={{asset("/bower_components/handlebars/handlebars.min.js")}}></script>
<script src={{asset("/js/custom/handlebars_helpers.min.js")}}></script>
<!-- CLNDR -->
<script src={{asset("/bower_components/clndr/clndr.min.js")}}></script>
<!-- fitvids -->
{{-- <script src="bower_components/fitvids/jquery.fitvids.js"></script> --}}

<!-- jQuery -->
<script src={{asset("/plugins/jquery/jquery.min.js")}}></script>
<!-- jQuery UI 1.11.4 -->
<script src={{asset("/plugins/jquery-ui/jquery-ui.min.js")}}></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
{{-- <script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script> --}}
<!-- ChartJS -->
<script src="/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src={{asset("/plugins/sparklines/sparkline.js")}}></script>
<!-- JQVMap -->
<script src={{asset("/plugins/jqvmap/jquery.vmap.min.js")}}></script>
<script src={{asset("/plugins/jqvmap/maps/jquery.vmap.usa.js")}}></script>
<!-- jQuery Knob Chart -->
<script src={{asset("/plugins/jquery-knob/jquery.knob.min.js")}}></script>
<!-- daterangepicker -->
<script src={{asset("/plugins/moment/moment.min.js")}}></script>
<script src={{asset("/plugins/daterangepicker/daterangepicker.js")}}></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src={{asset("/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js")}}></script>
<!-- Summernote -->
<script src={{asset("/plugins/summernote/summernote-bs4.min.js")}}></script>
<!-- overlayScrollbars -->
<script src={{asset("/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js")}}></script>
<!-- AdminLTE App -->
<script src={{asset("/dist/js/adminlte.js")}}></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src={{asset("/dist/js/pages/dashboard.js")}}></script>
<!-- AdminLTE for demo purposes -->
<script src={{asset("/dist/js/demo.js")}}></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>


<!--  dashbord functions -->
<script src={{asset("/js/pages/dashboard.min.js")}}></script>
 <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
 <script src="/plugins/sweetalert2/sweetalert2.min.js"></script> 
<script>
    $(function() {
        if(isHighDensity) {
            // enable hires images
            altair_helpers.retina_images();
        }
        if(Modernizr.touch) {
            // fastClick (touch devices)
            FastClick.attach(document.body);
        }
    });
    $window.load(function() {
        // ie fixes
        altair_helpers.ie_fix();
    });
</script>
{{-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script> --}}

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  

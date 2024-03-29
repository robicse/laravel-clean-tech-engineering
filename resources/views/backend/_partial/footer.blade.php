<!-- Essential javascripts for application to work-->
<script src="{!! asset('backend/js/jquery-3.2.1.min.js') !!}"></script>
<script src="{!! asset('backend/js/popper.min.js') !!}"></script>
<script src="{!! asset('backend/js/bootstrap.min.js') !!}"></script>
<script src="{!! asset('backend/js/main.js') !!}"></script>
<!-- The javascript plugin to display page loading on top-->
<script src="{!! asset('backend/js/plugins/pace.min.js') !!}"></script>

@yield('footer')
<!-- Page specific javascripts-->
{{--<script type="text/javascript" src="{!! asset('backend/') !!}js/plugins/chart.js"></script>--}}
{{--@section('other')--}}
{{--@show--}}

{{--toastr js--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="{{asset('backend/plugins/datatables/jquery.dataTables.js')}}"></script>
<script src="{{asset('backend/plugins/datatables/dataTables.bootstrap4.js')}}"></script>
{!! Toastr::message() !!}
<script>
    $(function () {
        $("#example1").DataTable();
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false
        });
    });
    @if($errors->any())
    @foreach($errors->all() as $error )
    toastr.error('{{$error}}','Error',{
        closeButton:true,
        progressBar:true
    });
    @endforeach
    @endif
</script>
@stack('js')
{{--toastr js--}}

{{--<script type="text/javascript">--}}
{{--    var data = {--}}
{{--        labels: ["January", "February", "March", "April", "May"],--}}
{{--        datasets: [--}}
{{--            {--}}
{{--                label: "My First dataset",--}}
{{--                fillColor: "rgba(220,220,220,0.2)",--}}
{{--                strokeColor: "rgba(220,220,220,1)",--}}
{{--                pointColor: "rgba(220,220,220,1)",--}}
{{--                pointStrokeColor: "#fff",--}}
{{--                pointHighlightFill: "#fff",--}}
{{--                pointHighlightStroke: "rgba(220,220,220,1)",--}}
{{--                data: [65, 59, 80, 81, 56]--}}
{{--            },--}}
{{--            {--}}
{{--                label: "My Second dataset",--}}
{{--                fillColor: "rgba(151,187,205,0.2)",--}}
{{--                strokeColor: "rgba(151,187,205,1)",--}}
{{--                pointColor: "rgba(151,187,205,1)",--}}
{{--                pointStrokeColor: "#fff",--}}
{{--                pointHighlightFill: "#fff",--}}
{{--                pointHighlightStroke: "rgba(151,187,205,1)",--}}
{{--                data: [28, 48, 40, 19, 86]--}}
{{--            }--}}
{{--        ]--}}
{{--    };--}}
{{--    var pdata = [--}}
{{--        {--}}
{{--            value: 300,--}}
{{--            color: "#46BFBD",--}}
{{--            highlight: "#5AD3D1",--}}
{{--            label: "Complete"--}}
{{--        },--}}
{{--        {--}}
{{--            value: 50,--}}
{{--            color:"#F7464A",--}}
{{--            highlight: "#FF5A5E",--}}
{{--            label: "In-Progress"--}}
{{--        }--}}
{{--    ];--}}

{{--    var ctxl = $("#lineChartDemo").get(0).getContext("2d");--}}
{{--    var lineChart = new Chart(ctxl).Line(data);--}}

{{--    var ctxp = $("#pieChartDemo").get(0).getContext("2d");--}}
{{--    var pieChart = new Chart(ctxp).Pie(pdata);--}}
{{--</script>--}}
{{--<!-- Google analytics script-->--}}
{{--<script type="text/javascript">--}}
{{--    if(document.location.hostname == 'pratikborsadiya.in') {--}}
{{--        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){--}}
{{--            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),--}}
{{--            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)--}}
{{--        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');--}}
{{--        ga('create', 'UA-72504830-1', 'auto');--}}
{{--        ga('send', 'pageview');--}}
{{--    }--}}
{{--</script>--}}

<!-- select2-->
<script src="{{asset('backend/plugins/select2/select2.full.min.js')}}"></script>

<!--Date-Picker JS-->
{{-- <script src="{{asset('backend/js/bootstrap-datepicker.js')}}"></script> --}}
<script type="text/javascript">
    $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        //startDate: '-3d'
    });
</script>
</body>
</html>

@extends('layouts.admin_index')

@section('title')
    Expense Reports
@stop



@section('bottom_css')
    <style>
        .tab-content>.tab-pane {
            display: block;
            height: 0;
            overflow: hidden;
        }
        .tab-content>.tab-pane.active {
            height: auto;
        }
    </style>
@stop




@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Expense Summary</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Expense Summary</a></li>
            </ol>
        </section>
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <!-- Custom Tabs -->
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_1" data-toggle="tab">Area Chart</a></li>
                            <li><a href="#tab_2" data-toggle="tab">Line Chart</a></li>
                            <li><a href="#tab_3" data-toggle="tab">Bar Chart</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="years" style="overflow: hidden">
                                {!! Form::open(['url' => 'reports/expense', 'role' => 'form', 'method' => 'GET']) !!}
                                <div class="pull-right">
                                    {!! Form::select('year', $years, request('year', \Carbon\Carbon::now()->year), ['class' => 'form-control input-filter input-sm', 'onchange' => 'this.form.submit()']) !!}
                                </div>
                                {!! Form::close() !!}
                            </div>
                            <div class="tab-pane active" id="tab_1">


                                <!-- AREA CHART -->
                                <div class="box-body">
                                    <div class="chart">
                                        <canvas id="areaChart" style="height:250px"></canvas>
                                    </div>
                                </div>
                                <!-- /.box-body -->

                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane fade" id="tab_2">
                                <div class="box-body">
                                    <div class="chart">
                                        <canvas id="lineChart" style="height:250px"></canvas>
                                    </div>
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane fade" id="tab_3">
                                <div class="box-body">
                                    <div class="chart">
                                        <canvas id="barChart" style="height:230px"></canvas>
                                    </div>
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div>
                    <!-- nav-tabs-custom -->
                    <div class="table table-responsive">
                        <table class="table table-bordered table-striped table-hover" id="tbl-report-incomes">
                            <thead>
                            <tr>
                                <th>Category</th>
                                <th class="text-right">January</th>
                                <th class="text-right">February</th>
                                <th class="text-right">March</th>
                                <th class="text-right">April</th>
                                <th class="text-right">May</th>
                                <th class="text-right">June</th>
                                <th class="text-right">July</th>
                                <th class="text-right">August</th>
                                <th class="text-right">September</th>
                                <th class="text-right">October</th>
                                <th class="text-right">November</th>
                                <th class="text-right">December</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Expenses</td>
                                @if($monthly_expense)
                                    @foreach($monthly_expense as $expense)
                                        <td class="text-right">৳ {{ $expense }}</td>
                                    @endforeach
                                @endif
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col (LEFT) -->
            </div>
            <!-- /.row -->

        </section>
        <!-- /.content -->
    </div>
@stop

@section('javascript')
    <script>
        $(function () {
            /* ChartJS
             * -------
             * Here we will create a few charts using ChartJS
             */

            //--------------
            //- AREA CHART -
            //--------------

            // Get context with jQuery - using jQuery's .get() method.
            var areaChartCanvas = $('#areaChart').get(0).getContext('2d')
            // This will get the first returned node in the jQuery collection.
            var areaChart = new Chart(areaChartCanvas)

            var areaChartData = {
                labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [
                    {
                        label: 'Expense',
                        fillColor: "#F56954",
                        strokeColor: "#F56954",
                        pointColor: "#F56954",
                        pointStrokeColor: "#F56954",
                        pointHighlightFill: "#FFF",
                        pointHighlightStroke: "#F56954",
                        data: [
                            @foreach($monthly_expense as $expense)
                            {{ $expense }},
                            @endforeach
                        ]
                    }
                ]
            }

            var areaChartOptions = {
                //Boolean - If we should show the scale at all
                showScale: true,
                //Boolean - Whether grid lines are shown across the chart
                scaleShowGridLines: false,
                //String - Colour of the grid lines
                scaleGridLineColor: 'rgba(0,0,0,.05)',
                //Number - Width of the grid lines
                scaleGridLineWidth: 1,
                //Boolean - Whether to show horizontal lines (except X axis)
                scaleShowHorizontalLines: true,
                //Boolean - Whether to show vertical lines (except Y axis)
                scaleShowVerticalLines: true,
                //Boolean - Whether the line is curved between points
                bezierCurve: true,
                //Number - Tension of the bezier curve between points
                bezierCurveTension: 0.3,
                //Boolean - Whether to show a dot for each point
                pointDot: false,
                //Number - Radius of each point dot in pixels
                pointDotRadius: 4,
                //Number - Pixel width of point dot stroke
                pointDotStrokeWidth: 1,
                //Number - amount extra to add to the radius to cater for hit detection outside the drawn point
                pointHitDetectionRadius: 20,
                //Boolean - Whether to show a stroke for datasets
                datasetStroke: true,
                //Number - Pixel width of dataset stroke
                datasetStrokeWidth: 2,
                //Boolean - Whether to fill the dataset with a color
                datasetFill: true,
                //String - A legend template
                legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].lineColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
                //Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
                maintainAspectRatio: true,
                //Boolean - whether to make the chart responsive to window resizing
                responsive: true
            }

            //Create the line chart
            areaChart.Line(areaChartData, areaChartOptions)

            //-------------
            //- LINE CHART -
            //--------------
            var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
            var lineChart = new Chart(lineChartCanvas)
            var lineChartOptions = areaChartOptions
            lineChartOptions.datasetFill = false
            lineChart.Line(areaChartData, lineChartOptions)



            //-------------
            //- BAR CHART -
            //-------------
            var barChartCanvas = $('#barChart').get(0).getContext('2d')
            var barChart = new Chart(barChartCanvas)

            var barChartData = areaChartData
            var barChartOptions = {
                //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
                scaleBeginAtZero: true,
                //Boolean - Whether grid lines are shown across the chart
                scaleShowGridLines: true,
                //String - Colour of the grid lines
                scaleGridLineColor: 'rgba(0,0,0,.05)',
                //Number - Width of the grid lines
                scaleGridLineWidth: 1,
                //Boolean - Whether to show horizontal lines (except X axis)
                scaleShowHorizontalLines: true,
                //Boolean - Whether to show vertical lines (except Y axis)
                scaleShowVerticalLines: true,
                //Boolean - If there is a stroke on each bar
                barShowStroke: true,
                //Number - Pixel width of the bar stroke
                barStrokeWidth: 2,
                //Number - Spacing between each of the X value sets
                barValueSpacing: 5,
                //Number - Spacing between data sets within X values
                barDatasetSpacing: 1,
                //String - A legend template
                legendTemplate: '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<datasets.length; i++){%><li><span style="background-color:<%=datasets[i].fillColor%>"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>',
                //Boolean - whether to make the chart responsive
                responsive: true,
                maintainAspectRatio: true
            }

            barChartOptions.datasetFill = false
            barChart.Bar(barChartData, barChartOptions)
        })
    </script>
@stop



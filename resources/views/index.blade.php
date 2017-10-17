@extends('layouts.admin_index')

@section('title')
    Dashboard
@endsection

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Dashboard
                <small>Version 1.0</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Dashboard</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Main row -->
            <div class="row">
                <!-- Left col -->
                <div class="col-md-8">


                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h3 class="box-title">Branded Product Sell</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="chart-responsive">
                                        <canvas id="pieChart" height="150"></canvas>
                                    </div>
                                    <!-- ./chart-responsive -->
                                </div>
                                <!-- /.col -->
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.box-body -->
                    </div>

                    @if($latest_sales)
                    <!-- TABLE: LATEST ORDERS -->
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Latest Orders</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table no-margin">
                                    <thead>
                                    <tr>
                                        <th>Invoice No</th>
                                        <th>Item</th>
                                        <th>Customer Name</th>
                                        <th>Total Amount</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($latest_sales as $latest_sale)
                                        <tr>
                                            <td>{{ $latest_sale->invoice_no }}</td>
                                            <td>
                                                @if($latest_sale->stock)
                                                    @if($latest_sale->stock->product)
                                                        {{ $latest_sale->stock->product->name }}
                                                    @endif
                                                @else -- @endif</td>
                                            <td>{{ $latest_sale->customer->name }}</td>
                                            <td>{{ $latest_sale->total_amount }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer clearfix">
                            <a href="{{ route('sells.index') }}" class="btn btn-sm btn-default btn-flat
                            pull-right">View All</a>
                        </div>
                        <!-- /.box-footer -->
                    </div>
                    <!-- /.box -->
                        @endif
                </div>
                <!-- /.col -->

                <div class="col-md-4">

                    @if($stocks)

                    <!-- PRODUCT LIST -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Recently Added Products Stocks</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <ul class="products-list product-list-in-box">
                                @foreach($stocks as $stock)
                                <li class="item">
                                    <div class="product-img">
									@if($stock->product)
                                        @if($stock->product->photo)
                                            <img class="img-thumbnail product-image" src="{{env('APP_URL')}}{{
                                            $stock->product->photo->photo }}" alt="">
                                        @else
                                            <img src="img/default-50x50.gif" alt="@if($stock->product) {{ $stock->product->name }} @endif">
                                        @endif
									@else
										--
                                    @endif
                                    </div>
                                    <div class="product-info">
                                        <a href="javascript:void(0)" class="product-title">@if($stock->product) {{ $stock->product->name
                                        }} @endif @if($stock->color)({{ $stock->color }}) @endif
                                            <span class="label label-warning pull-right">Tk. {{ $stock->selling_price
                                            }}</span></a>
                                        <span class="product-description">
                                            {{ $stock->stock_left }} in stock
                                        </span>
                                    </div>
                                </li>
                                @endforeach
                                <!-- /.item -->
                            </ul>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer text-center">
                            <a href="{{ route('stocks.index') }}" class="uppercase">View All Products</a>
                        </div>
                        <!-- /.box-footer -->
                    </div>
                    <!-- /.box -->

                        @endif
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection


@section('javascript')
    <script>
        $(function () {

    //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
    var pieChart       = new Chart(pieChartCanvas)
    var PieData        = [
      @if($brand_sell_count)
            @foreach($brand_sell_count as $brand_count)
        {
        value    : '{{ count($brand_count) }}',
        color    : '{{ random_color() }}',
        label    : '<?php
//
                        foreach($brand_count as $name){
                            echo $name->name;
                            break;
                        }?>'
      },
        @endforeach
        @endif
    ]

    var pieOptions     = {
      //Boolean - Whether we should show a stroke on each segment
      segmentShowStroke    : true,
      //String - The colour of each segment stroke
      segmentStrokeColor   : '#fff',
      //Number - The width of each segment stroke
      segmentStrokeWidth   : 2,
      //Number - The percentage of the chart that we cut out of the middle
      percentageInnerCutout: 50, // This is 0 for Pie charts
      //Number - Amount of animation steps
      animationSteps       : 100,
      //String - Animation easing effect
      animationEasing      : 'easeOutBounce',
      //Boolean - Whether we animate the rotation of the Doughnut
      animateRotate        : true,
      //Boolean - Whether we animate scaling the Doughnut from the centre
      animateScale         : false,
      //Boolean - whether to make the chart responsive to window resizing
      responsive           : true,
      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio  : true,
      //String - A legend template
      legendTemplate       : '<ul class="<%=name.toLowerCase()%>-legend"><% for (var i=0; i<segments.length; i++){%><li><span style="background-color:<%=segments[i].fillColor%>"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>'
    }
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    pieChart.Doughnut(PieData, pieOptions)
  })
</script>
@stop
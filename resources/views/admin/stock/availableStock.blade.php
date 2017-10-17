@extends('layouts.admin_index')

@section('title')
    Available Stocks
@stop


@section('top_css')

    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('libs/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
@stop



@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Available Stocks</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Available Stocks</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                @if($total_amount)
                    <div class="col-lg-4 col-xs-6">
                        <!-- small box -->
                        <div class="small-box bg-red">
                            <div class="inner">
                                <h3>{{ $total_amount }} Tk</h3>

                                <p>Total Amount of Stock</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">All Stocks</h3>
                        </div>

                        @if(session('success'))
                            <div class="box-body">
                                <div class="alert alert-success">
                                    <p>{{session('success')}}</p>
                                </div>
                            </div>
                        @endif



                        @if($stocks)
                        <!-- /.box-header -->

                            <div class="box-body category_table">
                                <table id="data_stock" class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Stock ID</th>
										<th style="width: 150px">Image</th>
                                        <th>Name</th>
                                        <th>IMEIS</th>
                                        <th>Color</th>
                                        <th>Available</th>
                                        <th>Brand</th>
                                        <th>Category</th>
                                        <th>Buying Price</th>
                                        <th>Selling Price</th>
                                        <th>Profit</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    <?php $i= 0;?>
                                    @foreach($stocks as $stock)
                                        <?php $i++ ;?>
                                        <tr @if($stock->stock_left == null) style="background-color: #ddd" @endif>
                                            <td>{{ $i }}</td>

                                            <td>#{{ $stock->stockin_id }}</td>
											
                                            <td>
												@if($stock->product)
													@if($stock->product->photo)
														<img class="img-thumbnail product-image" src="{{ $stock->product->photo->photo }}" alt="">
													@else
														No Image
													@endif
												@else
													No Image
												@endif
                                            </td>
                                            <td>
												
                                               @if($stock->product)
                                                    {{ $stock->product->name }}
                                                @else -- @endif
											</td>
                                            <td><a href="{{ route('stock.imeis', $stock->id) }}">IMEIS</a></td>
                                            <td>@if($stock->color) {{ $stock->color }} @else -- @endif</td>
                                            <td>{{ $stock->stock_left }}</td>
                                            <td>
											
                                               @if($stock->product)
												@if($stock->product->brand)
													{{ $stock->product->brand->name }}
												@else -- @endif
                                               @else -- @endif
											</td>
                                            <td>
                                                @if($stock->product)
                                                    @if($stock->product->category)
                                                        {{ $stock->product->category->name }}
                                                    @else -- @endif
                                                @else -- @endif</td>
                                            <td>{{ $stock->buying_price }}</td>
                                            <td>{{ $stock->selling_price }}</td>
                                            <td>{{ $stock->selling_price - $stock->buying_price }}</td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        @endif
                    <!-- /.box-body -->

                    </div>
                </div>
            </div>
            <!-- /.row -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@stop


@section('top_javascript')
    <!-- DataTables -->
    <script src="{{asset('libs/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('libs/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
@stop

@section('javascript')
    <script>
        $(function () {
            $('#data_stock').DataTable()
        })
    </script>
@stop

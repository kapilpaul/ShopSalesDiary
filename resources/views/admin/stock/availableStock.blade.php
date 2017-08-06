@extends('layouts.admin_index')

@section('title')
    Available Stocks
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

                            <div class="box-body no-padding category_table">
                                <table class="table table-striped">
                                    <tbody>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Stock ID</th>
                                        <th>Name</th>
                                        <th>Color</th>
                                        <th>Available</th>
                                        <th>Brand</th>
                                        <th>Category</th>
                                    </tr>

                                    <?php $i= 0;?>
                                    @foreach($stocks as $stock)
                                        <?php $i++ ;?>
                                        <tr @if($stock->stock_left == null) style="background-color: #ddd" @endif>
                                            <td>{{ $i }}</td>

                                            <td>MGSE-{{ $stock->stockin_id }}</td>
                                            <td>{{ $stock->product->name }}</td>
                                            <td>{{ $stock->color }}</td>
                                            <td>{{ $stock->stock_left }}</td>
                                            <td>{{ $stock->product->brand->name }}</td>
                                            <td>{{ $stock->product->category->name }}</td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        @endif
                    <!-- /.box-body -->
                        @if($page_count > 0)
                            {{ $stocks->links('layouts.pagination') }}
                        @endif


                    </div>
                </div>
            </div>
            <!-- /.row -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@stop

@extends('layouts.admin_index')

@section('title')
    IMEIS
@stop


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>IMEIS</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Stocks</a></li>
                <li><a href="#">IMEIS</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">

                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">IMEI No in Stock
                            </h3>
                        </div>

                        @if(session('success'))
                            <div class="box-body">
                                <div class="alert alert-success">
                                    <p>{{session('success')}}</p>
                                </div>
                            </div>
                        @endif

                        @if($imeis)
                        <!-- /.box-header -->

                            <div class="box-body no-padding category_table">
                                <table class="table table-striped">
                                    <tbody>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Stock ID</th>
                                        <th>IMEI</th>
                                        <th>Color</th>
                                        <th>Product Name</th>
                                        <th>Brand</th>
                                        <th style="width: 20px">Edit</th>
                                        <th style="width: 20px">Delete</th>
                                    </tr>

                                    <?php $i= 0;?>
                                    @foreach($imeis as $imei)
                                        <?php $i++ ;?>
                                        <tr @if($imei->sold == 1) style="color: #d33724" @endif>
                                            <td>{{ $i }}</td>


                                            <td>MGSE-{{ $imei->stock->stockin_id }}</td>

                                            <td>{{ $imei->imei }} @if($imei->sold == 1)<i class="fa fa-times-circle-o" aria-hidden="true"></i>@endif</td>
                                            <td>{{ $imei->stock->color }}</td>
                                            <td>{{ $imei->stock->product->name }}</td>
                                            <td>{{ $imei->stock->product->brand->name }}</td>

                                            <td>
                                                <a href="{{ route('imei.edit', $imei->id) }}">
                                                    <p class="no_bottom_margin" data-placement="top" data-toggle="tooltip" title=""
                                                       data-original-title="Edit">

                                                        <button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit">
                                                            <span class="glyphicon glyphicon-pencil"></span>
                                                        </button>

                                                    </p></a>
                                            </td>

                                            <td>


                                                {!! Form::open(['method' => 'DELETE', 'class' =>'user_delete pull-left', 'action' => ['StockController@destroy', $imei->id]]) !!}
                                                <p class="no_bottom_margin" data-placement="top" data-toggle="tooltip" title="" data-original-title="Delete">
                                                    <button onclick="alert('Are You Sure You Want To Delete')" class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete">
                                                        <span class="glyphicon glyphicon-trash"></span>
                                                    </button>
                                                </p>
                                                {!! Form::close() !!}
                                            </td>
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

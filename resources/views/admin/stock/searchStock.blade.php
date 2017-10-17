@extends('layouts.admin_index')

@section('title')
    Search Stocks
@stop


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Search Stocks</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Search Stocks</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">

                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Search Stocks</h3>
                            <div class="box-tools">

                                {!! Form::open(['method' => 'GET', 'action' => 'StockController@postDataSearch']) !!}
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    {!! Form::text('table_search', null, ['class'=>'form-control  pull-right', 'placeholder' => 'Search']) !!}
                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                                {!! Form::close() !!}
                            </div>
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
                                        <th style="width: 70px">Date</th>
                                        <th>Stock ID</th>
                                        <th style="width: 150px">Image</th>
                                        <th>Name</th>
                                        <th>Color</th>
                                        <th>Quantity</th>
                                        <th>IMEIS</th>
                                        <th>Brand</th>
                                        <th>Category</th>
                                        <th>Buying Price</th>
                                        <th>Selling Price</th>
                                        <th>Profit</th>
                                        <th>Paid</th>
                                        <th>Due</th>
                                        <th>Short List</th>
                                        <th>Stock Added By</th>
                                        <th style="width: 20px">Edit</th>
                                        <th style="width: 20px">Delete</th>
                                    </tr>

                                    <?php $i= 0; ?>
                                    @foreach($stocks as $stock)
                                        <?php $i++ ;?>
                                        <tr @if($stock->stock_left == null) style="background-color: #ddd" @endif>
                                            <td>{{ $i }}</td>

                                            <td>{{ Carbon\Carbon::parse($stock->created_at)->format('d-m-y h:i A')}}</td>
                                            <td>MGSE-{{ $stock->stockin_id }}</td>
                                            <td>
                                                @if($stock->product)
                                                    @if($stock->product->photo)
                                                        <img class="img-thumbnail product-image" src="{{ $stock->product->photo->photo }}" alt="">
                                                    @else
                                                        No Image
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                @if($stock->product)
                                                    {{ $stock->product->name }}
                                                @else -- @endif
                                            </td>
                                            <td>{{ $stock->color }}</td>
                                            <td>{{ $stock->quantity }}</td>
                                            <td><a href="{{ route('stock.imeis', $stock->id) }}">IMEIS </a></td>
                                            <td>
                                                @if($stock->product)
                                                    @if($stock->product->brand)
                                                        {{ $stock->product->brand->name }}
                                                    @else -- @endif
                                                @else -- @endif
                                            </td>
                                            <td>
                                                @if($stock->product)
                                                    {{ $stock->product->category->name }}
                                                @else -- @endif
                                            </td>
                                            <td>{{ $stock->buying_price }}</td>
                                            <td>{{ $stock->selling_price }}</td>
                                            <td>{{ $stock->selling_price - $stock->buying_price }}</td>
                                            <td>{{ $stock->paid }}</td>
                                            <td>{{ $stock->due }}</td>
                                            <td>@if($stock->short_list) {{ $stock->short_list }} @else -- @endif</td>
                                            <td>{{ $stock->user->name }}</td>

                                            <td>
                                                <a href="{{ route('stocks.edit', $stock->id) }}">
                                                    <p class="no_bottom_margin" data-placement="top" data-toggle="tooltip" title=""
                                                       data-original-title="Edit">

                                                        <button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit">
                                                            <span class="glyphicon glyphicon-pencil"></span>
                                                        </button>

                                                    </p></a>
                                            </td>

                                            <td>


                                                {!! Form::open(['method' => 'DELETE', 'class' =>'user_delete pull-left', 'action' => ['StockController@destroy', $stock->id]]) !!}
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

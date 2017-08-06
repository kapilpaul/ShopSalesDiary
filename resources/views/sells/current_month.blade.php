@extends('layouts.admin_index')

@section('title')
    Current Month Sells
@stop


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Current Month Sells</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Current Month Sells</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">

                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Current Month Sells</h3>
                        </div>

                        @if(session('success'))
                            <div class="box-body">
                                <div class="alert alert-success">
                                    <p>{{session('success')}}</p>
                                </div>
                            </div>
                        @endif

                        @if($sells)
                        <!-- /.box-header -->


                            <div class="box-body no-padding category_table">

                                <div class="col-lg-3 col-xs-6">
                                    <!-- small box -->
                                    <div class="small-box bg-aqua">
                                        <div class="inner">
                                            <h3>{{ count($sells) }}</h3>

                                            <p>Sales</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-shopping-cart"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-xs-6">
                                    <!-- small box -->
                                    <div class="small-box bg-yellow">
                                        <div class="inner">
                                            <h3>{{ $customers }}</h3>

                                            <p>New Customers</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-person-add"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-xs-6">
                                    <!-- small box -->
                                    <div class="small-box bg-red">
                                        <div class="inner">
                                            <h3>{{ $sum_amount }} Tk</h3>

                                            <p>Total Amount of Sell</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-pie-graph"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 col-xs-6">
                                    <!-- small box -->
                                    <div class="small-box bg-green">
                                        <div class="inner">
                                            <h3>{{ $sum_amount - $profit_buying_price }}</h3>

                                            <p>Tk Profit</p>
                                        </div>
                                        <div class="icon">
                                            <i class="ion ion-stats-bars"></i>
                                        </div>
                                    </div>
                                </div>


                                <table class="table table-striped">
                                    <tbody>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Date</th>
                                        <th>Invoice No</th>
                                        <th>Stock</th>
                                        <th>Customer Name</th>
                                        <th>Product Name</th>
                                        <th>Color</th>
                                        <th>Code</th>
                                        <th>Qty</th>
                                        <th>Discount</th>
                                        <th>Total Amount</th>
                                        <th>Gifts</th>
                                        <th>Sold By</th>
                                        <th style="width: 20px">Edit</th>
                                        <th style="width: 20px">Delete</th>
                                    </tr>

                                    <?php $i= 0;?>
                                    @foreach($sells as $sell)
                                        <?php $i++ ;?>
                                        <tr>
                                            <td>{{ $i }}</td>

                                            <td>
                                                @if(\Carbon\Carbon::parse($sell->created_at)->format('d M Y') == \Carbon\Carbon::now()->format('d M Y'))
                                                    {{ \Carbon\Carbon::parse($sell->created_at)->diffForHumans() }}
                                                @else
                                                    {{ \Carbon\Carbon::parse($sell->created_at)->format('d M Y') }}
                                                @endif
                                            </td>
                                            <td>MGSIT-{{ $sell->invoice_no }}</td>
                                            <td>MGSE-{{ $sell->stock->stockin_id }}</td>
                                            <td>{{ $sell->customer->name }}</td>
                                            <td>{{ $sell->stock->product->name }}</td>
                                            <td>{{ $sell->stock->color }}</td>
                                            <td>
                                                @if($sell->product_code)
                                                    {{ $sell->product_code }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>{{ $sell->quantity }}</td>
                                            <td>{{ $sell->discount }}</td>
                                            <td>{{ $sell->total_amount }}</td>
                                            <td>
                                                @if($sell->gifts)
                                                    {{ $sell->gifts }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>{{ $sell->user->name }}</td>

                                            <td>
                                                <a href="">
                                                    <p class="no_bottom_margin" data-placement="top" data-toggle="tooltip" title=""
                                                       data-original-title="Edit">

                                                        <button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit">
                                                            <span class="glyphicon glyphicon-pencil"></span>
                                                        </button>

                                                    </p></a>
                                            </td>

                                            <td>


                                                {!! Form::open(['method' => 'DELETE', 'class' =>'user_delete pull-left', 'action' => ['SellsController@destroy', $sell->id]]) !!}
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
                        @if($page_count > 0)
                            {{ $sell->links('layouts.pagination') }}
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

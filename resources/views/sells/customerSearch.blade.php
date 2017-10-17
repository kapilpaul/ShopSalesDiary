@extends('layouts.admin_index')

@section('title')
    Search
@stop


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Sells</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Search</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">

                @if(session('success'))
                    <div class="box-body">
                        <div class="alert alert-success">
                            <p>{{session('success')}}</p>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="box-body">
                        <div class="alert alert-error">
                            <p>{{session('error')}}</p>
                        </div>
                    </div>
                @endif

                    @if($phone_No)
                    <div class="col-md-4">
                        <!-- Widget: user widget style 1 -->
                        <div class="box box-widget widget-user-2">
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="widget-user-header bg-yellow">
                                <!-- /.widget-user-image -->
                                <h3 class="widget-user-username" style="margin-left: 0">{{ $phone_No->name }}</h3>
                                <h5 class="widget-user-desc" style="margin-left: 0">{{ $phone_No->phone_no }}</h5>
                                @if($phone_No->email)
                                <h5 class="widget-user-desc" style="margin-left: 0">{{ $phone_No->email }}</h5>
                                    @endif
                            </div>
                            <div class="box-footer no-padding">
                                <ul class="nav nav-stacked">
                                    <li><a href="#">Products <span class="pull-right badge bg-blue">{{
                                        count($phone_No->sell)
                                    }}</span></a></li>
                                    <li><a href="#">Total Spent <span class="pull-right badge
                                    bg-aqua">{{ $total_spent }}</span></a></li>
                                </ul>
                            </div>
                        </div>
                        <!-- /.widget-user -->
                    </div>
                    @elseif($invoiceNos)
                        <div class="col-md-4">
                            <!-- Widget: user widget style 1 -->
                            <div class="box box-widget widget-user-2">
                                <!-- Add the bg color to the header using any of the bg-* classes -->
                                <div class="widget-user-header bg-yellow">
                                    <!-- /.widget-user-image -->
                                    <h3 class="widget-user-username" style="margin-left: 0">{{ $customerNameNo->customer->name }}</h3>
                                    <h5 class="widget-user-desc" style="margin-left: 0">{{ $customerNameNo->customer->phone_no }}</h5>
                                    @if($customerNameNo->customer->email)
                                        <h5 class="widget-user-desc" style="margin-left: 0">{{ $customerNameNo->customer->email }}</h5>
                                    @endif
                                </div>
                                <div class="box-footer no-padding">
                                    <ul class="nav nav-stacked">
                                        <li><a href="#">Products <span class="pull-right badge bg-blue">{{ count($sells) }}</span></a></li>
                                        <li><a href="#">Total Spent <span class="pull-right badge bg-aqua">{{ $total_spent }}</span></a></li>
                                    </ul>
                                </div>
                            </div>
                            <!-- /.widget-user -->
                        </div>

                    @foreach($invoiceNos as $invoiceNo)

                        <div class="col-md-4">
                            <!-- Widget: user widget style 1 -->
                            <div class="box box-widget widget-user-2">
                                <!-- Add the bg color to the header using any of the bg-* classes -->
                                <div class="widget-user-header bg-aqua">
                                    <!-- /.widget-user-image -->
                                    <h3 class="widget-user-username" style="margin-left: 0">@if($invoiceNo->stock) {{ $invoiceNo->stock->product->name }} @else -- @endif</h3>
                                    <h5 class="widget-user-desc" style="margin-left: 0">@if($invoiceNo->stock) {{
                                    $invoiceNo->stock->color }} @else -- @endif</h5>
                                        <h5 class="widget-user-desc" style="margin-left: 0">MGSIT-{{ $invoiceNo->invoice_no }}</h5>
                                </div>
                                <div class="box-footer no-padding">
                                    <ul class="nav nav-stacked">
                                        <li>
                                            <a href="#">Product Code
                                            <span class="pull-right">
                                                @if($invoiceNo->imei)
                                                    {{ $invoiceNo->imei->imei }}
                                                @else
                                                    --
                                                @endif
                                            </span></a>
                                        </li>
                                        <li>
                                            <a href="#">Stock
                                            <span class="pull-right">
                                                @if($invoiceNo->stock) MGSE-{{ $invoiceNo->stock->stockin_id }} @else -- @endif
                                            </span></a>
                                        </li>
                                        <li>
                                            <a href="#">Quantity
                                            <span class="pull-right">
                                                {{ $invoiceNo->quantity }}
                                            </span></a>
                                        </li>
                                        <li>
                                            <a href="#">Discount
                                            <span class="pull-right">
                                                {{ $invoiceNo->discount }}
                                            </span></a>
                                        </li>
                                        <li>
                                            <a href="#">Total Amount
                                            <span class="pull-right">
                                                {{ $invoiceNo->total_amount }}
                                            </span></a>
                                        </li>
                                        <li>
                                            <a href="#">Gifts
                                            <span class="pull-right">
                                                @if($invoiceNo->gifts)
                                                    {{ $invoiceNo->gifts }}
                                                @else
                                                    N/A
                                                @endif
                                            </span></a>
                                        </li>
                                        <li>
                                            <a href="#">Sold By
                                            <span class="pull-right">
                                                {{ $invoiceNo->user->name }}
                                            </span></a>
                                        </li>
                                        <li>
                                            <a href="#">Date <span class="pull-right badge
                                    bg-aqua">
                                                    @if(\Carbon\Carbon::parse($invoiceNo->created_at)->format('d M Y') == \Carbon\Carbon::now()->format('d M Y'))
                                                        {{ \Carbon\Carbon::parse($invoiceNo->created_at)->diffForHumans() }}
                                                    @else
                                                        {{ \Carbon\Carbon::parse($invoiceNo->created_at)->format('d M Y') }}
                                                    @endif
                                                </span>
                                            </a>
                                        </li>
                                        <li style="padding: 10px;margin-bottom: 35px;">


                                            {!! Form::open(['method' => 'DELETE', 'class' =>'user_delete pull-left', 'action' => ['SellsController@destroy', $invoiceNo->id]]) !!}

                                                {!! Form::submit('Delete', ['class' => 'btn btn-danger pull-right',
                                                'onclick' => 'alert("Are You Sure!!!")']) !!}

                                            {!! Form::close() !!}

                                            <a href="{{ route('sells.edit', $invoiceNo->id) }}" class="btn btn-info pull-right
                                            btn_remove_style">Edit</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <!-- /.widget-user -->
                        </div>
                        @endforeach
                        @endif

                    @if($phone_No)
                        <div class="col-md-12">
                            <div class="box box-info">
                                <div class="box-header with-border">
                                    <h3 class="box-title">{{ $phone_No->name }}'s Transaction Data</h3>
                                </div>


                                <!-- /.box-header -->

                                <div class="box-body no-padding category_table">
                                    <table class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <th style="width: 10px">#</th>
                                                <th>Date</th>
                                                <th>Invoice No</th>
                                                <th>Stock</th>
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
                                                <td>{{ $sell->invoice_no }}</td>
                                                <td>@if($sell->stock)MGSE-{{ $sell->stock->stockin_id }} @else --
                                                    @endif</td>

                                                <td>{{ $sell->customer->name }}</td>

                                                <td>@if($sell->stock) {{ $sell->stock->product->name }} @else --
                                                    @endif</td>
                                                <td>@if($sell->stock) {{ $sell->stock->color }} @else -- @endif</td>
                                                <td>
                                                    @if($sell->imei)
                                                        {{ $sell->imei->imei }}
                                                    @else
                                                        --
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
                                <!-- /.box-body -->


                            </div>
                        </div>
                    @endif
            </div>
            <!-- /.row -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@stop

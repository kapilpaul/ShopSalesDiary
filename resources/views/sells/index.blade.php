@extends('layouts.admin_index')

@section('title')
    Sells
@stop


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Sells</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Sells</a></li>
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

                <div class="col-md-12">

                    <div class="box box-default collapsed-box">
                        <div class="box-header with-border" data-widget="collapse">
                            <h3 class="box-title">Search</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool"><i class="fa fa-plus"></i>
                                </button>
                            </div>
                            <!-- /.box-tools -->
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            {!! Form::open(['method' => 'POST', 'action' => 'SellsController@searchingSells', 'class' => '']) !!}

                                {!! Form::label('Customer Phone No or Invoice No *') !!}
                                <div class="input-group input-group-md">
                                    {!! Form::text('search_no', null, ['class'=>'form-control', 'placeholder' =>
                                    'Customer Phone No or Invoice No']) !!}
                                    <span class="input-group-btn">
                                        {!! Form::submit('Search', ['class'=>'btn btn-info btn-flat']) !!}
                                    </span>
                                </div>
                                @if ($errors->has('search_no'))
                                    <span class="help-block">
                                        <p class="text-red">{{ $errors->first('search_no', 'Please Enter Phone
                                        No/Invoice Number')
                                        }}</p>
                                    </span>
                                @endif

                            {!! Form::close() !!}
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">All Sells</h3>
                        </div>

                        @if($sells)
                        <!-- /.box-header -->

                            <div class="box-body no-padding category_table">
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
                                        <th style="color: #ff2222;">Due</th>
                                        <th>Total Amount</th>
                                        <th>Gifts</th>
                                        <th>Sold By</th>
                                        <th style="width: 20px">Invoice</th>
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

                                            <td>@if($sell->stock)#{{ $sell->stock->stockin_id }} @else --
                                                @endif</td>

                                            <td>{{ $sell->customer->name }}</td>

                                            <td>
                                                @if($sell->stock)
                                                    @if($sell->stock->product)
                                                        {{ $sell->stock->product->name }}
                                                    @else -- @endif
                                                @else -- @endif
                                            </td>
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
                                            <td style="color:#ff2222"><b>{{ $sell->due }}</b></td>
                                            <td>{{ $sell->total_amount }}</td>
                                            <td>
                                                @if($sell->gifts)
                                                    {{ $sell->gifts }}
                                                @else
                                                    --
                                                @endif
                                            </td>
                                            <td>
                                                @if($sell->user)
                                                    {{ $sell->user->name }}
                                                @else
                                                    --
                                                @endif
                                            </td>

                                            <td>
                                                <a href="{{ route('sells.invoice', $sell->invoice_no) }}">
                                                    <p class="no_bottom_margin" data-placement="top" data-toggle="tooltip" title=""
                                                       data-original-title="Invoice">

                                                        <button class="btn btn-primary btn-xs" data-title="Invoice" data-toggle="modal" data-target="#edit">
                                                            <i class="fa fa-print" style="font-size: 17px;"></i>

                                                        </button>

                                                    </p></a>
                                            </td>

                                            <td>
                                                <a href="{{ route('sells.edit', $sell->id) }}">
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
                            {{ $sells->links('layouts.pagination') }}
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

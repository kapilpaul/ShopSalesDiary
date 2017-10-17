@extends('layouts.admin_index')

@section('title')
    Stocks
@stop


@section('top_css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('libs/bower_components/select2/dist/css/select2.min.css')}}">
@stop



@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>New Stocks</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Stocks</a></li>
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
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title pull-left">Add Stock</h3>
                            <h5 class="box-title pull-right">New Stock ID: MGSE-{{ $stockin_id }}</h5>
                        </div>
                        <!-- /.box-header -->

                        @if(count($errors)>0)
                            <div class="col-lg-12">
                                <span class="row help-block">
                                    @foreach($errors->all() as $error)
                                        <div class="col-md-3">
                                        <p class="text-red">* {{ $error }}</p>
                                        </div>
                                    @endforeach
                                </span>
                            </div>
                        @endif



                        {!! Form::open(['method' => 'POST', 'action' => 'StockController@store', 'class' => 'two_col_forms']) !!}

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="box-body">
                                        <div class="form-group">

                                            {!! Form::label('Select Product') !!}

                                            {!! Form::select('product_id', $products, null, ['class'=>'form-control select2', 'placeholder' => 'Pick a Product...' , 'style' => 'width: 100%;']) !!}
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-4">
                                    <div class="box-body no-right-padding">
                                        <div class="form-group has-feedback">
                                            {!! Form::label('Color') !!}
                                            {!! Form::text('color', null, ['id'=>'','class'=>'form-control', 'placeholder' =>  'Color']) !!}

                                            <i class="fa fa-thumb-tack form-control-feedback"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="box-body no-right-padding">
                                        <div class="form-group has-feedback">
                                            {!! Form::label('Buying Price') !!}
                                            {!! Form::text('buying_price', null, ['id'=>'buying_price','class'=>'form-control', 'placeholder' =>  'Buying Price']) !!}

                                            <i class="fa fa-money form-control-feedback"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="box-body no-left-padding">
                                        <div class="form-group has-feedback">
                                            {!! Form::label('Selling Price') !!}
                                            {!! Form::text('selling_price', null, ['class'=>'form-control', 'placeholder' =>  'Selling Price']) !!}

                                            <i class="fa fa-money form-control-feedback"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="box-body no-right-padding">
                                        <div class="form-group has-feedback">
                                            {!! Form::label('Quantity') !!}
                                            {!! Form::text('quantity', null, ['onkeyup'=>"amount_calculation()",'id'=>'quantity','class'=>'form-control', 'placeholder' =>  'Product Quantity']) !!}

                                            <i class="fa fa-clone form-control-feedback"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="box-body no-left-padding no-right-padding">
                                        <div class="form-group has-feedback">
                                            {!! Form::label('amount') !!}
                                            {!! Form::text('amount', null, ['id'=>'amount','class'=>'form-control', 'placeholder' =>  'Amount', 'disabled']) !!}

                                            <i class="fa fa-money form-control-feedback"></i>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-4">
                                    <div class="box-body no-left-padding">
                                        <div class="form-group has-feedback">
                                            {!! Form::label('paid') !!}
                                            {!! Form::text('paid', null, ['onkeyup'=>'due_calculation()', 'id'=>'paid','class'=>'form-control', 'placeholder' =>  'Paid Amount']) !!}

                                            <i class="fa fa-money form-control-feedback"></i>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-3">
                                    <div class="box-body no-right-padding">
                                        <div class="form-group has-feedback">
                                            {!! Form::label('due') !!}
                                            {!! Form::text('due', null, ['id'=>'due','class'=>'form-control', 'placeholder' => 'Due Amount']) !!}

                                            <i class="fa fa-money form-control-feedback"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="box-body no-left-padding no-right-padding">
                                        <div class="form-group has-feedback">
                                            {!! Form::label('waranty (In months)') !!}
                                            {!! Form::text('waranty', 0, ['class'=>'form-control', 'placeholder' => 'waranty (in months)']) !!}

                                            <i class="fa fa-money form-control-feedback"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="box-body no-left-padding no-right-padding">
                                        <div class="form-group has-feedback">
                                            {!! Form::label('Date') !!}
                                            {!! Form::date('date', Carbon\Carbon::now(), ['class'=>'form-control']) !!}

                                            <i class="fa fa-calendar form-control-feedback" ></i>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-lg-3">
                                    <div class="box-body no-left-padding">
                                        <div class="form-group has-feedback">
                                            {!! Form::label('short list') !!}
                                            {!! Form::text('short_list', null, ['id'=>'short_list','class'=>'form-control', 'placeholder' =>  'Short List For Notification']) !!}

                                            <i class="fa fa-money form-control-feedback"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="box-body">
                                        <div class="product_imei">
                                            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#productimei_input" aria-expanded="false" aria-controls="collapseExample">
                                                Input Product IMEI
                                            </button>
                                            <div class="collapse" id="productimei_input" style="margin-top: 10px;">
                                                {!! Form::textarea('imei', null, ['class'=>'form-control', 'rows' => 3,
                                                'placeholder' => 'IMEI']) !!}
                                            </div>
                                        </div>
                                    </div>

                                </div>


                                <div class="col-lg-12">
                                    <div class="box-footer">
                                        {!! Form::reset('Cancel', ['class'=>'btn btn-default']) !!}
                                        {!! Form::submit('Add Stock', ['class'=>'btn btn-info pull-right']) !!}
                                    </div>
                                </div>
                            </div>
                        {!! Form::close() !!}
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
    <!-- Select2 -->
    <script src="{{asset('libs/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
@stop

@section('javascript')
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()
        })
    </script>

    <script>
        function amount_calculation(){
            var buying_price = document.getElementById("buying_price").value;
            var quantity     = document.getElementById("quantity").value;

            var amount = buying_price*quantity;

            document.getElementById('amount').value = amount;
            document.getElementById('due').value = amount;
        };


        function due_calculation(){
            var amount = document.getElementById("amount").value;
            var paid     = document.getElementById("paid").value;

            var due = amount - paid;

            document.getElementById('due').value = due;
        };


    </script>

@stop
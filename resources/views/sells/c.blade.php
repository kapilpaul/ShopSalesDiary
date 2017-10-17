@extends('layouts.admin_index')

@section('title')
    Sell Item
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
            <h1>New Sell</h1>
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
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title pull-left">Sell Item</h3>
                            <h5 class="box-title pull-right">New Sells Invoice No : MGSIT- <?php
                                $invoice_no = str_replace('-','',\Carbon\Carbon::now());
                                $invoice_no = str_replace(' ','',$invoice_no);
                                $invoice_no = str_replace(':','',$invoice_no);
                                echo $invoice_no;
                                ?></h5>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body" id="stock_empty_msg" style="display: none;">
                            <div class="alert alert-error">
                                <p id="stock_empty"></p>
                            </div>
                        </div>

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



                        {!! Form::open(['method' => 'POST', 'action' => 'SellsController@store', 'class' => 'two_col_forms']) !!}
                        <div class="row">

                            @if($phone_no == null)

                                <div class="col-lg-4">
                                    <div class="box-body no-right-padding">
                                        <div class="form-group has-feedback">
                                            {!! Form::label('Customer Name *') !!}
                                            {!! Form::text('name', null, ['class'=>'form-control', 'placeholder' => 'Customer Name']) !!}

                                            <i class="fa fa-thumb-tack form-control-feedback"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="box-body no-right-padding no-left-padding">
                                        <div class="form-group has-feedback">
                                            {!! Form::label('Customer Phone *') !!}
                                            {!! Form::text('phone_no', null, ['class'=>'form-control', 'placeholder' =>
                                            'Customer Phone']) !!}

                                            <i class="fa fa-thumb-tack form-control-feedback"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="box-body no-left-padding">
                                        <div class="form-group has-feedback">
                                            {!! Form::label('Customer Email') !!}
                                            {!! Form::text('email', null, ['class'=>'form-control', 'placeholder' =>
                                            'Customer Email']) !!}

                                            <i class="fa fa-thumb-tack form-control-feedback"></i>
                                        </div>
                                    </div>
                                </div>

                            @else
                                <div class="col-lg-4">
                                    <div class="box-body no-right-padding">
                                        <div class="form-group has-feedback">
                                            {!! Form::label('Customer Name *') !!}
                                            {!! Form::text('name', $phone_no->name, ['class'=>'form-control', 'placeholder' => 'Customer Name', 'readonly']) !!}

                                            <i class="fa fa-thumb-tack form-control-feedback"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="box-body no-right-padding no-left-padding">
                                        <div class="form-group has-feedback">
                                            {!! Form::label('Customer Phone *') !!}
                                            {!! Form::text('phone_no', $phone_no->phone_no, ['class'=>'form-control',
                                            'placeholder' => 'Customer Phone', 'readonly']) !!}

                                            <i class="fa fa-thumb-tack form-control-feedback"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="box-body no-left-padding">
                                        <div class="form-group has-feedback">
                                            {!! Form::label('Customer Email') !!}
                                            {!! Form::text('email', $phone_no->email, ['class'=>'form-control',
                                            'placeholder' => 'Customer Email', 'readonly']) !!}

                                            <i class="fa fa-thumb-tack form-control-feedback"></i>
                                        </div>
                                    </div>
                                </div>
                            @endif


                            <div class="col-md-12">
                                <div class="box-body">
                                    <div class="form-group">

                                        {!! Form::label('Select Product *') !!}


                                        {!! Form::select('stock_id[]', $stocks_item , null, ['id'=>'product_id','class'=>'form-control select2', 'multiple'=>true, 'data-placeholder' => 'Select Product' , 'style' => 'width: 100%;',
                                        ]) !!}
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-4">
                                <div class="box-body no-right-padding">
                                    <div class="form-group has-feedback">
                                        {!! Form::label('Product IMEI') !!}
                                        {!! Form::text('product_code', null, ['id'=>'','class'=>'form-control', 'placeholder' =>  'Product IMEI']) !!}

                                        <i class="fa fa-thumb-tack form-control-feedback"></i>
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-4">
                                <div class="box-body no-right-padding">
                                    <div class="form-group has-feedback">
                                        {!! Form::label('Quantity *') !!}

                                        <?php
                                        $quantity = array();
                                        $i = 0;
                                        for($i=1;$i<=100;$i++){
                                            $quantity[] = $i;
                                        }
                                        ?>

                                        {!! Form::select('quantity[]', $quantity , null, ['id'=>'quantity','onclick' => "quantityWise_calculation();",'class'=>'form-control select2', 'multiple'=>true, 'data-placeholder' => 'Select Quantity' , 'style' => 'width: 100%;',
                                        ]) !!}

                                        <i class="fa fa-clone form-control-feedback"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="box-body no-left-padding">
                                    <div class="form-group has-feedback">
                                        {!! Form::label('selling price') !!}
                                        {!! Form::text('selling_price', null, ['id'=>'selling_price','class'=>'form-control', 'placeholder' =>  'Amount', 'disabled']) !!}

                                        <i class="fa fa-money form-control-feedback"></i>
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="box-body no-right-padding">
                                    <div class="form-group has-feedback">
                                        {!! Form::label('discount') !!}
                                        {!! Form::text('discount', 0, ['id'=>'discount','class'=>'form-control',
                                        'placeholder' => 'Discount', 'onkeyup' => "amount_calculation();"]) !!}

                                        <i class="fa fa-money form-control-feedback"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="box-body no-left-padding">
                                    <div class="form-group has-feedback">
                                        {!! Form::label('gifts') !!}
                                        {!! Form::text('gifts', null, ['class'=>'form-control', 'placeholder' =>
                                        'Gifts']) !!}

                                        <i class="fa fa-gift form-control-feedback"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="box-body text-center">
                                    <h4 class="text-green" style="display: inline-block">Total Amount To Be Paid : </h4>
                                    <h3 class="text-green" style="display: inline-block" id="total_amount"> </h3>
                                </div>
                            </div>


                            <div class="col-lg-12">
                                <div class="box-footer">
                                    {!! Form::reset('Cancel', ['class'=>'btn btn-default']) !!}
                                    {!! Form::submit('Sell Item', ['class'=>'btn btn-info pull-right']) !!}
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
        {{--$(document).ready(function(){--}}
        {{--$(document).on('change', '#product_id', function(){--}}
        {{--var product_id = $(this).val();--}}
        {{--$.ajax({--}}
        {{--type: 'GET',--}}
        {{--url: '{{ route('findsellingprice') }}',--}}
        {{--data: {product_id:product_id},--}}
        {{--success: function (data) {--}}
        {{--if(data){--}}
        {{--document.getElementById('selling_price').value = data['selling_price'];--}}
        {{--document.getElementById('total_amount').innerHTML = data['selling_price'];--}}
        {{--}--}}
        {{--},--}}
        {{--error: function () {--}}
        {{--console.log('error');--}}
        {{--}--}}
        {{--});--}}
        {{--});--}}

        {{--$(document).on('click', '#quantity', function(){--}}
        {{--var quantity = $(this).val();--}}
        {{--var product_id  = document.getElementById("product_id").value;--}}
        {{--console.log(product_id);--}}
        {{--$.ajax({--}}
        {{--type: 'GET',--}}
        {{--url: '{{ route('findsellingprice') }}',--}}
        {{--data: {product_id:product_id},--}}
        {{--success: function (data) {--}}
        {{--var stock_left = data['stock_left'] - quantity;--}}
        {{--if(stock_left < 0){--}}
        {{--document.getElementById('stock_empty').innerHTML = 'Quantity not available in this stock.';--}}

        {{--var stock_empty_msg = document.getElementById('stock_empty_msg');--}}

        {{--$('#stock_empty_msg').slideDown("slow");--}}

        {{--}else{--}}
        {{--var stock_empty_msg = document.getElementById('stock_empty_msg');--}}

        {{--$('#stock_empty_msg').slideUp("slow");--}}
        {{--}--}}
        {{--},--}}
        {{--error: function () {--}}
        {{--console.log('error');--}}
        {{--}--}}
        {{--});--}}
        {{--});--}}
        {{--});--}}

        {{--function quantityWise_calculation(){--}}
        {{--var selling_price = document.getElementById("selling_price").value;--}}
        {{--var quantity     = document.getElementById("quantity").value;--}}

        {{--var total_amount = selling_price * quantity;--}}

        {{--document.getElementById('total_amount').innerHTML = total_amount;--}}
        {{--};--}}

        {{--function amount_calculation(){--}}
        {{--var selling_price = document.getElementById("selling_price").value;--}}
        {{--var discount     = document.getElementById("discount").value;--}}
        {{--var quantity     = document.getElementById("quantity").value;--}}

        {{--var total_amount = selling_price * quantity;--}}
        {{--var after_discount = total_amount - discount;--}}

        {{--document.getElementById('total_amount').innerHTML = after_discount;--}}
        {{--};--}}
    </script>


@stop
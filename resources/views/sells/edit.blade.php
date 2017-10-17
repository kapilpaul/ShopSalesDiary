@extends('layouts.admin_index')

@section('title')
    Edit Item
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
            <h1>Edit Sell</h1>
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
                            <h3 class="box-title pull-left">Edit Sell Item</h3>
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



                        {!! Form::model($sell, ['method' => 'PATCH', 'action' => ['SellsController@update', $sell->id],
                        'class'=>'two_col_forms repeater']) !!}

                        <div class="row">

                            <div class="col-lg-12">
                                <div data-repeater-list="sell_products" class="count_list">
                                    <div class="list_repeat">

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="box-body  no-right-padding">
                                                    <div class="form-group">

                                                        {!! Form::label('Select Product *') !!}


                                                        {!! Form::select('stock_id', $stocks_item, null, ['id'=>'product_id','class'=>'form-control select2', 'placeholder' => 'Pick a Product...' , 'style' => 'width: 100%;']) !!}
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-lg-3">
                                                <div class="box-body no-left-padding no-right-padding">
                                                    <div class="form-group has-feedback">
                                                        {!! Form::label('Product IMEI') !!}
                                                        {!! Form::text('product_code', null, ['id'=>'','class'=>'form-control', 'placeholder' =>  'Product IMEI']) !!}

                                                        <i class="fa fa-thumb-tack form-control-feedback"></i>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-lg-3">
                                                <div class="box-body no-left-padding no-right-padding">
                                                    <div class="form-group has-feedback">
                                                        {!! Form::label('Quantity *') !!}


                                                        {!! Form::text('quantity' , null, ['id'=>'quantity', 'class'=>'form-control', 'placeholder' => 'Quantity' , 'style' => 'width: 100%;',]) !!}

                                                        <i class="fa fa-clone form-control-feedback"></i>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-2">
                                                <div class="box-body no-left-padding">
                                                    <div class="form-group has-feedback">
                                                        {!! Form::label('price') !!}
                                                        {!! Form::text('price', null, ['id'=>'price','class'=>'form-control', 'placeholder' =>  'Amount', 'disabled']) !!}

                                                        <i class="fa fa-money form-control-feedback"></i>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                <div class="box-body no-right-padding">
                                                    <div class="form-group has-feedback">
                                                        {!! Form::label('selling price') !!}
                                                        {!! Form::text('selling_price', $sell->total_amount + $sell->discount, ['id'=>'selling_price','class'=>'form-control', 'placeholder' =>  'Amount']) !!}

                                                        <i class="fa fa-money form-control-feedback"></i>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-2">
                                                <div class="box-body no-left-padding no-right-padding">
                                                    <div class="form-group has-feedback">
                                                        {!! Form::label('discount') !!}
                                                        {!! Form::text('discount', null, ['id'=>'discount',
                                                        'class'=>'form-control','placeholder' => 'Discount']) !!}

                                                        <i class="fa fa-money form-control-feedback"></i>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="box-body no-left-padding no-right-padding">
                                                    <div class="form-group has-feedback">
                                                        {!! Form::label('due') !!}
                                                        {!! Form::text('due', null, ['id'=>'due', 'class'=>'form-control',
'placeholder' => 'Due']) !!}

                                                        <i class="fa fa-money form-control-feedback"></i>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="box-body no-left-padding">
                                                    <div class="form-group has-feedback">
                                                        {!! Form::label('gifts') !!}
                                                        {!! Form::text('gifts', null, ['class'=>'form-control', 'placeholder' =>'Gifts']) !!}

                                                        <i class="fa fa-gift form-control-feedback"></i>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        {{--end of row div--}}

                                    </div>  {{--end of data-repeater-item div--}}
                                </div> {{--end of data-repeater-list div--}}

                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="box-body text-center">
                                            <h4 class="text-green" style="display: inline-block">Total Amount To Be Paid : </h4>
                                            <h3 class="text-green" style="display: inline-block" id="total_amount"> 0</h3>
                                        </div>
                                    </div>


                                    <div class="col-lg-12">
                                        <div class="box-footer">
                                            {!! Form::reset('Cancel', ['class'=>'btn btn-default']) !!}
                                            {!! Form::submit('Update Sell', ['class'=>'btn btn-success pull-right']) !!}
                                        </div>
                                    </div>

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
        $(document).ready(function(){
            $(document).on('change', '#product_id', function(){
                var product_id = $(this).val();


                $.ajax({
                    type: 'GET',
                    url: '{{ route('findsellingprice') }}',
                    data: {product_id:product_id},
                    success: function (data) {
                        if(data){
                            document.getElementById("price").value = data['selling_price'];
                            document.getElementById("selling_price").value = data['selling_price'];

                            doRefresh();
                        }
                    },
                    error: function () {
                        console.log('error');
                    }
                });
            });

            $(document).on('keyup', '#quantity', function(){
                var quantity = $(this).val();
                var name = $(this).attr('name');
                var id_name = name.replace("[quantity]", "");

                var product_id  = document.getElementById("product_id").value;

                doRefresh();

                $.ajax({
                    type: 'GET',
                    url: '{{ route('findsellingprice') }}',
                    data: {product_id:product_id},
                    success: function (data) {
                        var stock_left = data['stock_left'] - quantity;
                        if(stock_left < 0){
                            document.getElementById('stock_empty').innerHTML = 'Quantity not available in Stock ' +
                                'MGSE-'.concat(data['stockin_id']);

                            var stock_empty_msg = document.getElementById('stock_empty_msg');

                            $('#stock_empty_msg').slideDown("slow");

                        }else{
                            var stock_empty_msg = document.getElementById('stock_empty_msg');

                            $('#stock_empty_msg').slideUp("slow");
                        }
                    },
                    error: function () {
                        console.log('error');
                    }
                });
            });

        });

        function doRefresh(){

            var selling_price = parseFloat(document.getElementById("selling_price").value);
            var quantity = parseFloat(document.getElementById("quantity").value);
            var discount = parseFloat(document.getElementById("discount").value);

            var selling_price_quantity = selling_price * quantity;

            sum = selling_price_quantity - discount;

            document.getElementById('total_amount').innerHTML = sum;
        }



    </script>



@stop
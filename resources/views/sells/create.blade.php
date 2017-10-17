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



                        {!! Form::open(['method' => 'POST', 'action' => 'SellsController@store', 'class' => 'two_col_forms repeater']) !!}

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

                            <div class="col-lg-12">
                                <div data-repeater-list="sell_products" class="count_list">
                                    <div data-repeater-item class="list_repeat">

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
                                                        {!! Form::select('product_code', [], null, ['id'=>'imei_id','class'=>'form-control select2', 'placeholder' => 'Pick a IMEI' , 'style' => 'width: 100%;']) !!}

                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-lg-3">
                                                <div class="box-body no-left-padding no-right-padding">
                                                    <div class="form-group has-feedback">
                                                        {!! Form::label('Quantity *') !!}


                                                        {!! Form::text('quantity' , 1, ['id'=>'quantity', 'class'=>'form-control', 'placeholder' => 'Quantity' , 'style' => 'width: 100%;',]) !!}

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
                                                        {!! Form::text('selling_price', null, ['id'=>'selling_price','class'=>'form-control', 'placeholder' =>  'Amount']) !!}

                                                        <i class="fa fa-money form-control-feedback"></i>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-2">
                                                <div class="box-body no-left-padding no-right-padding">
                                                    <div class="form-group has-feedback">
                                                        {!! Form::label('discount') !!}
                                                        {!! Form::text('discount', 0, ['id'=>'discount','class'=>'form-control',
                                                        'placeholder' => 'Discount']) !!}

                                                        <i class="fa fa-money form-control-feedback"></i>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-2">
                                                <div class="box-body no-left-padding no-right-padding">
                                                    <div class="form-group has-feedback">
                                                        {!! Form::label('due') !!}
                                                        {!! Form::text('due', 0, ['id'=>'due', 'class'=>'form-control',
'placeholder' => 'Due']) !!}

                                                        <i class="fa fa-money form-control-feedback"></i>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-3">
                                                <div class="box-body no-left-padding  no-right-padding ">
                                                    <div class="form-group has-feedback">
                                                        {!! Form::label('gifts') !!}
                                                        {!! Form::text('gifts', null, ['class'=>'form-control', 'placeholder' =>'Gifts']) !!}

                                                        <i class="fa fa-gift form-control-feedback"></i>
                                                    </div>
                                                </div>
                                            </div>




                                            <div class="col-lg-1">
                                                <div class="box-body  no-left-padding  repeater_delete_button">
                                                    <input id="delete" data-repeater-delete type="button" class="btn
                                                    btn-danger" value="Delete" />
                                                </div>
                                            </div>

                                        </div>
                                        {{--end of row div--}}

                                    </div>  {{--end of data-repeater-item div--}}
                                </div> {{--end of data-repeater-list div--}}

                                <div class="row">

                                    <div class="col-lg-12">
                                        <div class="box-body">
                                            <input data-repeater-create type="button" class="btn btn-warning pull-right"
                                                   value="Add Products" />
                                        </div>
                                    </div>



                                    <div class="col-lg-12">
                                        <div class="box-body text-center">
                                            <h4 class="text-green" style="display: inline-block">Total Amount To Be Paid : </h4>
                                            <h3 class="text-green" style="display: inline-block" id="total_amount"> 0</h3>
                                        </div>
                                    </div>


                                    <div class="col-lg-12">
                                        <div class="box-footer">
                                            {!! Form::reset('Cancel', ['class'=>'btn btn-default']) !!}
                                            {!! Form::submit('Sell Item', ['class'=>'btn btn-success pull-right']) !!}
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
    <script src="{{asset('libs/bower_components/repeater/jquery.repeater.min.js')}}"></script>
@stop

@section('javascript')
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()
        })

        $(document).ready(function () {
            'use strict';

            $('.repeater').repeater({
                defaultValues: {
                    'quantity': '1',
                    'discount': '0',
                    'due': '0',
                },
                show: function () {
                    $(this).slideDown();
                    $('.select2-container').remove();
                    $('.select2').select2();
                },
                hide: function (deleteElement) {
                    if (confirm('Are you sure you want to delete this element?')) {
                        $(this).slideUp(deleteElement);
                    }
                },
                ready: function (setIndexes) {

                }
            });


        });
    </script>


    <script>
        $(document).ready(function(){
            $(document).on('change', '#product_id', function(){
                var product_id = $(this).val();
                var name = $(this).attr('name');
                var id_name = name.replace("[stock_id]", "");
                var price = id_name.concat("[price]");
                var product_code = id_name.concat("[product_code]");

                var IdloopNo = document.querySelectorAll('.count_list .list_repeat').length;

                var id_find = $('.count_list').find('#imei_id');

                if(id_find.length > 0) {
                    var e = document.getElementById("imei_id");
                    e.id = "imei_id".concat(IdloopNo);
                }



                $.ajax({
                    type: 'GET',
                    url: '{{ route('findsellingprice') }}',
                    data: {product_id:product_id},
                    success: function (data) {
                        if(data){
                            document.getElementsByName(price)[0].value = data[0]['selling_price'];
                            document.getElementsByName(id_name.concat("[selling_price]"))[0].value = data[0]['selling_price'];

                            $('#imei_id'.concat(IdloopNo)).find('option').remove();
                            $('#imei_id'.concat(IdloopNo)).append('<option selected="selected" disabled="disabled" hidden="hidden" value="">Pick a IMEI</option>');
                            $.each(data[1], function(){
                                $("#imei_id".concat(IdloopNo)).append("<option value=" + this.id + ">" + this.imei +"</option>");
                            });

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

                var product_id  = document.getElementsByName(id_name.concat("[stock_id]"))[0].value;

                doRefresh();

                $.ajax({
                    type: 'GET',
                    url: '{{ route('findsellingprice') }}',
                    data: {product_id:product_id},
                    success: function (data) {
                        var stock_left = data[0]['stock_left'] - quantity;
                        if(stock_left < 0){
                            document.getElementById('stock_empty').innerHTML = 'Quantity not available in Stock ' +
                                'MGSE-'.concat(data[0]['stockin_id']);

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



            //discount calculation
            $(document).on('click keyup', '#discount, #selling_price, #delete', function(){
                doRefresh();

            });
        });

        function doRefresh(){
            var loopNo = document.querySelectorAll('.count_list .list_repeat').length;
            var i;
            var sum = 0;

            for(i=0;i<loopNo;i++){

                var selling_price = parseFloat(document.getElementsByName("sell_products[".concat(i).concat("][selling_price]"))[0].value);

                var quantity = parseFloat(document.getElementsByName("sell_products[".concat(i).concat
                ("][quantity]"))[0].value);
                var selling_price_quantity = selling_price * quantity;

                sum = sum + (selling_price_quantity - parseFloat(document.getElementsByName("sell_products[".concat(i).concat("][discount]"))[0].value));

                sum = sum - parseFloat(document.getElementsByName("sell_products[".concat(i).concat("][due]"))[0]
                        .value);

            }

            document.getElementById('total_amount').innerHTML = sum;
        }

        $(function() {
            setInterval(doRefresh, 500);
        });


    </script>



@stop
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Mobile Garden | Invoice</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('libs/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('libs/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('libs/bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('libs/dist/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{asset('libs/dist/css/user_style.css')}}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>
        #invoice_mail{
            margin-top: 15px;
        }
        @media print{
            #invoice_mail{
                display: none !important;
            }
			
			.mobile_company_logo img{
				width: 32px;
				margin-right: 5px;
			}
        }
    </style>

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<!--<body onload="window.print();">-->

<body>
<div class="wrapper">
    <!-- Main content -->

    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">


                @if(session('error'))
                    <div class="alert alert-danger">
                        <p>{{session('error')}}</p>
                    </div>
                @endif
                @if(session('success'))
                    <div class="alert alert-success">
                        <p>{{session('success')}}</p>
                    </div>
                @endif
                
                <h2 class="page-header">
                    <img src="{{asset('img/logo.png')}}" alt="Mobile Garden" style="width: 50px;"> Mobile Garden
                    <small class="pull-right" style="margin-top: 10px;">Date: {{ \Carbon\Carbon::parse($created_at)->format('d/m/Y') }}</small>
                </h2>


            </div>
            <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
                From
                <address>
                    <strong>Mobile Garden</strong><br>
                    Rikabi Bazaar Point<br>
                    Sylhet 3100<br>
                    Phone: 01717-132780 (Shop) <br> 01762-818251 (Sayek)<br>01757244424 (Mitul)<br>
                    Email: mobilegardeninfo@gmail.com
                </address>
            </div>
            <!-- /.col -->
            @if($customer)
            <div class="col-sm-4 invoice-col">
                To
                <address>
                    <strong>{{ $customer->name }}</strong><br>
                    Phone: {{ $customer->phone_no }}<br>
					@if($customer->email)
                    Email: {{ $customer->email }}
					@endif
                </address>
            </div>
            @endif
            <!-- /.col -->
            @if($sells)
            <div class="col-sm-4 invoice-col">
                <b>Invoice # {{ $sells[0]->invoice_no }}</b><br>
            </div>
            @endif
            <!-- /.col -->
        </div>
        <!-- /.row -->


        @if($sells)
        <!-- Table row -->
        <div class="row">
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>QTY</th>
                            <th>Product</th>
                            <th>Serial #</th>
                            <th>Waranty (Months)</th>
                            <th>Gifts</th>
                            <th>Total Amount</th>
                            <th>Due</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sells as $sell)
                        <tr>
                            <td>{{ $sell->quantity }}</td>
                            <td>
                                @if($sell->stock)
                                    @if($sell->stock->product)
                                        {{ $sell->stock->product->name }}
                                        @if($sell->stock->color)
                                            ({{ $sell->stock->color }})
                                        @endif
                                    @else -- @endif
                                @else -- @endif
                            </td>
                            <td>
                                @if($sell->imei)
                                    {{ $sell->imei->imei }}
                                @else
                                    --
                                @endif
                            </td>
                            <td>@if($sell->stock) {{ $sell->stock->waranty }}
                                    @if($sell->stock->waranty)
                                    (Till {{ \Carbon\Carbon::parse($sell->created_at)->addMonths($sell->stock->waranty)->subDay(1)
                                    ->format('d-m-Y') }})
                                        @endif
                                @else -- @endif
                            </td>
                            <td>{{ $sell->gifts }}</td>
                            <td>{{ $sell->total_amount + $sell->discount }}</td>
                            <td>{{ $sell->due }}</td>
                            <td>{{ $sell->total_amount + $sell->discount - $sell->due }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        @endif

        <div class="row">
            <!-- accepted payments column -->
            <div class="col-xs-6">

                <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                    Thanks For Buying Products From Mobile Garden. Your Smile is Our Success.
                </p>
				
				<p><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Like Us On facebook: facebook.com/mobilegarde</p>
				<p><i class="fa fa-facebook" aria-hidden="true"></i> Add Us On facebook: facebook.com/mobgarden</p>
				
				<div class="mobile_company_logo">
					<img src="{{asset('img/samsung.png')}}" alt="">
					<img src="{{asset('img/Walton_logo.png')}}" alt="">
					<img src="{{asset('img/OPPO.png')}}" alt="">
					<img src="{{asset('img/lava.png')}}" alt="">
					<img src="{{asset('img/mi.png')}}" alt="">
					<img src="{{asset('img/huawei.png')}}" alt="">
					<img src="{{asset('img/symphony.png')}}" alt="">
					<img src="{{asset('img/itel.png')}}" alt="">
					<img src="{{asset('img/Nokia.jpg')}}" alt="">
				</div>


            </div>
            <!-- /.col -->
            <div class="col-xs-6">
                <p class="lead">Amount</p>

                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th style="width:50%">Grand Total:</th>
                            <td>{{ $total_amount + $total_discount }}</td>
                        </tr>
                        <tr>
                            <th style="width:50%">Paid:</th>
                            <td>{{ ($total_amount + $total_discount) - $total_discount - $due }}</td>
                        </tr>
                        @if($due > 0)
                        <tr>
                            <th style="width:50%">Due:</th>
                            <td>{{ $due }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
				
				
                <div class="signature pull-right text-center" style="">
                    <img src="{{asset('img/signature_sayek.png')}}" style="width: 70px;height: auto;" alt="">
                    <p>.....................................</p>
                    <p>Authorised Signature</p>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="row" id="invoice_mail">
            <div class="col-xs-12">
                <a href="javascript:window.print()" target="" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
                <a href="{{ route('invoiceEmail', $sells[0]->invoice_no) }}" class="btn btn-success pull-right"><i class="fa
                fa-credit-card"></i> Send Email</a>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>

</html>
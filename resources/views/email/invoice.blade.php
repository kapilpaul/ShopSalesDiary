<div class="wrapper" style="height: 100%;position: relative;overflow-x: hidden;overflow-y: auto;">
    <!-- Main content -->
    <section class="invoice" style="background: #fff;border: 1px solid #f4f4f4;padding: 20px;margin: 10px 25px;">
        <!-- title row -->
        <div class="row" style="overflow:hidden;">
            <div class="col-xs-12">
                <h2 class="page-header" style="margin: 10px 0 20px 0;font-size: 22px;padding-bottom: 9px;border-bottom: 1px solid #eee;">
                    <i class="fa fa-globe"></i> Mobile Garden
                    <small class="pull-right" style="color: #666;display: block;margin-top: 5px;float:right;font-size: 15px;">Date: 2/10/2014</small>
                </h2>
            </div>
            <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info" style="overflow:hidden;">
            <div class="col-sm-4 invoice-col" style="float: left;width: 33.33%;">
                From
                <address style="margin-bottom: 20px;font-style: normal;line-height: 1.42857143;">
                    <strong>Mobile Garden</strong><br>
                    Rikabi Bazaar Point<br>
                    Sylhet 3100<br>
                    Phone: 01717-132780 (Shop) <br> 01762-818251 (Sayek)<br>
                    Email: mobilegardeninfo@gmail.com
                </address>
            </div>
            <!-- /.col -->
            <div class="col-sm-4 invoice-col" style="float: left;width: 33.33%;">
                To
                <address style="margin-bottom: 20px;font-style: normal;line-height: 1.42857143;">
                    @if($customer)
                    <strong>{{$customer->name}}</strong><br>
                    Phone: {{$customer->phone_no}}<br>
                    Email: {{ $customer->email }}
                        @endif
                </address>
            </div>
            <!-- /.col -->
            @if($sells)
            <div class="col-sm-4 invoice-col" style="float: left;width: 33.33%;">
                <b>Invoice # {{ $sells[0]->invoice_no }}</b><br>
            </div>
            @endif
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- Table row -->
        <div class="row" style="overflow:hidden;">
            <div class="col-xs-12 table-responsive" style="min-height: .01%;overflow-x: auto;">
                <table class="table table-striped" style="width: 100%;max-width: 100%;margin-bottom: 20px;background-color: transparent;display: table;border-spacing: 0;border-collapse: collapse;">
                    <thead>
                    <tr style="font-size: 15px;">
                        <th style="text-align: left;border-bottom: 2px solid #f4f4f4;vertical-align: top;padding: 8px;line-height: 1.42857143;border-top: 1px solid #f4f4f4;">Qty</th>

                        <th style="text-align: left;border-bottom: 2px solid #f4f4f4;vertical-align: top;padding: 8px;line-height: 1.42857143;border-top: 1px solid #f4f4f4;">Product</th>

                        <th style="text-align: left;border-bottom: 2px solid #f4f4f4;vertical-align: top;padding: 8px;line-height: 1.42857143;border-top: 1px solid #f4f4f4;">Code/IMEI</th>
                        <th style="text-align: left;border-bottom: 2px solid #f4f4f4;vertical-align: top;padding: 8px;line-height: 1.42857143;border-top: 1px solid #f4f4f4;">Waranty(Months)</th>
                        <th style="text-align: left;border-bottom: 2px solid #f4f4f4;vertical-align: top;padding: 8px;line-height: 1.42857143;border-top: 1px solid #f4f4f4;">Due</th>
                        <th style="text-align: left;border-bottom: 2px solid #f4f4f4;vertical-align: top;padding: 8px;line-height: 1.42857143;border-top: 1px solid #f4f4f4;">Gift</th>
                        <th style="text-align: left;border-bottom: 2px solid #f4f4f4;vertical-align: top;padding: 8px;line-height: 1.42857143;border-top: 1px solid #f4f4f4;">Total Amount</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if($sells)
                        @foreach($sells as $sell)
                    <tr style="font-size: 15px;">
                        <td style="border-top: 1px solid #f4f4f4;padding: 8px;line-height: 1.42857143;vertical-align: top;">{{ $sell->quantity }}</td>
                        <td style="border-top: 1px solid #f4f4f4;padding: 8px;line-height: 1.42857143;vertical-align: top;">@if($sell->stock) {{ $sell->stock->product->name }} @else --
                            @endif</td>
							
                        <td style="border-top: 1px solid #f4f4f4;padding: 8px;line-height: 1.42857143;vertical-align: top;"> @if($sell->imei)
                                {{ $sell->imei->imei }}
                            @else
                                --
                            @endif</td>
                        <td style="border-top: 1px solid #f4f4f4;padding: 8px;line-height: 1.42857143;vertical-align: top;">
							@if($sell->stock) {{ $sell->stock->waranty }}
								@if($sell->stock->waranty)
								(Till {{ \Carbon\Carbon::parse($sell->created_at)->addMonths($sell->stock->waranty)->subDay(1)
								->format('d-m-Y') }})
									@endif
							@else -- @endif
						</td>
                        <td style="border-top: 1px solid #f4f4f4;padding: 8px;line-height: 1.42857143;vertical-align: top;">{{ $sell->due }}</td>
                        <td style="border-top: 1px solid #f4f4f4;padding: 8px;line-height: 1.42857143;vertical-align: top;">{{ $sell->gift }}</td>
                        <td style="border-top: 1px solid #f4f4f4;padding: 8px;line-height: 1.42857143;vertical-align: top;"> {{ $sell->total_amount + $sell->discount - $sell->due }}</td>
                    </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row" style="overflow:hidden;margin-left: -15px;">
            <!-- accepted payments column -->
            <div class="col-xs-6" style="width: 50%;float:left;position: relative;min-height: 1px;padding-right: 15px;padding-left: 15px;">

                <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;box-shadow: none !important;padding: 9px;border-radius: 3px;min-height: 20px;color: #777;margin-bottom: 20px;background-color: #f5f5f5;border: 1px solid #e3e3e3;margin: 10px 0px;">
                    Thanks For Buying Products From Mobile Garden. Your Smile Our Success.
                </p>
				
				<p style="margin-top: 10px;">Like Us On facebook: facebook.com/mobilegarde</p>
				<p style="margin-top: 10px;">Add Us On facebook: facebook.com/mobgarden</p>





            </div>
            <!-- /.col -->
            <div class="col-xs-6" style="width: 42%;float:left;position: relative;min-height: 1px;padding-right: 15px;
    padding-left: 15px;">
                <p class="lead" style="margin-bottom: 20px;font-size: 21px;font-weight: 300;line-height: 1.4;">Amount Paid</p>

                <div class="table-responsive" style="min-height: .01%;overflow-x: auto;">
                    <table class="table" style="width: 100%;max-width: 100%;margin-bottom: 20px;background-color: transparent;border-spacing: 0;border-collapse: collapse;display: table;">

                        <tr style="font-size: 15px;">
                            <th style="text-align: left;padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #f4f4f4;">Due:</th>
                            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #f4f4f4;">{{$due}}</td>
                        </tr>
                        <tr style="font-size: 15px;">
                            <th style="text-align: left;padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #f4f4f4;">Grand total:</th>
                            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid
                             #f4f4f4;">{{ $total_amount + $total_discount }}</td>
                        </tr>
                        <tr style="font-size: 15px;">
                            <th style="text-align: left;padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid #f4f4f4;">Paid:</th>
                            <td style="padding: 8px;line-height: 1.42857143;vertical-align: top;border-top: 1px solid
                             #f4f4f4;">{{ ($total_amount + $total_discount) - $total_discount - $due }}</td>
                        </tr>
                    </table>
                </div>
				
				<div class="signature" style="margin:30px 0 0px 0;float:right;text-align:center;">
                    <img src="https://lh6.googleusercontent.com/ZKR6t4s2-tAR-1AAgepNQM83urDWI_75lcSPCARAlQqqLnczqfQ2K-Op0FZo84PEZ2JYSV2djAIWFUg=w1366-h662" style="width: 70px;height: auto;" alt="">
                    <p>.....................................</p>
                    <p>Authorised Signature</p>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
<!-- ./wrapper -->
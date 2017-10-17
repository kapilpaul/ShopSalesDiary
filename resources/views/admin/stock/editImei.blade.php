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
                            <h3 class="box-title pull-left">Edit IMEI</h3>
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



                        {!! Form::model($productIMEI, ['method' => 'POST', 'action' => ['imeiController@update',
                        $productIMEI->id],  'class' =>  'two_col_forms']) !!}

                        <div class="row">
                            <div class="col-lg-12">
                                <div class="box-body">
                                    <div class="form-group">

                                        {!! Form::label('IMEI') !!}

                                        {!! Form::text('imei', null, ['class'=>'form-control', 'placeholder' => 'IMEI']) !!}
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


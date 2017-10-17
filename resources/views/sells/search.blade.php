@extends('layouts.admin_index')

@section('title')
    Search User
@stop


@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Search User</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Search User</a></li>
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
                    <div class="box box-info" style="padding-bottom: 20px">
                        {!! Form::open(['method' => 'GET', 'action' => 'SellsController@create', 'class' =>
                        'two_col_forms']) !!}

                            <div class="box-body">
                                {!! Form::label('Customer Phone No *') !!}
                                <div class="input-group input-group-md">
                                    {!! Form::text('phone_no', null, ['class'=>'form-control', 'placeholder' =>
                                    'Customer Phone No']) !!}
                                    <span class="input-group-btn">
                                        {!! Form::submit('Search', ['class'=>'btn btn-info btn-flat']) !!}
                                    </span>
                                </div>
                                @if ($errors->has('phone_no'))
                                    <span class="help-block">
                                        <p class="text-red">{{ $errors->first('phone_no', 'Please Enter Phone No')
                                        }}</p>
                                    </span>
                                @endif
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


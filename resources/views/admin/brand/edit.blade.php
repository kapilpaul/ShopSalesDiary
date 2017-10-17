@extends('layouts.admin_index')

@section('title')
    Edit Brand
@stop

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Brands</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Brands</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-6">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Add Brand</h3>
                        </div>
                        <!-- /.box-header -->


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

                        {!! Form::model($brand, ['method' => 'PATCH', 'action' => ['BrandsController@update', $brand->id], 'class' => '']) !!}
                        <div class="box-body">
                            <div class="form-group has-feedback">
                                {!! Form::text('name', null, ['class'=>'form-control', 'placeholder' => 'Brand Name'])
                                 !!}

                                <span class="glyphicon glyphicon-tree-conifer form-control-feedback"></span>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <p class="text-red">{{ $errors->first('name', 'Brand Name Required')  }}</p>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="box-footer">
                            {!! Form::reset('Cancel', ['class'=>'btn btn-default']) !!}
                            {!! Form::submit('Update', ['class'=>'btn btn-info pull-right']) !!}
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


@extends('layouts.admin_index')

@section('title')
    Category
@stop

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>User Create</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Category</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-6">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Add Category</h3>
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

                        {!! Form::model($category, ['method' => 'PATCH', 'action' => ['CategoryController@update', $category->id], 'class' => '']) !!}
                        <div class="box-body">
                            <div class="form-group has-feedback">
                                {!! Form::text('name', null, ['class'=>'form-control', 'placeholder' => 'Category Name']) !!}

                                <span class="glyphicon glyphicon-tree-conifer form-control-feedback"></span>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <p class="text-red">{{ $errors->first('name', 'Category Name Required')  }}</p>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="box-footer">
                            {!! Form::reset('Cancel', ['class'=>'btn btn-default']) !!}
                            {!! Form::submit('Update Category', ['class'=>'btn btn-info pull-right']) !!}
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
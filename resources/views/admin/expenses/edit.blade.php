@extends('layouts.admin_index')

@section('title')
    Expenses
@stop

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Expenses</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Expenses</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <!-- /.box-header -->
                    @if(session('success'))
                        <div class="alert alert-success">
                            <p>{{session('success')}}</p>
                        </div>
                    @endif @if(session('error'))
                        <div class="alert alert-error">
                            <p>{{session('error')}}</p>
                        </div>
                    @endif

                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Edit Expense</h3>
                            <!-- /.box-tools -->
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            {!! Form::model($expense, ['method' => 'PATCH', 'action' => ['ExpenseController@update',
                            $expense->id], 'class' =>'']) !!}
                            <div class="box-body">
                                <div class="form-group has-feedback">
                                    {!! Form::text('name', null, ['class'=>'form-control', 'placeholder' => 'Expense Name']) !!}
                                    <span class="glyphicon glyphicon-tree-conifer form-control-feedback"></span>
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <p class="text-red">{{ $errors->first('name', 'Expense Name Required') }}</p>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group has-feedback">
                                    {!! Form::text('amount', null, ['class'=>'form-control', 'placeholder' => 'Expense Amount']) !!}

                                    <span class="glyphicon glyphicon-tree-conifer form-control-feedback"></span>
                                    @if ($errors->has('amount'))
                                        <span class="help-block">
                                            <p class="text-red">{{ $errors->first('amount', 'Expense Amount Required')}}</p>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group has-feedback">
                                    {!! Form::date('date', null, ['class'=>'form-control']) !!}

                                    <span class="glyphicon glyphicon-tree-conifer form-control-feedback"></span>
                                    @if ($errors->has('date'))
                                        <span class="help-block">
                                            <p class="text-red">{{ $errors->first('date') }}</p>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="box-footer">
                                {!! Form::reset('Cancel', ['class'=>'btn btn-default']) !!}
                                {!! Form::submit('Update Expense', ['class'=>'btn btn-info pull-right']) !!}
                            </div>
                            {!! Form::close() !!}
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>
            </div>
            <!-- /.row -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@stop
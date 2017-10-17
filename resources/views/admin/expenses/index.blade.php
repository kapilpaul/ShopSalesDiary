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

                    <div class="box box-primary collapsed-box">
                        <div class="box-header with-border" data-widget="collapse">
                            <h3 class="box-title">Add Expenses</h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool"><i class="fa fa-plus"></i>
                                </button>
                            </div>
                            <!-- /.box-tools -->
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            {!! Form::open(['method' => 'POST', 'action' => 'ExpenseController@store', 'class' => '']) !!}
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
                                    {!! Form::date('date', Carbon\Carbon::now(), ['class'=>'form-control']) !!}

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
                                {!! Form::submit('Add Expense', ['class'=>'btn btn-info pull-right']) !!}
                            </div>
                            {!! Form::close() !!}
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title pull-left">All Expenses</h3>

                        </div>

                        @if(session('exp_success'))
                            <div class="box-body">
                                <div class="alert alert-success">
                                    <p>{{session('exp_success')}}</p>
                                </div>
                            </div>
                        @endif

                        @if($expenses)
                        <!-- /.box-header -->

                            <div class="box-body no-padding category_table">
                                <table class="table table-striped">
                                    <tbody>
                                    <tr>
                                        <th style="width: 10px"></th>
                                        <th style="width: 10px">#</th>
                                        <th>Expense Name</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th style="width: 20px">Edit</th>
                                        <th style="width: 20px">Delete</th>
                                    </tr>

                                    <?php $i= 0;?>
                                    @foreach($expenses as $expense)
                                        <?php $i++ ;?>
                                        <tr>
                                            <td></td>
                                            <td>{{ $i }}</td>
                                            <td>{{ $expense->name }}</td>
                                            <td>{{ $expense->amount }}</td>
                                            <td>{{ \Carbon\Carbon::parse($expense->date)->format('d-M-Y') }}</td>
                                            <td>
                                                <a href="{{ route('expenses.edit', $expense->id) }}">
                                                    <p class="no_bottom_margin" data-placement="top" data-toggle="tooltip" title="" data-original-title="Edit">

                                                        <button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit">
                                                            <span class="glyphicon glyphicon-pencil"></span>
                                                        </button>

                                                    </p>
                                                </a>
                                            </td>

                                            <td>
                                                <a href="{{ url('expenses/deleteall', $expense->id) }}">

                                                    <p class="no_bottom_margin" data-placement="top" data-toggle="tooltip" title="" data-original-title="Delete">
                                                        <button onclick="alert('Are You Sure You Want To Delete')" class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete">
                                                            <span class="glyphicon glyphicon-trash"></span>
                                                        </button>
                                                    </p>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        @endif
                        <!-- /.box-body -->
                        @if($page_count > 0)
                            {{ $expenses->links('layouts.pagination') }}
                        @endif


                    </div>
                </div>
            </div>
            <!-- /.row -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@stop


@section('javascript')

@stop
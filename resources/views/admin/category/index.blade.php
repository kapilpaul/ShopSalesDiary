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

                        {!! Form::open(['method' => 'POST', 'action' => 'CategoryController@store', 'class' => ''])
                         !!}
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
                            {!! Form::submit('Add Category', ['class'=>'btn btn-info pull-right']) !!}
                        </div>
                        {!! Form::close() !!}

                    </div>
                </div>

                <div class="col-md-6">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">All Categories</h3>
                            @if(count($trashed) > 0)
                                <div class="box-tools">
                                    <a class="restore" href="{{ route('deletedCategory') }}">Deleted Categories</a>
                                </div>
                            @endif
                        </div>

                        @if(session('cat_success'))
                            <div class="box-body">
                                <div class="alert alert-success">
                                    <p>{{session('cat_success')}}</p>
                                </div>
                            </div>
                    @endif

                        @if($categories)
                        <!-- /.box-header -->

                        <div class="box-body no-padding category_table">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Name</th>
                                        <th style="width: 20px">Edit</th>
                                        <th style="width: 20px">Delete</th>
                                    </tr>

                                        <?php $i= 0;?>
                                        @foreach($categories as $category)
                                            <?php $i++ ;?>
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>
                                            <a href="{{ route('category.edit', $category->id) }}">
                                                <p class="no_bottom_margin" data-placement="top" data-toggle="tooltip" title=""
                                                    data-original-title="Edit">

                                                    <button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit">
                                                        <span class="glyphicon glyphicon-pencil"></span>
                                                    </button>

                                            </p></a>
                                        </td>

                                        <td>


                                            {!! Form::open(['method' => 'DELETE', 'class' =>'user_delete pull-left', 'action' => ['CategoryController@destroy', $category->id]]) !!}
                                            <p class="no_bottom_margin" data-placement="top" data-toggle="tooltip" title="" data-original-title="Delete">
                                                <button onclick="alert('Are You Sure You Want To Delete')" class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete">
                                                    <span class="glyphicon glyphicon-trash"></span>
                                                </button>
                                            </p>
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                        @endforeach

                                </tbody>
                            </table>
                        </div>
                        @endif
                        <!-- /.box-body -->
                        @if($page_count > 0)
                            {{ $categories->links('layouts.pagination') }}
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


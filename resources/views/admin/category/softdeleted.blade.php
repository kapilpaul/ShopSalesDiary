@extends('layouts.admin_index')

@section('title')
    Categories
@stop

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>Categories</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active">Categories</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
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

                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">All Categories</h3>

                            <div class="box-tools">
                                <a class="restore" href="{{ route('restoreallCategory') }}">Restore all category</a>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">
                            <table class="table table-hover">
                                <tbody>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Name</th>
                                    <th style="width: 20px">Edit</th>
                                    <th style="width: 20px">Delete</th>
                                </tr>
                                @if($categories)
                                    <?php $i=0;?>
                                    @foreach($categories as $category)
                                        <?php $i++;?>
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


                                                {!! Form::open(['method' => 'POST', 'class' =>'user_delete pull-left', 'action' => ['CategoryController@restore', $category->id]]) !!}
                                                <p class="no_bottom_margin" data-placement="top" data-toggle="tooltip" title="" data-original-title="Delete">
                                                    <button class="btn btn-danger btn-xs" data-title="Restore" data-toggle="modal" data-target="#delete">
                                                        <i class="fa fa-undo" aria-hidden="true"></i> Restore
                                                    </button>
                                                </p>
                                                {!! Form::close() !!}
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td>No Categories</td>
                                        <td>No Categories</td>
                                        <td>No Categories</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <!-- /.box-body -->
                        @if($page_count > 0)
                            {{ $categories->links('layouts.pagination') }}
                        @endif
                    </div>
                    <!-- /.box -->
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@stop


@section('javascript')


    <script type="text/javascript">
        $(window).on('load', function() {
            setTimeout(function(){ $('.alert-success, .alert-danger').slideUp() }, 5000);
        });
    </script>

@stop
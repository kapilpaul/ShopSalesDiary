@extends('layouts.admin_index')

@section('title')
    Users
@stop

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>User Create</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Examples</a></li>
                <li class="active">User profile</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">All Users</h3>

                            <div class="box-tools">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                                    <div class="input-group-btn">
                                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body table-responsive no-padding">

                            @if(session('error'))
                                <div class="alert alert-success">
                                    <p>{{session('error')}}</p>
                                </div>
                            @endif
                            @if(session('success'))
                                <div class="alert alert-success">
                                    <p>{{session('success')}}</p>
                                </div>
                            @endif

                            <table class="table table-hover">
                                <tbody>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Last Login</th>
                                        <th>Action</th>
                                        <th></th>
                                    </tr>
                                    @if($users)
                                        <?php $i=0;?>
                                        @foreach($users as $user)
                                            <?php $i++;?>
                                    <tr>
                                        <td>{{ $i }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->roles->first()->name }}</td>
                                        <td>
                                            @if(Activation::completed($user))
                                                <span class="label label-success">Active</span>
                                            @else
                                                <span class="label label-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($user->last_login)
                                                {{ \Carbon\Carbon::parse($user->last_login)->diffForHumans() }}
                                            @else
                                                Not Logged in Yet
                                            @endif
                                        </td>
                                        <td>
                                            @if(Activation::completed($user))
                                                {!! Form::model($user, ['method' => 'POST', 'class' =>'pull-left', 'action' => ['AdminUserController@inactive', $user->id]]) !!}
                                                {!! Form::submit('InActive', ['class'=>'btn btn-danger btn-sm']) !!}

                                                {!! Form::close() !!}
                                            @else
                                                {!! Form::model($user, ['method' => 'POST', 'class' =>'pull-left', 'action' => ['AdminUserController@active', $user->id]]) !!}
                                                {!! Form::submit('Active', ['class'=>'btn btn-success btn-sm']) !!}

                                                {!! Form::close() !!}
                                            @endif
                                        </td>

                                        <td>
                                            {!! Form::open(['method' => 'DELETE', 'class' =>'user_delete pull-left', 'action' => ['AdminUserController@destroy', $user->id]]) !!}
                                                {!! Form::submit('Delete', ['class'=>'btn btn-danger btn-sm', 'onclick' => 'alert("are You sure to delete")']) !!}
                                            {!! Form::close() !!}


                                        </td>

                                    </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <!-- /.box-body -->
                        @if($page_count > 0)
                            {{ $users->links('layouts.pagination') }}
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
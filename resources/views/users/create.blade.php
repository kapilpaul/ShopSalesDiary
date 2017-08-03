@extends('layouts.admin_index')

@section('title')
    Create User
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
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Add User</h3>
                        </div>
                        <!-- /.box-header -->


                        @if(session('success'))
                            <div class="alert alert-success">
                                <p>{{session('success')}}</p>
                            </div>
                        @endif

                        {!! Form::open(['method' => 'POST', 'action' => 'AdminUserController@store', 'class' => '',
                        'files' => true])
                         !!}
                            <div class="box-body">
                                <div class="col-md-9">
                                    <div class="form-group has-feedback">
                                        {!! Form::text('name', null, ['class'=>'form-control', 'placeholder' => 'Name']) !!}

                                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                        @if ($errors->has('name'))
                                            <span class="help-block">
                                                <p class="text-red">{{ $errors->first('name') }}</p>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group has-feedback">
                                        {!! Form::email('email', null, ['class'=>'form-control', 'placeholder' => 'example@example.com'])
                                         !!}
                                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                        @if ($errors->has('email'))
                                            <span class="help-block">
                                                <p class="text-red">{{ $errors->first('email') }}</p>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group has-feedback">
                                        {!! Form::select('roles_id', $roles, null, ['class'=>'form-control',
                                        'placeholder' => 'Pick a Role...']) !!}

                                        @if ($errors->has('roles_id'))
                                            <span class="help-block">
                                                <p class="text-red">{{ $errors->first('roles_id') }}</p>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group has-feedback">
                                        {!! Form::password('password', ['class'=>'form-control', 'placeholder' => 'Password'])
                                         !!}
                                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                        @if ($errors->has('password'))
                                            <span class="help-block">
                                                <p class="text-red">{{ $errors->first('password') }}</p>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group has-feedback">
                                        {!! Form::password('password_confirmation', ['class'=>'form-control', 'placeholder' => 'Retype Password'])
                                         !!}
                                        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div id="image-preview">
                                        <div class="">
                                            <label for="image-upload" id="image-label">Choose File</label>
                                            {!! Form::file('photo_id', ['id' => 'image-upload']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="box-footer">
                                {!! Form::reset('Cancel', ['class'=>'btn btn-default']) !!}
                                {!! Form::submit('Create User', ['class'=>'btn btn-info pull-right']) !!}
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


@section('javascript')

    <script src="{{asset('libs/plugins/upload_preview/jquery.uploadPreview.min.js')}}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $.uploadPreview({
                input_field: "#image-upload",   // Default: .image-upload
                preview_box: "#image-preview",  // Default: .image-preview
                label_field: "#image-label",    // Default: .image-label
                label_default: "Choose File",   // Default: Choose File
                label_selected: "Change File",  // Default: Change File
                no_label: false                 // Default: false
            });
        });
    </script>

@stop
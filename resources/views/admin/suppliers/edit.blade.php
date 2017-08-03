@extends('layouts.admin_index')

@section('title')
    Suppliers
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
            <h1>Suppliers</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Suppliers</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Update Suppliers</h3>
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

                        {!! Form::model($supplier, ['method' => 'PATCH', 'action' => ['SuppliersController@update', $supplier->id], 'class' => '']) !!}

                            <div class="box-body">
                                <div class="form-group has-feedback">
                                    {!! Form::text('name', null, ['class'=>'form-control', 'placeholder' => 'Supplier Name']) !!}

                                    <span class="glyphicon glyphicon-tree-conifer form-control-feedback"></span>
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <p class="text-red">{{ $errors->first('name', 'Supplier Name Required')  }}</p>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group has-feedback">
                                    {!! Form::text('phone_no', null, ['class'=>'form-control', 'placeholder' => 'Phone No']) !!}

                                    <i class="fa fa-mobile form-control-feedback"></i>
                                    @if ($errors->has('phone_no'))
                                        <span class="help-block">
                                            <p class="text-red">{{ $errors->first('phone_no', 'Phone No Required')  }}</p>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group has-feedback">
                                    {!! Form::text('address', null, ['class'=>'form-control', 'placeholder' => 'Address'])
                                     !!}

                                    <i class="fa fa-map-marker form-control-feedback"></i>
                                </div>


                                <div class="form-group">
                                    {!! Form::select('brand_id[]', $brands , $brand_ids, ['class'=>'form-control select2', 'multiple'=>true, 'data-placeholder' => 'Select Brands' , 'style' => 'width: 100%;']) !!}

                                    @if ($errors->has('brand_id'))
                                        <span class="help-block">
                                            <p class="text-red">{{ $errors->first('brand_id') }}</p>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="box-footer">
                                {!! Form::reset('Cancel', ['class'=>'btn btn-default']) !!}
                                {!! Form::submit('Update Supplier', ['class'=>'btn btn-info pull-right']) !!}
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

@section('top_javascript')
    <!-- Select2 -->
    <script src="{{asset('libs/bower_components/select2/dist/js/select2.full.min.js')}}"></script>
@stop

@section('javascript')
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()
        })
    </script>

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
@extends('layouts.admin_index')

@section('title')
    Products
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
            <h1>New Products</h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Products</a></li>
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

                <div class="col-md-8">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Add Products</h3>
                        </div>
                        <!-- /.box-header -->

                        {!! Form::open(['method' => 'POST', 'action' => 'ProductsController@store', 'class' => '', 'files' => true]) !!}
                            <div class="box-body">
                                <div class="form-group has-feedback">
                                    {!! Form::text('name', null, ['class'=>'form-control', 'placeholder' => 'Product Name'])
                                     !!}

                                    <span class="glyphicon glyphicon-tree-conifer form-control-feedback"></span>
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <p class="text-red">{{ $errors->first('name', 'Category Name Required')  }}</p>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::select('brand_id', $brands, null, ['class'=>'form-control select2', 'placeholder' => 'Pick a Brand...' , 'style' => 'width: 100%;']) !!}

                                    @if ($errors->has('brand_id'))
                                        <span class="help-block">
                                            <p class="text-red">{{ $errors->first('brand_id') }}</p>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::select('category_id', $category, null, ['class'=>'form-control select2', 'placeholder' => 'Pick a Category...' , 'style' => 'width: 100%;']) !!}

                                    @if ($errors->has('category_id'))
                                        <span class="help-block">
                                            <p class="text-red">{{ $errors->first('category_id') }}</p>
                                        </span>
                                    @endif
                                </div>
                            </div>



                        <div class="box-footer">
                            {!! Form::reset('Cancel', ['class'=>'btn btn-default']) !!}
                            {!! Form::submit('Add Product', ['class'=>'btn btn-info pull-right']) !!}
                        </div>

                    </div>
                </div>

                <div class="col-md-4">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Add Product Image</h3>
                        </div>
                        <div class="box-body">

                            <div id="image-preview">
                                <div class="">
                                    <label for="image-upload" id="image-label">Choose Image</label>
                                    {!! Form::file('photo_id', ['id' => 'image-upload']) !!}
                                </div>
                            </div>
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
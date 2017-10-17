@extends('layouts.loginRegister')


@section('title')
    404
@stop

@section('css')
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('libs/dist/css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset('libs/dist/css/skins/_all-skins.min.css')}}">

    <style>
        .content-wrapper{
            margin-left: 0;
        }
    </style>
@stop

@section('body_content')

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                404 Error Page
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="error-page">
                <h2 class="headline text-yellow"> 404</h2>

                <div class="error-content">
                    <h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>

                    <p>
                        We could not find the page you were looking for. Meanwhile, you may <a href="../../index.html">return to dashboard</a> or try using the search form.
                    </p>

                    <form class="search-form">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search">

                            <div class="input-group-btn">
                                <button type="submit" name="submit" class="btn btn-warning btn-flat"><i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.input-group -->
                    </form>
                </div>
                <!-- /.error-content -->
            </div>
            <!-- /.error-page -->
        </section>
        <!-- /.content -->
    </div>

</div>
<!-- ./wrapper -->

    @stop

    @section('javascripts')
        <!-- iCheck -->
        <script src="{{asset('libs/bower_components/fastclick/lib/fastclick.js')}}"></script>
        <script src="{{asset('libs/dist/js/adminlte.min.js')}}"></script>
        <script src="{{asset('libs/dist/js/demo.js')}}"></script>
    @stop
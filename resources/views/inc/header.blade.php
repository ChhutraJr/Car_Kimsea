<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="userId" content="{{ Auth::check() ? Auth::user()->id : '' }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{url('/storage/logo/logo_png.png')}}" type="image/x-icon">
    <title>Kimsea Garage System</title>
    <!-- CSS -->
    <link href="{{url('plugins/toastr/toastr.min.css')}}" rel="stylesheet">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/paper.css') }}" rel="stylesheet">

    {{--<link rel="stylesheet" href="{{url('/css/paper.css')}}">--}}
    {{--<link rel="stylesheet" href="{{url('/plugins/bootstrap-datepicker/css/datepicker.css')}}">--}}
    <link rel="stylesheet" href="{{url('/plugins/bootstrap-datepicker/css/datepicker3.css')}}">
    <link rel="stylesheet" href="{{url('/plugins/daterangepicker-master/daterangepicker.css')}}">
    <link rel="stylesheet" href="{{url('/plugins/sweetalert2/sweetalert.css')}}">
    <link rel="stylesheet" href="{{url('/plugins/modal-master/jquery.modal.min.css')}}">
    <link rel="stylesheet" href="{{url('/plugins/fontawesome/fontawesome.min.css')}}">
    <link rel="stylesheet" href="{{url('/plugins/tagsinput/jquery.tagsinput.min.css')}}">

    <script src="{{url('/plugins/moment/moment.min.js')}}"></script>

    {{--<link rel="stylesheet" href="{{url('/css/custom.css')}}">--}}
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <style>
        .loader {
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: #F5F8FA;
            z-index: 9998;
            text-align: center;
        }

        .plane-container {
            position: absolute;
            top: 50%;
            left: 50%;
        }
    </style>

</head>
<body class="light">
<!-- Pre loader -->
<div id="loader" class="loader">
    <div class="plane-container">
        <div class="preloader-wrapper small active">
            <div class="spinner-layer spinner-blue">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div><div class="gap-patch">
                    <div class="circle"></div>
                </div><div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>

            <div class="spinner-layer spinner-red">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div><div class="gap-patch">
                    <div class="circle"></div>
                </div><div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>

            <div class="spinner-layer spinner-yellow">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div><div class="gap-patch">
                    <div class="circle"></div>
                </div><div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>

            <div class="spinner-layer spinner-green">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div><div class="gap-patch">
                    <div class="circle"></div>
                </div><div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="app">

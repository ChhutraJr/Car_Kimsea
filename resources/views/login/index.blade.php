<!DOCTYPE html>
<html lang="zxx">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="icon" href="{{url('/storage/logo/logo_png.png')}}" type="image/x-icon">

    <title>Kimsea Garage System</title>
    <!-- CSS -->
    {{--<link rel="stylesheet" href="assets/css/app.css">--}}
    <link rel="stylesheet" href="{{ url('/css/app.css') }}">
    <link href="{{ asset('css/paper.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    {{--<link rel="stylesheet" href="{{url('/css/custom.css')}}">--}}

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

       /* .paper-card{

            -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px #4a99d8;
            box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px  #4a99d8;
        }*/

        .form-control-lg:focus, .input-group-lg>.form-control:focus, .input-group-lg>.input-group-addon:focus, .input-group-lg>.input-group-append>.btn:focus, .input-group-lg>.input-group-append>.input-group-text:focus, .input-group-lg>.input-group-prepend>.btn:focus, .input-group-lg>.input-group-prepend>.input-group-text:focus{
            -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 6px {{config('global.focus_color')}};
            box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 6px {{config('global.focus_color')}};
        }

        .form-control-lg, .input-group-lg>.form-control, .input-group-lg>.input-group-addon, .input-group-lg>.input-group-append>.btn, .input-group-lg>.input-group-append>.input-group-text, .input-group-lg>.input-group-prepend>.btn, .input-group-lg>.input-group-prepend>.input-group-text{
            border: 1px solid #e1e8ee;
        }

        .form-group.has-icon input:focus{
            border: 1px solid {{config('global.border_color')}} !important;
            -webkit-box-shadow: inset 0 1px 1px rgba(92, 119, 164, 0.07), 0 0 6px  {{config('global.focus_color')}};
            box-shadow: inset 0 1px 1px rgba(92, 119, 164, 0.07), 0 0 6px  {{config('global.focus_color')}};
        }

        .btn-primary{
            background: {{config('global.main_color')}};
            border-color:{{config('global.main_color')}};
        }

        .btn-primary:focus{
            background: {{config('global.main_color')}};
            border-color:{{config('global.main_color')}};
        }

        .btn-primary:not(:disabled):not(.disabled).active:focus, .btn-primary:not(:disabled):not(.disabled):active:focus, .show>.btn-primary.dropdown-toggle:focus{

            -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 6px {{config('global.focus_color')}};
            box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 6px {{config('global.focus_color')}};
        }

        .btn-primary:focus, .btn-primary:hover{
            background: {{config('global.main_color')}};
            border-color:{{config('global.main_color')}};
        }

        .btn-primary:not(:disabled):not(.disabled).active, .btn-primary:not(:disabled):not(.disabled):active, .show>.btn-primary.dropdown-toggle{
            background: {{config('global.main_color')}};
            border-color:{{config('global.main_color')}};
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
    <main>
        <div id="primary" class="p-t-b-100 height-full">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 mx-md-auto paper-card">
                        <div class="text-center">
                            <img src="{{url('/storage/logo/logo_png.png')}}" alt="" width="80px" height="80px">
                            <h3 class="mt-2">Kimsea Garage System</h3>
                            <p class="p-t-b-20">Login to your account.</p>
                        </div>
                        <form id="formLogin" method="POST">
                            {{ csrf_field() }}
                            <div class="form-group has-icon"><i class="icon-person"></i>
                                <input type="text" name="username" id="username" class="form-control form-control-lg input1"
                                       placeholder="Username" value="">

                                <span class="text-danger">
                                                   <strong id="error1"></strong>
                                            </span>
                            </div>
                            <div class="form-group has-icon"><i class="icon-lock-stripes2"></i>
                                <input type="password" name="password" id="pass" class="form-control form-control-lg input2"
                                       placeholder="Password" value="">

                                <span class="text-danger">
                                                   <strong id="error2"></strong>
                                            </span>
                            </div>

                            <div class="text-center" style="margin-bottom: 10px">
                                   <span class="text-danger">
                                           <strong id="username-pass-error"></strong>
                                    </span>
                                    <span class="text-success">
                                           <strong id="username-pass-success"></strong>
                                    </span>

                            </div>

                            <input type="submit" class="btn btn-primary btn-flat btn-block" value="Login" >

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- #primary -->
    </main>

    <!-- Add the sidebar's background. This div must be placed
             immediately after the control sidebar -->
    <div class="control-sidebar-bg shadow white fixed"></div>
</div>

<script src="{{url('/js/jquery/jquery-2.2.1.js')}}"></script>
<script src="{{url('js/jquery3/jquery-3.1.0.min.js')}}"></script>

<!--/#app -->
{{--<script src="assets/js/paper.js"></script>--}}
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/paper.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
{{--<script src="{{ url('js/paper.js')}}"></script>--}}
{{--<script src="{{url('/js/custom.js')}}"></script>--}}

<script type="text/javascript">
    $('#formLogin').submit(function (e) {
        e.preventDefault();

        /* លុបនូវអក្សរពី Error */
        clear_border(['input1','input2']);
        clear_error(['error1','error2','username-pass-error']);

        $('#msg-not-verify').html("");

        var username=$('#username').val();
        var pass=$('#pass').val();
        /* Create new varaible that store all values from form From User\*/
        $.ajax({
            type: "POST",
            url: "{{route('login.login')}}",
            dataType: 'json',
            data: {
                'username':username,
                'password':pass,
                '_token': "{{ csrf_token() }}"
            },
            success: function(data){
                /* When controller is complete it send back value to data*/
//                console.log(data);

                /* Display all the errors message*/
                if (data.errors){
                    if (data.errors.username) {
                        errors('#error1', data.errors.username[0], '.input1');
                    }

                    if (data.errors.password) {
                        errors('#error2', data.errors.password[0], '.input2');
                    }
                }

                if (data.verify=='false'){
//                        $('.input1').parent().addClass('has-error');
//                        $('.input2').parent().addClass('has-error');
                        errors('#username-pass-error', 'Your username or password is incorrect.', '.input-pass');

                }

                //Account is correct
                if (data.verify=='true'){
                    $("#formLogin")[0].reset();
                    $('#username-pass-success').html('Your account is ready.');
                    //$('#msg-not-verify').html("<div class='alert alert-success'>Your account is ready. </div>");

                    window.location.href = '{{url('/')}}'+'/'+data.link;

                }

                //Account is deactivate
                if (data.activate=='false'){
//                    $('.input-username').parent().addClass('has-error');
                    errors('#username-pass-error', 'You account has been deactivated.', '.input-pass');
                }



                /*if (data.verify=='false'){
                    $('#msg-not-verify').html("<div class='alert alert-danger'>Your Email or Password is incorrect ! </div>");
                }*/
            },
            error: function(er){}
        });

    });

    $("#username").on("input", function(e) {

        on_change_input('username','input1','error1','The username field is required.');
        clear_error(['username-pass-error']);
    });

    $("#pass").on("input", function(e) {

        on_change_input('pass','input2','error2','The password field is required.');
        clear_error(['username-pass-error']);
    });
</script>
</body>
</html>

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
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/paper.css') }}" rel="stylesheet">
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
    <div class="height-full light">
        <div id="primary" class="content-area"
             data-bg-possition="center"
             data-bg-repeat="false"
             style="background: url('assets/img/icon/icon-circles.png');">
            <div class="container">
                <div class="col-xl-8 mx-lg-auto p-t-b-80">
                    <header class="text-center mb-5">
                        <h1>oops!</h1>
                        <p class="section-subtitle">Something went wrong. The page you are looking for is gone</p>

                    </header>
                    <div class="pt-5 p-t-100 text-center">
                        <p class="s-256">404</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- #primary -->
    </div>
    <!-- Right Sidebar -->
    <aside class="control-sidebar fixed white ">
        <div class="slimScroll">
            <div class="sidebar-header">
                <h4>Activity List</h4>
                <a href="#" data-toggle="control-sidebar" class="paper-nav-toggle  active"><i></i></a>
            </div>
            <div class="p-3">
                <div>
                    <div class="my-3">
                        <small>25% Complete</small>
                        <div class="progress" style="height: 3px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 25%;" aria-valuenow="25"
                                 aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="my-3">
                        <small>45% Complete</small>
                        <div class="progress" style="height: 3px;">
                            <div class="progress-bar bg-info" role="progressbar" style="width: 45%;" aria-valuenow="45"
                                 aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="my-3">
                        <small>60% Complete</small>
                        `
                        <div class="progress" style="height: 3px;">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 60%;" aria-valuenow="60"
                                 aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="my-3">
                        <small>75% Complete</small>
                        <div class="progress" style="height: 3px;">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 75%;" aria-valuenow="75"
                                 aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="my-3">
                        <small>100% Complete</small>
                        <div class="progress" style="height: 3px;">
                            <div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="100"
                                 aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-3 bg-primary text-white">
                <div class="row">
                    <div class="col-md-6">
                        <h5 class="font-weight-normal s-14">Sodium</h5>
                        <span class="font-weight-lighter text-primary">Spark Bar</span>
                        <div> Oxygen
                            <span class="text-primary">
                                                    <i class="icon icon-arrow_downward"></i> 67%</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <canvas width="100" height="70" data-chart="spark" data-chart-type="bar"
                                data-dataset="[[28,68,41,43,96,45,100,28,68,41,43,96,45,100,28,68,41,43,96,45,100,28,68,41,43,96,45,100]]"
                                data-labels="['a','b','c','d','e','f','g','h','i','j','k','l','m','n','a','b','c','d','e','f','g','h','i','j','k','l','m','n']">
                        </canvas>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table id="recent-orders" class="table table-hover mb-0 ps-container ps-theme-default">
                    <tbody>
                    <tr>
                        <td>
                            <a href="#">INV-281281</a>
                        </td>
                        <td>
                            <span class="badge badge-success">Paid</span>
                        </td>
                        <td>$ 1228.28</td>
                    </tr>
                    <tr>
                        <td>
                            <a href="#">INV-01112</a>
                        </td>
                        <td>
                            <span class="badge badge-warning">Overdue</span>
                        </td>
                        <td>$ 5685.28</td>
                    </tr>
                    <tr>
                        <td>
                            <a href="#">INV-281012</a>
                        </td>
                        <td>
                            <span class="badge badge-success">Paid</span>
                        </td>
                        <td>$ 152.28</td>
                    </tr>
                    <tr>
                        <td>
                            <a href="#">INV-01112</a>
                        </td>
                        <td>
                            <span class="badge badge-warning">Overdue</span>
                        </td>
                        <td>$ 5685.28</td>
                    </tr>
                    <tr>
                        <td>
                            <a href="#">INV-281012</a>
                        </td>
                        <td>
                            <span class="badge badge-success">Paid</span>
                        </td>
                        <td>$ 152.28</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="sidebar-header">
                <h4>Activity</h4>
                <a href="#" data-toggle="control-sidebar" class="paper-nav-toggle  active"><i></i></a>
            </div>
            <div class="p-4">
                <div class="activity-item activity-primary">
                    <div class="activity-content">
                        <small class="text-muted">
                            <i class="icon icon-user position-left"></i> 5 mins ago
                        </small>
                        <p>Lorem ipsum dolor sit amet conse ctetur which ascing elit users.</p>
                    </div>
                </div>
                <div class="activity-item activity-danger">
                    <div class="activity-content">
                        <small class="text-muted">
                            <i class="icon icon-user position-left"></i> 8 mins ago
                        </small>
                        <p>Lorem ipsum dolor sit ametcon the sectetur that ascing elit users.</p>
                    </div>
                </div>
                <div class="activity-item activity-success">
                    <div class="activity-content">
                        <small class="text-muted">
                            <i class="icon icon-user position-left"></i> 10 mins ago
                        </small>
                        <p>Lorem ipsum dolor sit amet cons the ecte tur and adip ascing elit users.</p>
                    </div>
                </div>
                <div class="activity-item activity-warning">
                    <div class="activity-content">
                        <small class="text-muted">
                            <i class="icon icon-user position-left"></i> 12 mins ago
                        </small>
                        <p>Lorem ipsum dolor sit amet consec tetur adip ascing elit users.</p>
                    </div>
                </div>
            </div>
        </div>
    </aside>
    <!-- /.right-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
             immediately after the control sidebar -->
    <div class="control-sidebar-bg shadow white fixed"></div>
</div>
<!--/#app -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/paper.js') }}"></script>
</body>
</html>
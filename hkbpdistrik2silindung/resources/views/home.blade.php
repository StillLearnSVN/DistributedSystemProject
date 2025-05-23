@extends('layouts.admin.template')
@section('content')
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Dashboard Distrik II Silindung</h4>
            </div>
            <div class="col-md-7 align-self-center text-end">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb justify-content-end">
                        <li class="breadcrumb-item active"><a href="{{ route('login') }}" style="color:inherit">Dashboard</a>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Start Page Content -->
        <!-- ============================================================== -->
        <div class="row g-0">
            <div class="col-lg-3 col-md-6">
                <div class="card border">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <h3><i class="icon-screen-desktop"></i></h3>
                                        <p class="text-muted">MYNEW CLIENTS</p>
                                    </div>
                                    <div class="ms-auto">
                                        <h2 class="counter text-primary">23</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="progress">
                                    <div class="progress-bar bg-primary" role="progressbar" style="width: 85%; height: 6px;"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card border">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <h3><i class="icon-note"></i></h3>
                                        <p class="text-muted">NEW PROJECTS</p>
                                    </div>
                                    <div class="ms-auto">
                                        <h2 class="counter text-cyan">169</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="progress">
                                    <div class="progress-bar bg-cyan" role="progressbar" style="width: 85%; height: 6px;"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card border">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <h3><i class="icon-doc"></i></h3>
                                        <p class="text-muted">NEW INVOICES</p>
                                    </div>
                                    <div class="ms-auto">
                                        <h2 class="counter text-purple">157</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="progress">
                                    <div class="progress-bar bg-purple" role="progressbar" style="width: 85%; height: 6px;"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="card border">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <h3><i class="icon-bag"></i></h3>
                                        <p class="text-muted">All PROJECTS</p>
                                    </div>
                                    <div class="ms-auto">
                                        <h2 class="counter text-success">431</h2>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="progress">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 85%; height: 6px;"
                                        aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Info box -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Over Visitor, Our income , slaes different and  sales prediction -->
        <!-- ============================================================== -->
        {{-- <div class="row">
            <!-- Column -->
            <div class="col-lg-8 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex m-b-40 align-items-center no-block">
                            <h5 class="card-title ">YEARLY SALES</h5>
                            <div class="ms-auto">
                                <ul class="list-inline font-12">
                                    <li><i class="fa fa-circle text-cyan"></i> Iphone</li>
                                    <li><i class="fa fa-circle text-primary"></i> Ipad</li>
                                    <li><i class="fa fa-circle text-purple"></i> Ipod</li>
                                </ul>
                            </div>
                        </div>
                        <div id="morris-area-chart" style="height: 340px;"></div>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <div class="col-lg-4 col-md-12">
                <div class="row">
                    <!-- Column -->
                    <div class="col-md-12">
                        <div class="card bg-cyan text-white">
                            <div class="card-body ">
                                <div class="row weather">
                                    <div class="col-6 m-t-40">
                                        <h3>&nbsp;</h3>
                                        <div class="display-4">73<sup>°F</sup></div>
                                        <p class="text-white">AHMEDABAD, INDIA</p>
                                    </div>
                                    <div class="col-6 text-end">
                                        <h1 class="m-b-"><i class="wi wi-day-cloudy-high"></i></h1>
                                        <b class="text-white">SUNNEY DAY</b>
                                        <p class="op-5">April 14</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-md-12">
                        <div class="card bg-primary text-white">
                            <div class="card-body">
                                <div id="myCarouse2" class="carousel slide" data-bs-ride="carousel">
                                    <!-- Carousel items -->
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <h4 class="cmin-height">My Acting blown <span class="font-medium">Your
                                                    Mind</span> and you also <br />laugh at the moment</h4>
                                            <div class="d-flex no-block">
                                                <span><img src="../assets/images/users/1.jpg" alt="user"
                                                        width="50" class="img-circle"></span>
                                                <span class="m-l-10">
                                                    <h4 class="text-white m-b-0">Govinda</h4>
                                                    <p class="text-white">Actor</p>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="carousel-item">
                                            <h4 class="cmin-height">My Acting blown <span class="font-medium">Your
                                                    Mind</span> and you also <br />laugh at the moment</h4>
                                            <div class="d-flex no-block">
                                                <span><img src="../assets/images/users/2.jpg" alt="user"
                                                        width="50" class="img-circle"></span>
                                                <span class="m-l-10">
                                                    <h4 class="text-white m-b-0">Govinda</h4>
                                                    <p class="text-white">Actor</p>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="carousel-item">
                                            <h4 class="cmin-height">My Acting blown <span class="font-medium">Your
                                                    Mind</span> and you also <br />laugh at the moment</h4>
                                            <div class="d-flex no-block">
                                                <span><img src="../assets/images/users/3.jpg" alt="user"
                                                        width="50" class="img-circle"></span>
                                                <span class="m-l-10">
                                                    <h4 class="text-white m-b-0">Govinda</h4>
                                                    <p class="text-white">Actor</p>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
            </div>
        </div> --}}
        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
@endsection

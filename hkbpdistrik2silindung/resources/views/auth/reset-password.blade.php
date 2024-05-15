<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/favicon.png">
    <title>SIAK HKBP PALMARUM - Reset Password</title>

    <!-- page css -->
    <link href="{{ asset('admin_resources/assets_layout/css/pages/login-register-lock.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('admin_resources/assets_layout/css/style.min.css') }}" rel="stylesheet">
    <script src="{{ asset('admin_resources/assets/node_modules/toast-master/js/jquery.toast.js') }}"></script>

     <!--Custom JavaScript -->
     <script src="{{ asset('admin_resources/assets_layout/js/custom.min.js') }}"></script>
     <script src="{{ asset('admin_resources/assets/node_modules/toast-master/js/jquery.toast.js') }}"></script>
     <script src="{{ asset('admin_resources/assets_layout/js/pages/toastr.js') }}"></script>
     <script src="{{ asset('admin_resources/assets/node_modules/select2/dist/js/select2.full.min.js') }}" type="text/javascript"></script>
     <script src="{{ asset('admin_resources/assets/node_modules/bootstrap-select/bootstrap-select.min.js') }}" type="text/javascript"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">Reset Password</p>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <section id="wrapper" class="login-register login-sidebar" style="background-image:url(../assets/images/background/login-register.jpg);">
        <div class="login-box card">
            <div class="card-body">
                <form class="mt-4 needs-validation" action="{{ route('password.update') }}" method="POST" novalidate>
                    <div class="text-center">
                        <a href="javascript:void(0)" class="db"><img src="../assets/images/logo-icon.png" alt="Home" /><br/><img src="../assets/images/logo-text.png" alt="Home" /></a>
                    </div>
                    <h3 class="box-title m-t-40 m-b-0">Reset Password</h3>
                    @csrf

                    <input type="hidden" name="token" value="{{ request()->token }}">

                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <input class="form-control @error('email') is-invalid @enderror" type="text" name="email" placeholder="Email" value="{{ old('email') }}" required>
                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" placeholder="Password" required autocomplete="new-password">
                            @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <input class="form-control" type="password" name="password_confirmation" placeholder="Confirm Password" required autocomplete="new-password">
                        </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-lg w-100 text-uppercase btn-rounded text-white" type="submit">Reset Password</button>
                        </div>
                    </div>
                </form>

                <script>
                    // Example starter JavaScript for disabling form submissions if there are invalid fields
                    (function() {
                        'use strict';
                        window.addEventListener('load', function() {
                            // Fetch all the forms we want to apply custom Bootstrap validation styles to
                            var forms = document.getElementsByClassName('needs-validation');
                            // Loop over them and prevent submission
                            var validation = Array.prototype.filter.call(forms, function(form) {
                                form.addEventListener('submit', function(event) {
                                    if (form.checkValidity() === false) {
                                        event.preventDefault();
                                        event.stopPropagation();
                                    }
                                    form.classList.add('was-validated');
                                    // Retrieve all the input fields within the form
                                    var inputs = form.querySelectorAll('input, textarea, select');
                                    // Loop through each input field
                                    inputs.forEach(function(input) {
                                        // Check if the input field has validation errors
                                        if (!input.checkValidity()) {
                                            // Find the corresponding invalid feedback element
                                            var feedback = input.parentElement.querySelector('.invalid-feedback');
                                            // Display the validation error message
                                            feedback.style.display = 'block';
                                        }
                                    });
                                }, false);
                            });
                        }, false);
                    })();
                </script>

            </div>
        </div>
    </section>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{ asset('admin_resources/assets_layout/script/assets/node_modules/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('admin_resources/assets_layout/script/assets/node_modules/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            $(".preloader").fadeOut();
        });
        $(function() {
            $('[data-bs-toggle="tooltip"]').tooltip()
        });
        // ==============================================================
        // Login and Recover Password
        // ==============================================================
        $('#to-recover').on("click", function() {
            $("#loginform").slideUp();
            $("#recoverform").fadeIn();
        });
    </script>
</body>

</html>

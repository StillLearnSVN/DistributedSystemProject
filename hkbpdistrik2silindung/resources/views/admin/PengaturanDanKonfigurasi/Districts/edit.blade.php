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
            <h4 class="text-themecolor">Districts</h4>
        </div>
        <div class="col-md-7 align-self-center text-end">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item">Pengaturan & Konfigurasi</li>
                    <li class="breadcrumb-item">General</li>
                    <li class="breadcrumb-item active"><a href="{{ route('Districts.index') }}" style="color:inherit">Districts</a></li>
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
    <!-- row -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Edit District</h4>
                    <h6 class="card-subtitle"> Form Edit District </h6>
                    @if (isset($district))
                    <form class="mt-4 needs-validation"
                        action="{{ route('Districts.update', $district->dis_id) }}"
                        method="POST" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="district_name">District Name<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="district_name" name="dis_name"
                                    value="{{ $district->dis_name }}"
                                    placeholder="Enter District Name" required>
                                <div class="invalid-feedback">
                                    District Name cannot be empty.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="city">City<span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="city" name="city_id" required>
                                    <!-- Populate options dynamically from database -->
                                    @foreach ($cities as $city)
                                    <option value="{{ $city->city_id }}" {{ $city->city_id == $district->city_id ? 'selected' : '' }}>{{ $city->city_name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Please select a City.
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="text-end">
                                <button type="submit" class="btn btn-info waves-effect waves-light m-r-10 text-white"> Edit </button>
                                <button type="reset" class="btn btn-danger waves-effect waves-light"> Cancel </button>
                            </div>
                        </div>
                    </form>
                    @endif
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
                                }, false);
                            });
                        }, false);
                    })();
                    </script>
                </div>
            </div>
        </div>
    </div>
    <!-- row -->
    <!-- ============================================================== -->
    <!-- End PAge Content -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Container fluid  -->
<!-- ============================================================== -->
@endsection

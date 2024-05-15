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
            <h4 class="text-themecolor">Negara</h4>
        </div>
        <div class="col-md-7 align-self-center text-end">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item">Pengaturan & Konfigurasi</li>
                    <li class="breadcrumb-item">General</li>
                    <li class="breadcrumb-item active"><a href="{{ route('Country.index') }}" style="color:inherit">Negara</a></li>
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
                    <h4 class="card-title">Edit Negara</h4>
                    <h6 class="card-subtitle"> Form Edit Negara </h6>
                    @if (isset($country))
                    <form class="mt-4 needs-validation"
                        action="{{ route('Country.update', $country['country_id']) }}"
                        method="POST" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="validationCustom01">Kode Negara<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="validationCustom01" name="country_code"
                                    value="{{ $country['country_code'] }}"
                                    placeholder="Enter Kode Negara" required>
                                <div class="invalid-feedback">
                                    Kode Negara tidak boleh kosong.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="validationCustom02">Nama negara<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="validationCustom02" name="country_name"
                                    value="{{ $country['country_name'] }}"
                                    placeholder="Enter Nama negara" required>
                                <div class="invalid-feedback">
                                    Nama negara tidak boleh kosong.
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="validationCustom03">Kode<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="validationCustom03" name="code"
                                    value="{{ $country['code'] }}"
                                    placeholder="Enter Code" required>
                                <div class="invalid-feedback">
                                    Kode tidak boleh kosong.
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

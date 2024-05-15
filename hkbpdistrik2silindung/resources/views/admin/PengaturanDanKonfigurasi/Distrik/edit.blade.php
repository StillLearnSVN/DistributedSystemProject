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
            <h4 class="text-themecolor">Distriks</h4>
        </div>
        <div class="col-md-7 align-self-center text-end">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item">Pengaturan & Konfigurasi</li>
                    <li class="breadcrumb-item">General</li>
                    <li class="breadcrumb-item active"><a href="{{ route('Distrik.index') }}"
                            style="color:inherit">Distriks</a></li>
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
                    <h4 class="card-title">Edit Distrik</h4>
                    <h6 class="card-subtitle"> Form Edit Distrik </h6>
                    <form class="mt-4 needs-validation" action="{{ route('Distrik.update', $distrik->id_distrik) }}"
                        method="POST" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="distrik_name">Nama Distrik<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="distrik_name" name="nama_distrik"
                                    value="{{ $distrik->nama_distrik }}" required>
                                <div class="invalid-feedback">
                                    Nama Distrik tidak boleh kosong.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="praeses_distrik_name">Nama Praeses<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="praeses_distrik_name" name="nama_praeses"
                                    value="{{ $distrik->nama_praeses }}" required>
                                <div class="invalid-feedback">
                                    Nama Praeses tidak boleh kosong.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="distrik_code">Kode Distrik<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="distrik_code" name="kode_distrik"
                                    value="{{ $distrik->kode_distrik }}" required>
                                <div class="invalid-feedback">
                                    Kode Distrik tidak boleh kosong.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="distrik_address">Alamat Distrik<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="distrik_code" name="alamat"
                                    value="{{ $distrik->alamat }}" required>
                                <div class="invalid-feedback">
                                    Alamat Distrik tidak boleh kosong.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="subdistrict">Subdistrict<span
                                        class="text-danger">*</span></label>
                                <select class="form-select" name="subdis_id" required>
                                    <option value="">Pilih Subdistrict</option>
                                    <!-- Populate options dynamically from database -->
                                    @foreach ($subdistricts as $subdistrict)
                                    <option value="{{ $subdistrict->subdis_id }}"
                                        {{ $subdistrict->subdis_id == $distrik->subdis_id ? 'selected' : '' }}>
                                        {{ $subdistrict->subdis_name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Pilih Subdistrict.
                                </div>
                            </div>
                            <!-- You can add more fields here -->
                        </div>
                        <div class="row">
                            <div class="text-end">
                                <button type="submit"
                                    class="btn btn-info waves-effect waves-light m-r-10 text-white"> Simpan </button>
                                <a href="{{ route('Distrik.index') }}"
                                    class="btn btn-danger waves-effect waves-light"> Batal </a>
                            </div>
                        </div>
                    </form>
                    <script>
                        // Example starter JavaScript for disabling form submissions if there are invalid fields
                        (function () {
                            'use strict';
                            window.addEventListener('load', function () {
                                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                                var forms = document.getElementsByClassName('needs-validation');
                                // Loop over them and prevent submission
                                var validation = Array.prototype.filter.call(forms, function (form) {
                                    form.addEventListener('submit', function (event) {
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

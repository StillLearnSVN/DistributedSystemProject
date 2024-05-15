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
            <h4 class="text-themecolor">Ressorts</h4>
        </div>
        <div class="col-md-7 align-self-center text-end">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item">Pengaturan & Konfigurasi</li>
                    <li class="breadcrumb-item">General</li>
                    <li class="breadcrumb-item active"><a href="{{ route('Ressort.index') }}"
                            style="color:inherit">Ressorts</a></li>
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
                    <h4 class="card-title">Edit Ressort</h4>
                    <h6 class="card-subtitle"> Form Edit Ressort </h6>
                    <form class="mt-4 needs-validation" action="{{ route('Ressort.update', $ressort->id_ressort) }}"
                        method="POST" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="ressort_name">Nama Ressort<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="ressort_name" name="nama_ressort"
                                    value="{{ $ressort->nama_ressort }}" required>
                                <div class="invalid-feedback">
                                    Nama Ressort tidak boleh kosong.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="pendeta_ressort">Nama Pendeta Ressort<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="pendeta_ressort" name="pendeta_ressort"
                                    value="{{ $ressort->pendeta_ressort }}" required>
                                <div class="invalid-feedback">
                                    Nama Pendeta Ressort tidak boleh kosong.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="ressort_code">Kode Ressort<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="ressort_code" name="kode_ressort"
                                    value="{{ $ressort->kode_ressort }}" required>
                                <div class="invalid-feedback">
                                    Kode Ressort tidak boleh kosong.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="ressort_address">Alamat Ressort<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="ressort_address" name="alamat"
                                    value="{{ $ressort->alamat }}" required>
                                <div class="invalid-feedback">
                                    Alamat Ressort tidak boleh kosong.
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
                                        {{ $subdistrict->subdis_id == $ressort->subdis_id ? 'selected' : '' }}>
                                        {{ $subdistrict->subdis_name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Pilih Subdistrict.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="district">District<span
                                        class="text-danger">*</span></label>
                                <select class="form-select" name="id_distrik" required>
                                    <option value="">Pilih District</option>
                                    <!-- Populate options dynamically from database -->
                                    @foreach ($distriks as $distrik)
                                    <option value="{{ $distrik->id_distrik }}"
                                        {{ $distrik->id_distrik == $ressort->id_distrik ? 'selected' : '' }}>
                                        {{ $distrik->nama_distrik }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Pilih District.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="tgl_berdiri">Tanggal Berdiri<span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="tgl_berdiri" name="tgl_berdiri"
                                    value="{{ $ressort->tgl_berdiri }}" required>
                                <div class="invalid-feedback">
                                    Tanggal Berdiri tidak boleh kosong.
                                </div>
                            </div>
                            <!-- You can add more fields here -->
                        </div>
                        <div class="row">
                            <div class="text-end">
                                <button type="submit"
                                    class="btn btn-info waves-effect waves-light m-r-10 text-white"> Simpan </button>
                                <a href="{{ route('Ressort.index') }}"
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

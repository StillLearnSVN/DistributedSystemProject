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
            <h4 class="text-themecolor">Gerejas</h4>
        </div>
        <div class="col-md-7 align-self-center text-end">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item">Pengaturan & Konfigurasi</li>
                    <li class="breadcrumb-item">General</li>
                    <li class="breadcrumb-item active"><a href="{{ route('Gereja.index') }}"
                            style="color:inherit">Gerejas</a></li>
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
                    <h4 class="card-title">Tambah Gereja</h4>
                    <h6 class="card-subtitle"> Form Tambah Gereja Baru </h6>
                    <form class="mt-4 needs-validation" action="{{ route('Gereja.store') }}" method="POST"
                        novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="gereja_name">Nama Gereja<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="gereja_name" name="nama_gereja"
                                    placeholder="Masukkan Nama Gereja" required>
                                <div class="invalid-feedback">
                                    Nama Gereja tidak boleh kosong.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="subdistrict">Jenis Gereja<span
                                        class="text-danger">*</span></label>
                                <select class="form-select" name="id_jenis_gereja" required>
                                    <option value="">Pilih Jenis Gereja</option>
                                    <!-- Populate options dynamically from database -->
                                    @foreach ($jenisGerejas as $jenisGereja)
                                    <option value="{{ $jenisGereja->id_jenis_gereja }}">{{ $jenisGereja->jenis_gereja  }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Pilih Jenis Gereja.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="pendeta_gereja">Nama Pendeta Gereja<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="pendeta_gereja" name="nama_pendeta"
                                    placeholder="Masukkan Nama Pendeta Gereja" required>
                                <div class="invalid-feedback">
                                    Nama Pendeta Gereja tidak boleh kosong.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="gereja_code">Kode Gereja<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="gereja_code" name="kode_gereja"
                                    placeholder="Masukkan Kode Gereja" required>
                                <div class="invalid-feedback">
                                    Kode Gereja tidak boleh kosong.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="gereja_address">Alamat Gereja<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="gereja_address" name="alamat"
                                    placeholder="Masukkan Alamat Gereja" required>
                                <div class="invalid-feedback">
                                    Alamat Gereja tidak boleh kosong.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="subdistrict">Subdistrict<span
                                        class="text-danger">*</span></label>
                                <select class="form-select" name="subdis_id" required>
                                    <option value="">Pilih Subdistrict</option>
                                    <!-- Populate options dynamically from database -->
                                    @foreach ($subdistricts as $subdistrict)
                                    <option value="{{ $subdistrict->subdis_id }}">{{ $subdistrict->subdis_name  }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Pilih Subdistrict.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="ressort">Ressort<span
                                        class="text-danger">*</span></label>
                                <select class="form-select" name="id_ressort" required>
                                    <option value="">Pilih Ressort</option>
                                    <!-- Populate options dynamically from database -->
                                    @foreach ($ressorts as $ressort)
                                    <option value="{{ $ressort->id_ressort }}">{{ $ressort->nama_ressort }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Pilih Ressort.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="tgl_berdiri">Tanggal Berdiri<span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="tgl_berdiri" name="tgl_berdiri"
                                    required>
                                <div class="invalid-feedback">
                                    Tanggal Berdiri tidak boleh kosong.
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="text-end">
                                <button type="submit"
                                    class="btn btn-info waves-effect waves-light m-r-10 text-white"> Buat </button>
                                <button type="reset" class="btn btn-danger waves-effect waves-light"> Batal </button>
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

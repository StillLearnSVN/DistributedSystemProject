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
            <h4 class="text-themecolor">Majelis Lingkungan</h4>
        </div>
        <div class="col-md-7 align-self-center text-end">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item">Pengaturan & Konfigurasi</li>
                    <li class="breadcrumb-item">General</li>
                    <li class="breadcrumb-item active"><a href="{{ route('MajelisLingkungan.index') }}"
                            style="color:inherit">Majelis Lingkungan</a></li>
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
                    <h4 class="card-title">Tambah Majelis Lingkungan</h4>
                    <h6 class="card-subtitle"> Form Tambah Data Majelis Lingkungan Baru </h6>
                    <form class="mt-4 needs-validation" action="{{ route('MajelisLingkungan.store') }}" method="POST" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="id_majelis">Nama Majelis<span
                                        class="text-danger">*</span></label>
                                        <select class="form-select" name="id_majelis">
                                            <option value="">Nama Majelis</option>
                                            @foreach ($majelis as $majels)
                                                <option value="{{ $majels->id_jemaat }}">{{ $majels->gelar_depan }}{{ $majels->nama_depan }} {{ $majels->nama_belakang }} {{ $majels->gelar_belakang }}</option>
                                            @endforeach
                                        </select>
                                <div class="invalid-feedback">
                                    ID Majelis tidak boleh kosong.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="id_wijk">ID Wijk<span
                                        class="text-danger">*</span></label>
                                        <select class="form-select" name="id_wijk">
                                            <option value="">Pilih Lingkungan Majelis</option>
                                            @foreach ($wijks as $wijk)
                                                <option value="{{ $wijk->id_wijk }}">{{ $wijk->nama_wijk }}</option>
                                            @endforeach
                                        </select>
                                <div class="invalid-feedback">
                                    ID Wijk tidak boleh kosong.
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="text-end">
                                <button type="submit"
                                    class="btn btn-info waves-effect waves-light m-r-10 text-white"> Buat </button>
                                <button type="button" class="btn btn-danger waves-effect waves-light" onclick="redirectToIndex()"> Batal </button>
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

                        function redirectToIndex() {
                            window.location.href = "{{ route('MajelisLingkungan.index') }}";
                        }
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

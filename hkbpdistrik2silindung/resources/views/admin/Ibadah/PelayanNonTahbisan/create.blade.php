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
            <h4 class="text-themecolor">Pelayan Non Tahbisan</h4>
        </div>
        <div class="col-md-7 align-self-center text-end">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item">Pengaturan & Konfigurasi</li>
                    <li class="breadcrumb-item">General</li>
                    <li class="breadcrumb-item active"><a href="{{ route('PelayanNonTahbisan.index') }}"
                            style="color:inherit">Pelayan Non Tahbisan</a></li>
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
                    <h4 class="card-title">Tambah Pelayan Non Tahbisan</h4>
                    <h6 class="card-subtitle"> Form Tambah Data Pelayan Non Tahbisan Baru </h6>
                    <form class="mt-4 needs-validation" action="{{ route('PelayanNonTahbisan.store') }}" method="POST" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="nama_jemaat">Nama Jemaat<span
                                        class="text-danger">*</span></label>
                                        <select class="form-select" name="id_majelis">
                                            <option value="">Nama Majelis</option>
                                            @foreach ($majelis as $majels)
                                                <option value="{{ $majels->id_jemaat }}">{{ $majels->gelar_depan }}{{ $majels->nama_depan }} {{ $majels->nama_belakang }} {{ $majels->gelar_belakang }}</option>
                                            @endforeach
                                        </select>
                                <div class="invalid-feedback">
                                    Nama Jemaat tidak boleh kosong.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="pelayan_gereja">Pelayan Gereja<span
                                        class="text-danger">*</span></label>
                                        <select class="form-select" name="id_pelayan_gereja">
                                            <option value="">Nama Majelis</option>
                                            @foreach ($pelayanGereja as $pg)
                                                <option value="{{ $pg->id_pelayan_gereja }}">{{ $pg->gelar_depan }}{{ $pg->nama_depan }} {{ $pg->nama_belakang }} {{ $pg->gelar_belakang }}</option>
                                            @endforeach
                                        </select>
                                <div class="invalid-feedback">
                                    Pelayan Gereja tidak boleh kosong.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="gereja">Gereja<span
                                        class="text-danger">*</span></label>
                                        <select class="form-select" name="id_gereja" required>
                                            <option value="">Pilih Gereja</option>
                                            @foreach ($gerejas as $gereja)
                                            <option value="{{ $gereja->id_gereja }}">{{ $gereja->nama_gereja  }}</option>
                                            @endforeach
                                        </select>
                                <div class="invalid-feedback">
                                    Nama Gereja tidak boleh kosong.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="status_pelayanan">Status Pelayanan<span
                                        class="text-danger">*</span></label>
                                        <select class="form-select" name="id_status_pelayanan">
                                            <option value="">Status Pelayanan</option>
                                            @foreach ($statuses as $statusx)
                                            <option value="{{ $statusx->id_status }}">{{ $statusx->status  }}</option>
                                            @endforeach
                                        </select>
                                <div class="invalid-feedback">
                                    Status Pelayanan tidak boleh kosong.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="nama_pelayanan_nonTahbisan">Nama Pelayanan Non Tahbisan<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama_pelayanan_nonTahbisan" name="nama_pelayanan_nonTahbisan" required>
                                <div class="invalid-feedback">
                                    Nama Pelayanan Non Tahbisan tidak boleh kosong.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="tgl_pengangkatan">Tanggal Pengangkatan<span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="tgl_pengangkatan" name="tgl_pengangkatan" required>
                                <div class="invalid-feedback">
                                    Tanggal Pengangkatan tidak boleh kosong.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="tgl_berakhir">Tanggal Berakhir<span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="tgl_berakhir" name="tgl_berakhir" required>
                                <div class="invalid-feedback">
                                    Tanggal Berakhir tidak boleh kosong.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="keterangan">Keterangan</label>
                                <textarea class="form-control" id="keterangan" name="keterangan"></textarea>
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
                            window.location.href = "{{ route('PelayanNonTahbisan.index') }}";
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

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
            <h4 class="text-themecolor">Meninggal</h4>
        </div>
        <div class="col-md-7 align-self-center text-end">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item">Pengaturan & Konfigurasi</li>
                    <li class="breadcrumb-item">General</li>
                    <li class="breadcrumb-item active"><a href="{{ route('Meninggal.index') }}"
                            style="color:inherit">Meninggal</a></li>
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
                    <h4 class="card-title">Tambah Meninggal</h4>
                    <h6 class="card-subtitle"> Form Tambah Data Meninggal Baru </h6>
                    <form class="mt-4 needs-validation" action="{{ route('Meninggal.store') }}" method="POST" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="nama_jemaat">Nama Jemaat<span
                                        class="text-danger">*</span></label>
                                        <select class="form-select" name="id_jemaat">
                                            <option value="">Nama Jemaat</option>
                                            @foreach ($jemaats as $jemaat)
                                                <option value="{{ $jemaat->id_jemaat }}">{{ $jemaat->gelar_depan }}{{ $jemaat->nama_depan }} {{ $jemaat->nama_belakang }} {{ $jemaat->gelar_belakang }}</option>
                                            @endforeach
                                        </select>
                                <div class="invalid-feedback">
                                    Nama Jemaat tidak boleh kosong.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="status">Status<span
                                        class="text-danger">*</span></label>
                                        <select class="form-select" name="id_status">
                                            <option value="">Status</option>
                                            <!-- Populate options dynamically from database -->
                                            @foreach ($statuses as $statusx)
                                            <option value="{{ $statusx->id_status }}">{{ $statusx->status  }}</option>
                                            @endforeach
                                        </select>
                                <div class="invalid-feedback">
                                    Status tidak boleh kosong.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="tgl_meninggal">Tanggal Meninggal<span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="tgl_meninggal" name="tgl_meninggal" required>
                                <div class="invalid-feedback">
                                    Tanggal Meninggal tidak boleh kosong.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="tgl_warta_meninggal">Tanggal Warta Meninggal<span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="tgl_warta_meninggal" name="tgl_warta_meninggal" required>
                                <div class="invalid-feedback">
                                    Tanggal Warta Meninggal tidak boleh kosong.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="tempat_pemakaman">Tempat Pemakaman<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="tempat_pemakaman" name="tempat_pemakaman"
                                    placeholder="Masukkan Tempat Pemakaman" required>
                                <div class="invalid-feedback">
                                    Tempat Pemakaman tidak boleh kosong.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="nama_pendeta_melayani">Nama Pendeta Melayani<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama_pendeta_melayani" name="nama_pendeta_melayani"
                                    placeholder="Masukkan Nama Pendeta Melayani" required>
                                <div class="invalid-feedback">
                                    Nama Pendeta Melayani tidak boleh kosong.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="gereja">Gereja<span
                                        class="text-danger">*</span></label>
                                <select class="form-select" name="id_gereja">
                                    <option value="">Pilih Gereja</option>
                                    <!-- Populate options dynamically from database -->
                                    @foreach ($gerejas as $gereja)
                                    <option value="{{ $gereja->id_gereja }}">{{ $gereja->nama_gereja  }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Gereja tidak boleh kosong.
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label" for="validationCustom01">Keterangan</label>
                                    <textarea class="form-control" rows="5" name="keterangan" placeholder="Masukkan Keterangan"></textarea>
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
                            window.location.href = "{{ route('Meninggal.index') }}";
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

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
            <h4 class="text-themecolor">Jemaat</h4>
        </div>
        <div class="col-md-7 align-self-center text-end">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item">Pengaturan & Konfigurasi</li>
                    <li class="breadcrumb-item">General</li>
                    <li class="breadcrumb-item active"><a href="{{ route('Jemaat.index') }}" style="color:inherit">Jemaat</a></li>
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
                    <h4 class="card-title">Edit Jemaat</h4>
                    <h6 class="card-subtitle"> Form Edit Data Jemaat </h6>
                    <form class="mt-4 needs-validation" action="{{ route('Jemaat.update', $jemaat->id_jemaat) }}" method="POST" enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="gelar_depan">Gelar Depan
                                <input type="text" class="form-control" id="gelar_depan" name="gelar_depan"
                                    placeholder="Masukkan Nama Depan" value="{{ $jemaat->gelar_depan }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="nama_depan">Nama Depan<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama_depan" name="nama_depan"
                                    placeholder="Masukkan Nama Depan" value="{{ $jemaat->nama_depan }}" required>
                                <div class="invalid-feedback">
                                    Nama Depan tidak boleh kosong.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="nama_belakang">Nama Belakang<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama_belakang" name="nama_belakang"
                                    placeholder="Masukkan Nama Belakang" value="{{ $jemaat->nama_belakang }}" required>
                                <div class="invalid-feedback">
                                    Nama Belakang tidak boleh kosong.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="gelar_belakang">Gelar Belakang
                                <input type="text" class="form-control" id="gelar_belakang" name="gelar_belakang"
                                    placeholder="Masukkan Nama Belakang" value="{{ $jemaat->gelar_belakang }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="tempat_lahir">Tempat Lahir<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                                    placeholder="Masukkan Tempat Lahir" value="{{ $jemaat->tempat_lahir }}" required>
                                <div class="invalid-feedback">
                                    Tempat Lahir tidak boleh kosong.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="tanggal_lahir">Tanggal Lahir<span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                                    value="{{ $jemaat->tanggal_lahir }}" required>
                                <div class="invalid-feedback">
                                    Tanggal Lahir tidak boleh kosong.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="jenis_kelamin">Jenis Kelamin<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="jenis_kelamin" name="jenis_kelamin"
                                    placeholder="Laki-laki atau Perempuan" value="{{ $jemaat->jenis_kelamin }}" required>
                                <div class="invalid-feedback">
                                    Jenis Kelamin tidak boleh kosong.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="subdistrict">Status Pernikahan<span
                                        class="text-danger">*</span></label>
                                <select class="form-select" name="id_status_pernikahan">
                                    <option value="">Pilih Status Pernikahan</option>
                                    <!-- Populate options dynamically from database -->
                                    @foreach ($statuses as $statusx)
                                    <option value="{{ $statusx->id_status }}" {{ $jemaat->id_status_pernikahan == $statusx->id_status ? 'selected' : '' }}>{{ $statusx->status  }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="subdistrict">Status Ama Ina<span
                                        class="text-danger">*</span></label>
                                <select class="form-select" name="id_status_ama_ina">
                                    <option value="">Pilih Status Ama Ina</option>
                                    <!-- Populate options dynamically from database -->
                                    @foreach ($statuses as $statusx)
                                    <option value="{{ $statusx->id_status }}" {{ $jemaat->id_status_ama_ina == $statusx->id_status ? 'selected' : '' }}>{{ $statusx->status  }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="subdistrict">Status Anak<span
                                        class="text-danger">*</span></label>
                                <select class="form-select" name="id_status_anak">
                                    <option value="">Pilih Status Anak</option>
                                    <!-- Populate options dynamically from database -->
                                    @foreach ($statuses as $statusx)
                                    <option value="{{ $statusx->id_status }}" {{ $jemaat->id_status_anak == $statusx->id_status ? 'selected' : '' }}>{{ $statusx->status  }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="subdistrict">Hubungan Keluarga<span
                                        class="text-danger">*</span></label>
                                <select class="form-select" name="id_hub_keluarga">
                                    <option value="">Pilih Hubungan Keluarga</option>
                                    <!-- Populate options dynamically from database -->
                                    @foreach ($hubunganKeluargas as $hubunganKeluarga)
                                    <option value="{{ $hubunganKeluarga->id_hub_keluarga }}" {{ $jemaat->id_hub_keluarga == $hubunganKeluarga->id_hub_keluarga ? 'selected' : '' }}>{{ $hubunganKeluarga->nama_hub_keluarga  }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="subdistrict">Bidang Pendidikan<span
                                        class="text-danger">*</span></label>
                                <select class="form-select" name="id_bidang_pendidikan">
                                    <option value="">Pilih Bidang Pendidikan</option>
                                    <!-- Populate options dynamically from database -->
                                    @foreach ($bidangPendidikans as $bidangPendidikan)
                                    <option value="{{ $bidangPendidikan->id_bidang_pendidikan }}" {{ $jemaat->id_bidang_pendidikan == $bidangPendidikan->id_bidang_pendidikan ? 'selected' : '' }}>{{ $bidangPendidikan->nama_bidang_pendidikan  }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="bidang_pendidikan_lain">Bidang Pendidikan Lainnya<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="bidang_pendidikan_lain" name="bidang_pendidikan_lain"
                                    placeholder="Pekerjaan lainnya" value="{{ $jemaat->bidang_pendidikan_lain }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="subdistrict">Pendidikan<span
                                        class="text-danger">*</span></label>
                                <select class="form-select" name="id_pendidikan">
                                    <option value="">Pilih Pendidikan</option>
                                    <!-- Populate options dynamically from database -->
                                    @foreach ($pendidikans as $pendidikanx)
                                    <option value="{{ $pendidikanx->id_pendidikan }}" {{ $jemaat->id_pendidikan == $pendidikanx->id_pendidikan ? 'selected' : '' }}>{{ $pendidikanx->pendidikan  }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="subdistrict">Pekerjaan<span
                                        class="text-danger">*</span></label>
                                <select class="form-select" name="id_pekerjaan">
                                    <option value="">Pilih Pekerjaan</option>
                                    <!-- Populate options dynamically from database -->
                                    @foreach ($pekerjaans as $pekerjaanx)
                                    <option value="{{ $pekerjaanx->id_pekerjaan }}" {{ $jemaat->id_pekerjaan == $pekerjaanx->id_pekerjaan ? 'selected' : '' }}>{{ $pekerjaanx->pekerjaan  }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="nama_pekerjaan_lain">Pekerjaan Lainnya<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama_pekerjaan_lain" name="nama_pekerjaan_lain"
                                    placeholder="Pekerjaan lainnya" value="{{ $jemaat->nama_pekerjaan_lain }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="gol_darah">Golongan Darah<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="gol_darah" name="gol_darah"
                                    placeholder="Golongan Darah" value="{{ $jemaat->gol_darah }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="alamat">Alamat<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="alamat" name="alamat"
                                    placeholder="Alamat" value="{{ $jemaat->alamat }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="no_ponsel">No Ponsel<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="no_ponsel" name="no_ponsel"
                                    placeholder="No Ponsel" value="{{ $jemaat->no_ponsel }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="keterangan">Keterangan<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="keterangan" name="keterangan"
                                    placeholder="Keterangan" value="{{ $jemaat->keterangan }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="subdistrict">Subdistrict<span
                                        class="text-danger">*</span></label>
                                <select class="form-select" name="subdis_id">
                                    <option value="">Pilih Subdistrict</option>
                                    <!-- Populate options dynamically from database -->
                                    @foreach ($subdistricts as $subdis)
                                    <option value="{{ $subdis->subdis_id }}" {{ $jemaat->subdis_id == $subdis->subdis_id ? 'selected' : '' }}>{{ $subdis->subdis_name  }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="subdistrict">Gereja<span
                                        class="text-danger">*</span></label>
                                <select class="form-select" name="id_gereja">
                                    <option value="">Pilih Gereja</option>
                                    <!-- Populate options dynamically from database -->
                                    @foreach ($gerejas as $gereja)
                                    <option value="{{ $gereja->id_gereja }}" {{ $gereja->id_gereja == $gereja->id_gereja ? 'selected' : '' }}>{{ $gereja->nama_gereja  }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="subdistrict">Wijk<span
                                        class="text-danger">*</span></label>
                                <select class="form-select" name="id_wijk">
                                    <option value="">Pilih Wijk</option>
                                    <!-- Populate options dynamically from database -->
                                    @foreach ($wijks as $wijk)
                                    <option value="{{ $wijk->id_wijk }}" {{ $wijk->id_wijk == $wijk->id_wijk ? 'selected' : '' }}>{{ $wijk->nama_wijk  }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="text-end">
                                <button type="submit" class="btn btn-info waves-effect waves-light m-r-10 text-white"> Simpan </button>
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

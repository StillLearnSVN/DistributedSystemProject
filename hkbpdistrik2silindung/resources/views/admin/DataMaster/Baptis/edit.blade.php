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
            <h4 class="text-themecolor">Edit Baptis</h4>
        </div>
        <div class="col-md-7 align-self-center text-end">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item">Pengaturan & Konfigurasi</li>
                    <li class="breadcrumb-item">General</li>
                    <li class="breadcrumb-item active"><a href="{{ route('Baptis.index') }}"
                            style="color:inherit">Baptis</a></li>
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
                    <form class="mt-4 needs-validation" action="{{ route('Baptis.update', $baptis->id_baptis) }}" method="POST"
                        novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="nama_jemaat">Nama Jemaat<span
                                        class="text-danger">*</span></label>
                                <select class="form-select" name="id_jemaat" required>
                                    <option value="">Nama Jemaat</option>
                                    @foreach ($jemaats as $jemaat)
                                    <option value="{{ $jemaat->id_jemaat }}" {{ $baptis->id_jemaat == $jemaat->id_jemaat ? 'selected' : '' }}>{{ $jemaat->gelar_depan }}{{ $jemaat->nama_depan }} {{ $jemaat->nama_belakang }} {{ $jemaat->gelar_belakang }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Nama Jemaat tidak boleh kosong.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="subdistrict">Status<span
                                        class="text-danger">*</span></label>
                                <select class="form-select" name="id_status">
                                    <option value="">Pilih Status</option>
                                    @foreach ($statuses as $statusx)
                                    <option value="{{ $statusx->id_status }}" {{ $statusx->id_status == $statusx->id_status ? 'selected' : '' }}>{{ $statusx->status  }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Status tidak boleh kosong.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="tgl_baptis">Tanggal Baptis<span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="tgl_baptis" name="tgl_baptis" value="{{ $baptis->tgl_baptis }}" required>
                                <div class="invalid-feedback">
                                    Tanggal Baptis tidak boleh kosong.
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="no_surat_baptis">Nomor Surat Baptis<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="no_surat_baptis" name="no_surat_baptis"
                                    value="{{ $baptis->no_surat_baptis }}" required>
                                <div class="invalid-feedback">
                                    Nomor Surat Baptis tidak boleh kosong.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="gereja_baptis">Gereja Baptis<span
                                        class="text-danger">*</span></label>
                                <select class="form-select" name="id_gereja_baptis" required>
                                    <option value="">Pilih Gereja Baptis</option>
                                    <!-- Populate options dynamically from database -->
                                    @foreach ($gerejas as $gereja)
                                    <option value="{{ $gereja->id_gereja }}" {{ $baptis->gereja_baptis_name == $gereja->nama_gereja ? 'selected' : '' }}>{{ $gereja->nama_gereja }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Gereja Baptis tidak boleh kosong.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="gereja_sidi">Gereja Non HKBP</label>
                                <input type="text" class="form-control" id="gereja_sidi" name="nama_gereja_non_hkbp"
                                    value="{{ $baptis->nama_gereja_non_HKBP }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="nama_pendeta_baptis">Nama Pendeta Baptis<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama_pendeta_baptis"
                                    name="nama_pendeta_baptis" value="{{ $baptis->nama_pendeta_baptis }}" required>
                                <div class="invalid-feedback">
                                    Nama Pendeta Baptis tidak boleh kosong.
                                </div>
                            </div>
                        </div>
                        <!-- Display current file for File Surat Baptis field -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">File Surat Baptis<span class="text-danger">*</span></label>
                                <p>Current File: {{ $baptis->file_surat_baptis }}</p>
                                <!-- Display current file name in a text input field -->
                                <input type="text" class="form-control" value="{{ $baptis->file_surat_baptis }}" readonly>
                                <!-- Allow users to select a new file -->
                                <input type="file" class="form-control mt-2" id="file_surat_baptis" name="file_surat_baptis">
                                <div class="invalid-feedback">
                                    File Surat Baptis tidak boleh kosong.
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="keterangan">Keterangan</label>
                                <textarea class="form-control" rows="5" name="keterangan"
                                    placeholder="Masukkan Keterangan">{{ $baptis->keterangan }}</textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="text-end">
                                <button type="submit"
                                    class="btn btn-info waves-effect waves-light m-r-10 text-white"> Update </button>
                                <button type="button" class="btn btn-danger waves-effect waves-light" onclick="redirectToIndex()"> Batal </button>
                            </div>
                        </div>
                    </form>
                    <script>
                        function redirectToIndex() {
                            window.location.href = "{{ route('Baptis.index') }}";
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

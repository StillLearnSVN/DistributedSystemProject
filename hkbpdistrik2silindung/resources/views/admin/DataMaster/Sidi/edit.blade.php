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
            <h4 class="text-themecolor">Edit Sidi</h4>
        </div>
        <div class="col-md-7 align-self-center text-end">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item">Pengaturan & Konfigurasi</li>
                    <li class="breadcrumb-item">General</li>
                    <li class="breadcrumb-item active"><a href="{{ route('Sidi.index') }}"
                            style="color:inherit">Sidi</a></li>
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
                    <form class="mt-4 needs-validation" action="{{ route('Sidi.update', $sidi->id_sidi) }}" method="POST"
                        novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="nama_jemaat">Nama Jemaat<span
                                        class="text-danger">*</span></label>
                                <select class="form-select" name="id_jemaat">
                                    <option value="">Nama Jemaat</option>
                                    @foreach ($jemaats as $jemaat)
                                    <option value="{{ $jemaat->id_jemaat }}" {{ $sidi->id_jemaat == $jemaat->id_jemaat ? 'selected' : '' }}>{{ $jemaat->gelar_depan }}{{ $jemaat->nama_depan }} {{ $jemaat->nama_belakang }} {{ $jemaat->gelar_belakang }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Nama Jemaat tidak boleh kosong.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="subdistrict">Status Anak<span
                                        class="text-danger">*</span></label>
                                <select class="form-select" name="id_status">
                                    <option value="">Pilih Status Anak</option>
                                    @foreach ($statuses as $statusx)
                                    <option value="{{ $statusx->id_status }}" {{ $statusx->id_status == $statusx->id_status ? 'selected' : '' }}>{{ $statusx->status  }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Status tidak boleh kosong.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="subdistrict">Gereja Sidi<span
                                        class="text-danger">*</span></label>
                                <select class="form-select" name="id_gereja_sidi">
                                    <option value="">Pilih Gereja</option>
                                    <!-- Populate options dynamically from database -->
                                    @foreach ($gerejas as $gereja)
                                    <option value="{{ $gereja->id_gereja }}" {{ $gereja->id_gereja == $gereja->id_gereja ? 'selected' : '' }}>{{ $gereja->nama_gereja  }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Status tidak boleh kosong.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="tgl_sidi">Tanggal Sidi<span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="tgl_sidi" name="tgl_sidi" value="{{ $sidi->tgl_sidi }}" required>
                                <div class="invalid-feedback">
                                    Tanggal Sidi tidak boleh kosong.
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="no_surat_sidi">Nomor Surat Sidi<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="no_surat_sidi" name="no_surat_sidi"
                                    value="{{ $sidi->no_surat_sidi }}" required>
                                <div class="invalid-feedback">
                                    Nomor Surat Sidi tidak boleh kosong.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="nats_sidi">Nats Sidi<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nats_sidi" name="nats_sidi"
                                    value="{{ $sidi->nats_sidi }}" required>
                                <div class="invalid-feedback">
                                    Nats Sidi tidak boleh kosong.
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="gereja_sidi">Gereja Non HKBP</label>
                                <input type="text" class="form-control" id="gereja_sidi" name="nama_gereja_non_hkbp"
                                    value="{{ $sidi->nama_gereja_non_hkbp }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="nama_pendeta_sidi">Nama Pendeta Sidi<span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama_pendeta_sidi"
                                    name="nama_pendeta_sidi" value="{{ $sidi->nama_pendeta_sidi }}" required>
                                <div class="invalid-feedback">
                                    Nama Pendeta Sidi tidak boleh kosong.
                                </div>
                            </div>
                        </div>
                        <!-- Display current file for File Surat Sidi field -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">File Surat Sidi<span class="text-danger">*</span></label>
                                <p>Current File: {{ $sidi->file_surat_sidi }}</p>
                                <!-- Display current file name in a text input field -->
                                <input type="text" class="form-control" value="{{ $sidi->file_surat_sidi }}" readonly>
                                <!-- Allow users to select a new file -->
                                <input type="file" class="form-control mt-2" id="file_surat_sidi" name="file_surat_sidi">
                                <div class="invalid-feedback">
                                    File Surat Sidi tidak boleh kosong.
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="validationCustom01">Keterangan</label>
                                <textarea class="form-control" rows="5" name="keterangan" placeholder="Masukkan Keterangan">{{ $sidi->keterangan }}</textarea>
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
                            window.location.href = "{{ route('Sidi.index') }}";
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

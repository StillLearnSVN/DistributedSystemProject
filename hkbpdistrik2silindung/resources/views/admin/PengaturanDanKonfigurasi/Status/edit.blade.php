@extends('layouts.admin.template')

@section('content')
    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Status</h4>
            </div>
            <div class="col-md-7 align-self-center text-end">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb justify-content-end">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Pengaturan & Konfigurasi</li>
                        <li class="breadcrumb-item">General</li>
                        <li class="breadcrumb-item active"><a href="{{ route('Status.index') }}" style="color:inherit">Status</a></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Edit Status</h4>
                        <h6 class="card-subtitle"> Form Edit Status </h6>
                        @if (isset($status))
                            <form class="mt-4 needs-validation" action="{{ route('Status.update', $status['id_status']) }}" method="POST" novalidate>
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="validationCustom01">Status<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="validationCustom01" name="status" value="{{ $status['status'] }}" placeholder="Masukkan Status" required>
                                        <div class="invalid-feedback">
                                            Status Tidak Boleh Kosong.
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="validationCustom01">Jenis Status</label>
                                        <select class="form-select" name="id_jenis_status">
                                            <option value="">Pilih Jenis Status</option>
                                            @if (!empty($jenisStatuses))
                                                @foreach ($jenisStatuses as $jenisStatus)
                                                    <option value="{{ $jenisStatus['id_jenis_status'] }}" {{ $status['id_jenis_status'] == $jenisStatus['id_jenis_status'] ? 'selected' : '' }}>{{ $jenisStatus['jenis_status'] }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label" for="validationCustom01">Keterangan</label>
                                        <textarea class="form-control" rows="5" name="keterangan" placeholder="Masukkan Keterangan">{{ $status['keterangan'] }}</textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-info waves-effect waves-light m-r-10 text-white"> Edit </button>
                                        <button type="reset" class="btn btn-danger waves-effect waves-light"> Batal </button>
                                    </div>
                                </div>
                            </form>
                        @endif
                        <script>
                            (function() {
                                'use strict';
                                window.addEventListener('load', function() {
                                    var forms = document.getElementsByClassName('needs-validation');
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
    </div>
@endsection

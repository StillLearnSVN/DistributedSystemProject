@extends('layouts.admin.template')

@section('content')
<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Province</h4>
        </div>
        <div class="col-md-7 align-self-center text-end">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="breadcrumb-item">Pengaturan & Konfigurasi</li>
                    <li class="breadcrumb-item">General</li>
                    <li class="breadcrumb-item active"><a href="{{ route('Province.index') }}" style="color:inherit">Province</a></li>
                </ol>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Edit Province</h4>
                    <h6 class="card-subtitle">Form Edit Province</h6>
                    @if (isset($province))
                    <form class="mt-4 needs-validation" action="{{ route('Province.update', $province->prov_id) }}" method="POST" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="validationCustom01">Nama Provinsi<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="validationCustom01" name="prov_name" value="{{ $province->prov_name }}" placeholder="Enter Nama Provinsi" required>
                                <div class="invalid-feedback">Nama Provinsi tidak boleh kosong.</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="validationCustom02">Location ID<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="validationCustom02" name="locationid" value="{{ $province->locationid }}" placeholder="Enter Location ID" required>
                                <div class="invalid-feedback">Location ID tidak boleh kosong.</div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="text-end">
                                <button type="submit" class="btn btn-info waves-effect waves-light m-r-10 text-white">Edit</button>
                                <button type="reset" class="btn btn-danger waves-effect waves-light">Cancel</button>
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

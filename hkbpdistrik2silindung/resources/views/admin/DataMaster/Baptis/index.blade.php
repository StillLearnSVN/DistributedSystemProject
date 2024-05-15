@extends('layouts.admin.template')

@section('content')
<script>
    //-------------------------------------------------------------------------------------------------
    //Ajax Form Detail Data
    //-------------------------------------------------------------------------------------------------
    $(document).on('click', '.detailBtn', function(e) {
        e.preventDefault();

        var baptisId = $(this).val();

        $("#detailModal").modal('show');

        $.ajax({
            method: "GET",
            url: "{{ route('Baptis.detail') }}",
            data: {
                id: baptisId
            },
            success: function(response) {
                if (response.status == 404) {
                    $.toast({
                        heading: 'Warning',
                        text: response.message,
                        position: 'top-right',
                        loaderBg: '#ff6849',
                        icon: 'warning',
                        hideAfter: 1500,
                        stack: 6
                    });
                    $('#editModal').modal('hide');
                } else {
                    $('#detail_nama_jemaat').text(response.baptis.gelar_depan + ' ' + response.baptis.nama_depan + ' ' + response.baptis.nama_belakang + ' ' + response.baptis.gelar_belakang);
                    $('#detail_tgl_baptis').text(response.baptis.tgl_baptis);
                    $('#detail_no_surat_baptis').text(response.baptis.no_surat_baptis);
                    $('#detail_gereja_baptis').text(response.baptis.gereja_baptis_name);
                    $('#detail_nama_pendeta_baptis').text(response.baptis.nama_pendeta_baptis);
                    $('#detail_file_surat_baptis').text(response.baptis.file_surat_baptis);
                    $('#detail_keterangan').text(response.baptis.keterangan);
                }
            }
        });
    });

    //-------------------------------------------------------------------------------------------------
    //Ajax Form Delete Data
    //-------------------------------------------------------------------------------------------------
    $(document).on('click', '.deleteBtn', function(e) {
        var baptisId = $(this).val();

        $('#deleteModal').modal('show');
        $('#deleting_id').val(baptisId);
    });

    //-------------------------------------------------------------------------------------------------
    //Ajax Delete Data
    //-------------------------------------------------------------------------------------------------
    $(document).on('click', '.delete_baptis', function(e) {
        e.preventDefault();

        var id = $('#deleting_id').val();

        var data = {
            'id': id,
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "DELETE",
            url: "{{ route('Baptis.delete') }}",
            data: data,
            dataType: "json",
            success: function(response) {
                if (response.status == 404) {
                    $.toast({
                        heading: 'Error',
                        text: response.message,
                        position: 'top-right',
                        loaderBg: '#ff6849',
                        icon: 'error',
                        hideAfter: 1500,
                        stack: 6
                    });
                    setTimeout("window.location='{{ route('Baptis.index') }}'", 1500);
                } else {
                    $.toast({
                        heading: 'Success',
                        text: response.message,
                        position: 'top-right',
                        loaderBg: '#ff6849',
                        icon: 'success',
                        hideAfter: 1500,
                        stack: 6
                    });
                    setTimeout("window.location='{{ route('Baptis.index') }}'", 1500);
                }
            }
        });
    });
</script>

<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Baptis</h4>
        </div>
        <div class="col-md-7 align-self-center text-end">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">Pengaturan & Konfigurasi</li>
                    <li class="breadcrumb-item">General</li>
                    <li class="breadcrumb-item active"><a href="{{ route('Baptis.index') }}"
                            style="color:inherit">Baptis</a></li>
                </ol>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex no-block align-items-center">
                        <div>
                            <h4 class="card-title">Data Baptis</h4>
                            <h6 class="card-subtitle"> Daftar Baptis </h6>
                        </div>
                        <div class="ms-auto">
                            <a href="{{ route('Baptis.create') }}" style="color:inherit"
                                class="pull-right btn btn-info d-lg-block m-l-15 text-white"><i class="ti-plus"> </i>
                                Tambah Baru </a>
                        </div>
                    </div>
                    <div class="table-responsive m-t-40">
                        <table id="config-table" class="table display table-striped border no-wrap">
                            <thead>
                                <tr>
                                    <th>Nama Jemaat</th>
                                    <th>Tanggal Baptis</th>
                                    <th>No. Surat Baptis</th>
                                    <th>Gereja Baptis</th>
                                    <th>Nama Pendeta Baptis</th>
                                    <th>Keterangan</th>
                                    <th class="text-center" style="width: 80px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($baptis) && count($baptis) > 0)
                                    @foreach ($baptis as $baptis)
                                        <tr>
                                            <td>{{ $baptis->gelar_depan }}{{ $baptis->nama_depan }} {{ $baptis->nama_belakang }} {{ $baptis->gelar_belakang }}</td>
                                            <td>{{ $baptis->tgl_baptis }}</td>
                                            <td>{{ $baptis->no_surat_baptis }}</td>
                                            <td>{{ $baptis->gereja_baptis_name }}</td>
                                            <td>{{ $baptis->nama_pendeta_baptis }}</td>
                                            <td>{{ $baptis->keterangan }}</td>
                                            <td class="text-center" style="padding: 12px;">
                                                <div class=" btn-group btn-group-sm">
                                                    <button type="button"
                                                        class="btn btn-outline-info dropdown-toggle"
                                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i class="ti-align-justify"></i>
                                                    </button>
                                                    <div class="dropdown-menu" style="">
                                                        <button type="button" value="{{ $baptis->id_baptis }}"
                                                            class="dropdown-item text-dark detailBtn">
                                                            <i class="ti-target"></i>Detail
                                                        </button>
                                                        <button type="button" class="dropdown-item text-info editBtn">
                                                            <i class="ti-pencil-alt me-2"></i><a
                                                                href="{{ route('Baptis.edit', $baptis->id_baptis) }}"
                                                                style="color:inherit">Edit</a>
                                                        </button>
                                                        <button type="button" value="{{ $baptis->id_baptis }}"
                                                            class="dropdown-item text-danger deleteBtn">
                                                            <i class="ti-trash me-2"></i>Delete
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- .modal for detail baptis -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Baptis</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" class="btn-close" aria-label="Close">
                    <span aria-hidden="true"></span> </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row mt-3">
                        <div class="col-md-5">
                            <label class="control-label text-end">Nama Jemaat:</label>
                        </div>
                        <div class="col-md-7 ms-auto">
                            <p class="form-control-static" id="detail_nama_jemaat"> </p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-5">
                            <label class="control-label text-end">Tanggal Baptis:</label>
                        </div>
                        <div class="col-md-7 ms-auto">
                            <p class="form-control-static" id="detail_tgl_baptis"> </p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-5">
                            <label class="control-label text-end">No. Surat Baptis:</label>
                        </div>
                        <div class="col-md-7 ms-auto">
                            <p class="form-control-static" id="detail_no_surat_baptis"> </p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-5">
                            <label class="control-label text-end">Gereja Baptis:</label>
                        </div>
                        <div class="col-md-7 ms-auto">
                            <p class="form-control-static" id="detail_gereja_baptis"> </p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-5">
                            <label class="control-label text-end">Nama Pendeta Baptis:</label>
                        </div>
                        <div class="col-md-7 ms-auto">
                            <p class="form-control-static" id="detail_nama_pendeta_baptis"></p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-5">
                            <label class="control-label text-end">File Surat Baptis:</label>
                        </div>
                        <div class="col-md-7 ms-auto">
                            <p class="form-control-static" id="detail_file_surat_baptis"> </p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-5">
                            <label class="control-label text-end">Keterangan:</label>
                        </div>
                        <div class="col-md-7 ms-auto">
                            <p class="form-control-static" id="detail_keterangan"> </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- .modal for delete baptis -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete Baptis</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" class="btn-close" aria-label="Close">
                    <span aria-hidden="true"></span> </button>
            </div>
            <form id="editBaptisForm">
                @csrf
                <div class="modal-body">
                    <h4>Confirm to delete the data?</h4>
                    <input type="hidden" id="deleting_id" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger text-white delete_baptis"
                        data-bs-dismiss="modal">Delete</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

@endsection

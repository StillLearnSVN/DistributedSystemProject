@extends('layouts.admin.template')

@section('content')
<script>
    //-------------------------------------------------------------------------------------------------
    //Ajax Form Detail Data
    //-------------------------------------------------------------------------------------------------
    $(document).on('click', '.detailBtn', function(e) {
        e.preventDefault();

        var meninggalId = $(this).val();

        $("#detailModal").modal('show');

        $.ajax({
            method: "GET",
            url: "{{ route('Meninggal.detail') }}",
            data: {
                id: meninggalId
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
                    $('#detail_nama_jemaat').text(response.meninggal.gelar_depan + ' ' + response.meninggal.nama_depan + ' ' + response.meninggal.nama_belakang + ' ' + response.meninggal.gelar_belakang);
                    $('#detail_status').text(response.meninggal.status);
                    $('#detail_tgl_meninggal').text(response.meninggal.tgl_meninggal);
                    $('#detail_tgl_warta_meninggal').text(response.meninggal.tgl_warta_meninggal);
                    $('#detail_tempat_pemakaman').text(response.meninggal.tempat_pemakaman);
                    $('#detail_nama_pendeta_melayani').text(response.meninggal.nama_pendeta_melayani);
                    $('#detail_gereja').text(response.meninggal.gereja_name);
                    $('#detail_keterangan').text(response.meninggal.keterangan);
                }
            }
        });
    });

    //-------------------------------------------------------------------------------------------------
    //Ajax Form Delete Data
    //-------------------------------------------------------------------------------------------------
    $(document).on('click', '.deleteBtn', function(e) {
        var meninggalId = $(this).val();

        $('#deleteModal').modal('show');
        $('#deleting_id').val(meninggalId);
    });

    //-------------------------------------------------------------------------------------------------
    //Ajax Delete Data
    //-------------------------------------------------------------------------------------------------
    $(document).on('click', '.delete_meninggal', function(e) {
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
            url: "{{ route('Meninggal.delete') }}",
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
                    setTimeout("window.location='{{ route('Meninggal.index') }}'", 1500);
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
                    setTimeout("window.location='{{ route('Meninggal.index') }}'", 1500);
                }
            }
        });
    });
</script>

<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Meninggal</h4>
        </div>
        <div class="col-md-7 align-self-center text-end">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">Pengaturan & Konfigurasi</li>
                    <li class="breadcrumb-item">General</li>
                    <li class="breadcrumb-item active"><a href="{{ route('Meninggal.index') }}"
                            style="color:inherit">Meninggal</a></li>
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
                            <h4 class="card-title">Data Meninggal</h4>
                            <h6 class="card-subtitle"> Daftar Meninggal </h6>
                        </div>
                        <div class="ms-auto">
                            <a href="{{ route('Meninggal.create') }}" style="color:inherit"
                                class="pull-right btn btn-info d-lg-block m-l-15 text-white"><i class="ti-plus"> </i>
                                Tambah Baru </a>
                        </div>
                    </div>
                    <div class="table-responsive m-t-40">
                        <table id="config-table" class="table display table-striped border no-wrap">
                            <thead>
                                <tr>
                                    <th>Nama Jemaat</th>
                                    <th>Status</th>
                                    <th>Tanggal Meninggal</th>
                                    <th>Tanggal Warta Meninggal</th>
                                    <th>Tempat Pemakaman</th>
                                    <th>Nama Pendeta Melayani</th>
                                    <th>Gereja</th>
                                    <th>Keterangan</th>
                                    <th class="text-center" style="width: 80px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($meninggals) && count($meninggals) > 0)
                                    @foreach ($meninggals as $meninggal)
                                        <tr>
                                            <td>{{ $meninggal->gelar_depan }}{{ $meninggal->nama_depan }} {{ $meninggal->nama_belakang }} {{ $meninggal->gelar_belakang }}</td>
                                            <td>{{ $meninggal->status }}</td>
                                            <td>{{ $meninggal->tgl_meninggal }}</td>
                                            <td>{{ $meninggal->tgl_warta_meninggal }}</td>
                                            <td>{{ $meninggal->tempat_pemakaman }}</td>
                                            <td>{{ $meninggal->nama_pendeta_melayani }}</td>
                                            <td>{{ $meninggal->gereja_name }}</td>
                                            <td>{{ $meninggal->keterangan }}</td>
                                            <td class="text-center" style="padding: 12px;">
                                                <div class=" btn-group btn-group-sm">
                                                    <button type="button"
                                                        class="btn btn-outline-info dropdown-toggle"
                                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i class="ti-align-justify"></i>
                                                    </button>
                                                    <div class="dropdown-menu" style="">
                                                        <button type="button" value="{{ $meninggal->id_meninggal }}"
                                                            class="dropdown-item text-dark detailBtn">
                                                            <i class="ti-target"></i>Detail
                                                        </button>
                                                        <button type="button" class="dropdown-item text-info editBtn">
                                                            <i class="ti-pencil-alt me-2"></i><a
                                                                href="{{ route('Meninggal.edit', $meninggal->id_meninggal) }}"
                                                                style="color:inherit">Edit</a>
                                                        </button>
                                                        <button type="button" value="{{ $meninggal->id_meninggal }}"
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

<!-- .modal for detail meninggal -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Meninggal</h4>
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
                            <label class="control-label text-end">Status:</label>
                        </div>
                        <div class="col-md-7 ms-auto">
                            <p class="form-control-static" id="detail_status"> </p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-5">
                            <label class="control-label text-end">Tanggal Meninggal:</label>
                        </div>
                        <div class="col-md-7 ms-auto">
                            <p class="form-control-static" id="detail_tgl_meninggal"> </p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-5">
                            <label class="control-label text-end">Tanggal Warta Meninggal:</label>
                        </div>
                        <div class="col-md-7 ms-auto">
                            <p class="form-control-static" id="detail_tgl_warta_meninggal"> </p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-5">
                            <label class="control-label text-end">Tempat Pemakaman:</label>
                        </div>
                        <div class="col-md-7 ms-auto">
                            <p class="form-control-static" id="detail_tempat_pemakaman"> </p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-5">
                            <label class="control-label text-end">Nama Pendeta Melayani:</label>
                        </div>
                        <div class="col-md-7 ms-auto">
                            <p class="form-control-static" id="detail_nama_pendeta_melayani"> </p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-5">
                            <label class="control-label text-end">Gereja:</label>
                        </div>
                        <div class="col-md-7 ms-auto">
                            <p class="form-control-static" id="detail_gereja"> </p>
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

<!-- .modal for delete meninggal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete Meninggal</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" class="btn-close" aria-label="Close">
                    <span aria-hidden="true"></span> </button>
            </div>
            <form id="editMeninggalForm">
                @csrf
                <div class="modal-body">
                    <h4>Confirm to delete the data?</h4>
                    <input type="hidden" id="deleting_id" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger text-white delete_meninggal"
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

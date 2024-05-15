@extends('layouts.admin.template')

@section('content')
<script>
    //-------------------------------------------------------------------------------------------------
    //Ajax Form Detail Data
    //-------------------------------------------------------------------------------------------------
    $(document).on('click', '.detailBtn', function(e) {
        e.preventDefault();

        var headPindahId = $(this).val();

        $("#detailModal").modal('show');

        $.ajax({
            method: "GET",
            url: "{{ route('HeadPindah.detail') }}",
            data: {
                id: headPindahId
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
                    $('#detail_nama_jemaat').text(response.head_pindah.gelar_depan + ' ' + response.head_pindah.nama_depan + ' ' + response.head_pindah.nama_belakang + ' ' + response.head_pindah.gelar_belakang);
                    $('#detail_tgl_pindah').text(response.head_pindah.tgl_pindah);
                    $('#detail_no_surat_pindah').text(response.head_pindah.no_surat_pindah);
                    $('#detail_tgl_warta').text(response.head_pindah.tgl_warta);
                    $('#detail_gereja_tujuan').text(response.head_pindah.gereja_tujuan_name);
                    $('#detail_nama_gereja_no_hkbp').text(response.head_pindah.nama_gereja_no_hkbp);
                    $('#detail_file_surat_pindah').text(response.head_pindah.file_surat_pindah);
                    $('#detail_keterangan').text(response.head_pindah.keterangan);
                }
            }
        });
    });

    //-------------------------------------------------------------------------------------------------
    //Ajax Form Delete Data
    //-------------------------------------------------------------------------------------------------
    $(document).on('click', '.deleteBtn', function(e) {
        var headPindahId = $(this).val();

        $('#deleteModal').modal('show');
        $('#deleting_id').val(headPindahId);
    });

    //-------------------------------------------------------------------------------------------------
    //Ajax Delete Data
    //-------------------------------------------------------------------------------------------------
    $(document).on('click', '.delete_head_pindah', function(e) {
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
            url: "{{ route('HeadPindah.delete') }}",
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
                    setTimeout("window.location='{{ route('HeadPindah.index') }}'", 1500);
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
                    setTimeout("window.location='{{ route('HeadPindah.index') }}'", 1500);
                }
            }
        });
    });
</script>

<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Head Pindah</h4>
        </div>
        <div class="col-md-7 align-self-center text-end">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">Pengaturan & Konfigurasi</li>
                    <li class="breadcrumb-item">General</li>
                    <li class="breadcrumb-item active"><a href="{{ route('HeadPindah.index') }}"
                            style="color:inherit">Head Pindah</a></li>
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
                            <h4 class="card-title">Data Head Pindah</h4>
                            <h6 class="card-subtitle"> Daftar Head Pindah </h6>
                        </div>
                        <div class="ms-auto">
                            <a href="{{ route('HeadPindah.create') }}" style="color:inherit"
                                class="pull-right btn btn-info d-lg-block m-l-15 text-white"><i class="ti-plus"> </i>
                                Tambah Baru </a>
                        </div>
                    </div>
                    <div class="table-responsive m-t-40">
                        <table id="config-table" class="table display table-striped border no-wrap">
                            <thead>
                                <tr>
                                    <th>Nama Jemaat</th>
                                    <th>Tanggal Pindah</th>
                                    <th>No. Surat Pindah</th>
                                    <th>Tanggal Warta</th>
                                    <th>Gereja Tujuan</th>
                                    <th>Nama Gereja Non HKBP</th>
                                    <th>Keterangan</th>
                                    <th class="text-center" style="width: 80px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($headPindahs) && count($headPindahs) > 0)
                                    @foreach ($headPindahs as $headPindah)
                                        <tr>
                                            <td>{{ $headPindah->gelar_depan }}{{ $headPindah->nama_depan }} {{ $headPindah->nama_belakang }} {{ $headPindah->gelar_belakang }}</td>
                                            <td>{{ $headPindah->tgl_pindah }}</td>
                                            <td>{{ $headPindah->no_surat_pindah }}</td>
                                            <td>{{ $headPindah->tgl_warta }}</td>
                                            <td>{{ $headPindah->gereja_tujuan_name }}</td>
                                            <td>{{ $headPindah->nama_gereja_no_hkbp }}</td>
                                            <td>{{ $headPindah->keterangan }}</td>
                                            <td class="text-center" style="padding: 12px;">
                                                <div class=" btn-group btn-group-sm">
                                                    <button type="button"
                                                        class="btn btn-outline-info dropdown-toggle"
                                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i class="ti-align-justify"></i>
                                                    </button>
                                                    <div class="dropdown-menu" style="">
                                                        <button type="button" value="{{ $headPindah->id_head_pindah }}"
                                                            class="dropdown-item text-dark detailBtn">
                                                            <i class="ti-target"></i>Detail
                                                        </button>
                                                        <button type="button" class="dropdown-item text-info editBtn">
                                                            <i class="ti-pencil-alt me-2"></i><a
                                                                href="{{ route('HeadPindah.edit', $headPindah->id_head_pindah) }}"
                                                                style="color:inherit">Edit</a>
                                                        </button>
                                                        <button type="button" value="{{ $headPindah->id_head_pindah }}"
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

<!-- .modal for detail head pindah -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Head Pindah</h4>
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
                            <label class="control-label text-end">Tanggal Pindah:</label>
                        </div>
                        <div class="col-md-7 ms-auto">
                            <p class="form-control-static" id="detail_tgl_pindah"> </p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-5">
                            <label class="control-label text-end">No. Surat Pindah:</label>
                        </div>
                        <div class="col-md-7 ms-auto">
                            <p class="form-control-static" id="detail_no_surat_pindah"> </p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-5">
                            <label class="control-label text-end">Tanggal Warta:</label>
                        </div>
                        <div class="col-md-7 ms-auto">
                            <p class="form-control-static" id="detail_tgl_warta"> </p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-5">
                            <label class="control-label text-end">Gereja Tujuan:</label>
                        </div>
                        <div class="col-md-7 ms-auto">
                            <p class="form-control-static" id="detail_gereja_tujuan"> </p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-5">
                            <label class="control-label text-end">Nama Gereja Non HKBP:</label>
                        </div>
                        <div class="col-md-7 ms-auto">
                            <p class="form-control-static" id="detail_nama_gereja_no_hkbp"> </p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-5">
                            <label class="control-label text-end">File Surat Pindah:</label>
                        </div>
                        <div class="col-md-7 ms-auto">
                            <p class="form-control-static" id="detail_file_surat_pindah"> </p>
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

<!-- .modal for delete head pindah -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete Head Pindah</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" class="btn-close" aria-label="Close">
                    <span aria-hidden="true"></span> </button>
            </div>
            <form id="editHeadPindahForm">
                @csrf
                <div class="modal-body">
                    <h4>Confirm to delete the data?</h4>
                    <input type="hidden" id="deleting_id" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger text-white delete_head_pindah"
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

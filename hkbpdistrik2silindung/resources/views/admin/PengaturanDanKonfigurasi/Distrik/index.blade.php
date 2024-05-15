@extends('layouts.admin.template')

@section('content')
<script>
    //-------------------------------------------------------------------------------------------------
    //Ajax Form Detail Data
    //-------------------------------------------------------------------------------------------------
    $(document).on('click', '.detailBtn', function(e) {
        e.preventDefault();

        var distrikId = $(this).val();

        $("#detailModal").modal('show');

        $.ajax({
            method: "GET",
            url: "{{ route('Distrik.detail') }}",
            data: {
                id: distrikId
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
                    $('#detail_distrik_name').text(response.distrik.nama_distrik);
                    $('#detail_subdistrict').text(response.distrik.subdistrict_name);
                    $('#detail_kode_distrik').text(response.distrik.kode_distrik);
                    $('#detail_alamat').text(response.distrik.alamat);
                    $('#detail_nama_praeses').text(response.distrik.nama_praeses);
                }
            }
        });
    });

    //-------------------------------------------------------------------------------------------------
    //Ajax Form Delete Data
    //-------------------------------------------------------------------------------------------------
    $(document).on('click', '.deleteBtn', function(e) {
        var distrikId = $(this).val();

        $('#deleteModal').modal('show');
        $('#deleting_id').val(distrikId);
    });

    //-------------------------------------------------------------------------------------------------
    //Ajax Delete Data
    //-------------------------------------------------------------------------------------------------
    $(document).on('click', '.delete_distrik', function(e) {
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
            url: "{{ route('Distrik.delete') }}",
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
                    setTimeout("window.location='{{ route('Distrik.index') }}'", 1500);
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
                    setTimeout("window.location='{{ route('Distrik.index') }}'", 1500);
                }
            }
        });
    });
</script>

<div class="container-fluid">
    <div class="row page-titles">
        <div class="col-md-5 align-self-center">
            <h4 class="text-themecolor">Distriks</h4>
        </div>
        <div class="col-md-7 align-self-center text-end">
            <div class="d-flex justify-content-end align-items-center">
                <ol class="breadcrumb justify-content-end">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">Pengaturan & Konfigurasi</li>
                    <li class="breadcrumb-item">General</li>
                    <li class="breadcrumb-item active"><a href="{{ route('Distrik.index') }}"
                            style="color:inherit">Distriks</a></li>
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
                            <h4 class="card-title">Data Distriks</h4>
                            <h6 class="card-subtitle"> Daftar Distriks </h6>
                        </div>
                        <div class="ms-auto">
                            <a href="{{ route('Distrik.create') }}" style="color:inherit"
                                class="pull-right btn btn-info d-lg-block m-l-15 text-white"><i class="ti-plus"> </i>
                                Tambah Baru </a>
                        </div>
                    </div>
                    <div class="table-responsive m-t-40">
                        <table id="config-table" class="table display table-striped border no-wrap">
                            <thead>
                                <tr>
                                    <th>Distrik Name</th>
                                    <th>Subdistrict</th>
                                    <th>District Code</th>
                                    {{-- <th>Address</th> --}}
                                    <th>Praeses Name</th>
                                    <th class="text-center" style="width: 80px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (isset($distriks) && count($distriks) > 0)
                                    @foreach ($distriks as $distrik)
                                        <tr>
                                            <td>{{ $distrik->nama_distrik }}</td>
                                            <td>{{ $distrik->subdistrict_name }}</td>
                                            <td>{{ $distrik->kode_distrik }}</td>
                                            {{-- <td>{{ $distrik->alamat }}</td> --}}
                                            <td>{{ $distrik->nama_praeses }}</td>
                                            <td class="text-center" style="padding: 12px;">
                                                <div class=" btn-group btn-group-sm">
                                                    <button type="button"
                                                        class="btn btn-outline-info dropdown-toggle"
                                                        data-bs-toggle="dropdown" aria-haspopup="true"
                                                        aria-expanded="false">
                                                        <i class="ti-align-justify"></i>
                                                    </button>
                                                    <div class="dropdown-menu" style="">
                                                        <button type="button" value="{{ $distrik->id_distrik }}"
                                                            class="dropdown-item text-dark detailBtn">
                                                            <i class="ti-target"></i>Detail
                                                        </button>
                                                        <button type="button" class="dropdown-item text-info editBtn">
                                                            <i class="ti-pencil-alt me-2"></i><a
                                                                href="{{ route('Distrik.edit', $distrik->id_distrik) }}"
                                                                style="color:inherit">Edit</a>
                                                        </button>
                                                        <button type="button" value="{{ $distrik->id_distrik }}"
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

<!-- .modal for detail distrik -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Distrik</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" class="btn-close" aria-label="Close">
                    <span aria-hidden="true"></span> </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row mt-3">
                        <div class="col-md-5">
                            <label class="control-label text-end">Distrik Name:</label>
                        </div>
                        <div class="col-md-7 ms-auto">
                            <p class="form-control-static" id="detail_distrik_name"> </p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-5">
                            <label class="control-label text-end">Subdistrict:</label>
                        </div>
                        <div class="col-md-7 ms-auto">
                            <p class="form-control-static" id="detail_subdistrict"> </p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-5">
                            <label class="control-label text-end">District Code:</label>
                        </div>
                        <div class="col-md-7 ms-auto">
                            <p class="form-control-static" id="detail_kode_distrik"> </p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-5">
                            <label class="control-label text-end">Address:</label>
                        </div>
                        <div class="col-md-7 ms-auto">
                            <p class="form-control-static" id="detail_alamat"> </p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-5">
                            <label class="control-label text-end">Praeses Name:</label>
                        </div>
                        <div class="col-md-7 ms-auto">
                            <p class="form-control-static" id="detail_nama_praeses"> </p>
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

<!-- .modal for delete distrik -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete Distrik</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" class="btn-close" aria-label="Close">
                    <span aria-hidden="true"></span> </button>
            </div>
            <form id="editDistrikForm">
                @csrf
                <div class="modal-body">
                    <h4>Confirm to delete the data?</h4>
                    <input type="hidden" id="deleting_id" />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger text-white delete_distrik"
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

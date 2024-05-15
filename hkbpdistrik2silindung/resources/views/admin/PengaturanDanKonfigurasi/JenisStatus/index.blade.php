@extends('layouts.admin.template')

@section('content')
    <script>
        //-------------------------------------------------------------------------------------------------
        //Ajax Form Detail Data
        //-------------------------------------------------------------------------------------------------
        $(document).on('click', '.detailBtn', function(e) {
            e.preventDefault();

            var jenisStatusId = $(this).val();

            $("#detailModal").modal('show');

            $.ajax({
                method: "GET",
                url: "{{ route('JenisStatus.detail') }}",
                data: {
                    id: jenisStatusId
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
                        $('#detail_jenis_status').text(response.jenis_status.jenis_status);
                        $('#detail_keterangan').text(response.jenis_status.keterangan);
                    }
                }
            });
        });

        //-------------------------------------------------------------------------------------------------
        //Ajax Form Delete Data
        //-------------------------------------------------------------------------------------------------
        $(document).on('click', '.deleteBtn', function(e) {
            var jenisStatusId = $(this).val();

            $('#deleteModal').modal('show');
            $('#deleting_id').val(jenisStatusId);
        });

        //-------------------------------------------------------------------------------------------------
        //Ajax Delete Data
        //-------------------------------------------------------------------------------------------------
        $(document).on('click', '.delete_jenis_status', function(e) {
            e.preventDefault();

            var id = $('#deleting_id').val();

            var data = {
                'id': id,
            }

            var deleteUrlTemplate = "{{ route('JenisStatus.delete', ['id' => ':id']) }}";

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: "DELETE",
                url: deleteUrlTemplate.replace(':id', id),
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
                        setTimeout("window.location='{{ route('JenisStatus.index') }}'", 1500);
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
                        setTimeout("window.location='{{ route('JenisStatus.index') }}'", 1500);
                    }
                }
            });
        });
    </script>


    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Jenis Status</h4>
            </div>
            <div class="col-md-7 align-self-center text-end">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb justify-content-end">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Pengaturan & Konfigurasi</li>
                        <li class="breadcrumb-item">General</li>
                        <li class="breadcrumb-item active"><a href="{{ route('JenisStatus.index') }}"
                                style="color:inherit">Jenis Status</a></li>
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
                                <h4 class="card-title">Data Jenis Status</h4>
                                <h6 class="card-subtitle"> Daftar Jenis Status </h6>
                            </div>
                            <div class="ms-auto">
                                <a href="{{ route('JenisStatus.create') }}" style="color:inherit"
                                    class="pull-right btn btn-info d-lg-block m-l-15 text-white"><i class="ti-plus"> </i>
                                    Tambah Baru </a>
                            </div>
                        </div>
                        <div class="table-responsive m-t-40">
                            <table id="config-table" class="table display table-striped border no-wrap">
                                <thead>
                                    <tr>
                                        <th>Jenis Status</th>
                                        <th>Keterangan</th>
                                        <th class="text-center" style="width: 80px;">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($jenisStatuses) && count($jenisStatuses) > 0)
                                        @foreach ($jenisStatuses as $status)
                                            <tr>
                                                <td>{{ $status['jenis_status'] }}</td>
                                                <td>{{ $status['keterangan'] }}</td>
                                                <td class="text-center" style="padding: 12px;">
                                                    <div class=" btn-group btn-group-sm">
                                                        <button type="button" class="btn btn-outline-info dropdown-toggle"
                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <i class="ti-align-justify"></i>
                                                        </button>
                                                        <div class="dropdown-menu" style="">
                                                            <button type="button" value="{{ $status['id_jenis_status'] }}"
                                                                class="dropdown-item text-dark detailBtn">
                                                                <i class="ti-target"></i>&nbsp;Detail
                                                            </button>
                                                            <button type="button" class="dropdown-item text-info editBtn">
                                                                <i class="ti-pencil-alt me-2"></i><a
                                                                    href="{{ route('JenisStatus.edit', $status['id_jenis_status']) }}"
                                                                    style="color:inherit">Edit</a>
                                                            </button>
                                                            <button type="button" value="{{ $status['id_jenis_status'] }}"
                                                                class="dropdown-item text-danger deleteBtn">
                                                                <i class="ti-trash me-2"></i>Hapus
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

    <!-- .modal for detail jenis status -->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detail Jenis Status</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" class="btn-close" aria-label="Close">
                        <span aria-hidden="true"></span> </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row mt-3">
                            <div class="col-md-5">
                                <label class="control-label text-end">Jenis Status:</label>
                            </div>
                            <div class="col-md-7 ms-auto">
                                <p class="form-control-static" id="detail_jenis_status"> </p>
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
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- .modal for delete jenis status -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Hapus Jenis Status</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" class="btn-close"
                        aria-label="Close">
                        <span aria-hidden="true"></span> </button>
                </div>
                <form id="editJenisStatusForm">
                    @csrf
                    <div class="modal-body">
                        <h4>Konfirmasi untuk Menghapus Data?</h4>
                        <input type="hidden" id="deleting_id" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-danger text-white delete_jenis_status"
                            data-bs-dismiss="modal">Hapus</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

@endsection

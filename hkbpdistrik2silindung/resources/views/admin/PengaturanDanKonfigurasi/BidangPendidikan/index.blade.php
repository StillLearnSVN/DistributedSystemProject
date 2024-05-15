@extends('layouts.admin.template')
@section('content')
    <script>
        //-------------------------------------------------------------------------------------------------
        //Ajax Form Detail Data
        //-------------------------------------------------------------------------------------------------
        $(document).on('click', '.detailBtn', function(e) {
            e.preventDefault();

            var fe_id = $(this).val();

            $("#detailModal").modal('show');

            $.ajax({
                method: "GET",
                url: "{{ route('BidangPendidikan.detail') }}",
                data: {
                    id: fe_id
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
                        $('#detail_nama_bidang_pendidikan').text(response.fieldEducation
                            .nama_bidang_pendidikan);
                        $('#detail_keterangan').text(response.fieldEducation.keterangan);
                    }
                }
            });
        });
        //-------------------------------------------------------------------------------------------------
        //Ajax Form Delete Data
        //-------------------------------------------------------------------------------------------------
        $(document).on('click', '.deleteBtn', function(e) {
            var fe_id = $(this).val();

            $('#deleteModal').modal('show');
            $('#deleting_id').val(fe_id);
        });

        //-------------------------------------------------------------------------------------------------
        //Ajax Delete Data
        //-------------------------------------------------------------------------------------------------
        $(document).on('click', '.delete_bidangPendidikan', function(e) {
            e.preventDefault();

            var id = $('#deleting_id').val();

            var data = {
                'idBidangPendidikan': id,
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            console.log(id);

            $.ajax({
                type: "DELETE",
                url: "{{ route('BidangPendidikan.delete') }}",
                data: data,
                dataType: "json",
                success: function(response) {
                    if (response.status == 400) {
                        $.each(response.errors, function(key, err_value) {
                            $.toast({
                                heading: 'Error',
                                text: err_value,
                                position: 'top-right',
                                loaderBg: '#ff6849',
                                icon: 'error',
                                hideAfter: 1500,
                                stack: 6
                            });
                            setTimeout(
                                "window.location='{{ route('BidangPendidikan.index') }}'",
                                1500);
                        });
                        $('.delete_bidangPendidikan').text('Hapus');
                    } else {
                        //$('#save_msgList').html("");
                        //$('#success_message').addClass('alert alert-success');
                        //$('#success_message').text(response.message);

                        //$('#deleteModal').find('input', 'textarea').val('');
                        $('.delete_bidangPendidikan').text('Hapus');
                        $('#deleteModal').modal('hide');

                        $.toast({
                            heading: 'Success',
                            text: response.message,
                            position: 'top-right',
                            loaderBg: '#ff6849',
                            icon: 'success',
                            hideAfter: 1500,
                            stack: 6
                        });
                        setTimeout("window.location='{{ route('BidangPendidikan.index') }}'", 1500);
                    }
                }
            });
        });
    </script>


    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Bidang Pendidikan</h4>
            </div>
            <div class="col-md-7 align-self-center text-end">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb justify-content-end">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Pengaturan & Konfigurasi</li>
                        <li class="breadcrumb-item">General</li>
                        <li class="breadcrumb-item active"><a href="{{ route('BidangPendidikan.index') }}"
                                style="color:inherit">Bidang Pendidikan</a></li>
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
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex no-block align-items-center">
                            <div>
                                <h4 class="card-title">Data Bidang Pendidikan</h4>
                                <h6 class="card-subtitle"> Daftar Bidang Pendidikan </h6>

                            </div>
                            <div class="ms-auto">
                                <a href="{{ route('BidangPendidikan.create') }}" style="color:inherit"
                                    class="pull-right btn btn-info d-lg-block m-l-15 text-white"><i class="ti-plus"> </i>
                                    Tambah Baru </a>
                            </div>
                        </div>
                        <div class="table-responsive m-t-40">
                            <table id="config-table" class="table display table-striped border no-wrap">
                                <thead>
                                    <tr>
                                        <th>Bidang Pendidikan</th>
                                        <th>Keterangan</th>
                                        <th class="text-center" style="width: 80px;">Tindakan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($fieldEducation) && count($fieldEducation) > 0)
                                        @foreach ($fieldEducation as $fE)
                                            <tr>
                                                <td>{{ $fE->nama_bidang_pendidikan }}</td>
                                                <td>{{ $fE->keterangan }}</td>
                                                <td class="text-center" style="padding: 12px;">
                                                    <div class=" btn-group btn-group-sm">
                                                        <button type="button" class="btn btn-outline-info dropdown-toggle"
                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <i class="ti-align-justify"></i>
                                                        </button>
                                                        <div class="dropdown-menu" style="">
                                                            <button type="button" value="{{ $fE->id_bidang_pendidikan }}"
                                                                class="dropdown-item text-dark detailBtn">
                                                                <i class="ti-target"></i>Detail
                                                            </button>
                                                            <button type="button" class="dropdown-item text-info editBtn">
                                                                <i class="ti-pencil-alt me-2"></i><a
                                                                    href="{{ route('BidangPendidikan.edit', $fE->id_bidang_pendidikan) }}"
                                                                    style="color:inherit">Edit</a>
                                                            </button>
                                                            <button type="button"
                                                                value="{{ $fE->id_bidang_pendidikan }}"
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
        <!-- ============================================================== -->
        <!-- End PAge Content -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->

    <!-- .modal for detail bidang pendidikan -->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detail Bidang Pendidikan</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" class="btn-close" aria-label="Close">
                        <span aria-hidden="true"></span> </button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <div class="row mt-3">
                            <div class="col-md-5">
                                <label class="control-label text-end">Bidang Pendidikan:</label>
                            </div>
                            <div class="col-md-7 ms-auto">
                                <p class="form-control-static" id="detail_nama_bidang_pendidikan"> </p>
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

    <!-- .modal for delete bidang pendidikan -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Hapus Bidang Pendidikan</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" class="btn-close"
                        aria-label="Close">
                        <span aria-hidden="true"></span> </button>
                </div>
                <form id="editBidangPendidikanForm">
                    @csrf
                    <div class="modal-body">
                        <h4>Konfirmasi untuk Menghapus Data?</h4>
                        <input type="hidden" id="deleting_id" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-danger text-white delete_bidangPendidikan"
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

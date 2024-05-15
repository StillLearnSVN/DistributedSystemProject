@extends('layouts.admin.template')

@section('content')
    <script>
        //-------------------------------------------------------------------------------------------------
        //Ajax Form Detail Data
        //-------------------------------------------------------------------------------------------------
        $(document).on('click', '.detailBtn', function(e) {
            e.preventDefault();

            var pelayanNonTahbisanId = $(this).val();

            $("#detailModal").modal('show');

            $.ajax({
                method: "GET",
                url: "{{ route('PelayanNonTahbisan.detail') }}",
                data: {
                    id: pelayanNonTahbisanId
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
                    } else {
                        var detailData = response.pelayanNonTahbisan;

                        $('#detail_nama_jemaat').text(detailData.gelar_depan + ' ' + detailData
                            .nama_depan + ' ' + detailData.nama_belakang + ' ' + detailData
                            .gelar_belakang);
                        $('#detail_pelayan_gereja').text(detailData.pelayan_gereja);
                        $('#detail_gereja').text(detailData.gereja_name);
                        $('#detail_status_pelayanan').text(detailData.status_name);
                        $('#detail_nama_pelayanan_nonTahbisan').text(detailData
                            .nama_pelayanan_nonTahbisan);
                        $('#detail_tgl_pengangkatan').text(detailData.tgl_pengangkatan);
                        $('#detail_tgl_berakhir').text(detailData.tgl_berakhir);
                        $('#detail_keterangan').text(detailData.keterangan);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });


        //-------------------------------------------------------------------------------------------------
        //Ajax Form Delete Data
        //-------------------------------------------------------------------------------------------------
        $(document).on('click', '.deleteBtn', function(e) {
            var pelayanNonTahbisanId = $(this).val();

            $('#deleteModal').modal('show');
            $('#deleting_id').val(pelayanNonTahbisanId);
        });

        //-------------------------------------------------------------------------------------------------
        //Ajax Delete Data
        //-------------------------------------------------------------------------------------------------
        $(document).on('click', '.delete_pelayan_nonTahbisan', function(e) {
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
                url: "{{ route('PelayanNonTahbisan.delete') }}",
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
                        setTimeout("window.location='{{ route('PelayanNonTahbisan.index') }}'", 1500);
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
                        setTimeout("window.location='{{ route('PelayanNonTahbisan.index') }}'", 1500);
                    }
                }
            });
        });
    </script>

    <div class="container-fluid">
        <div class="row page-titles">
            <div class="col-md-5 align-self-center">
                <h4 class="text-themecolor">Pelayan Non Tahbisan</h4>
            </div>
            <div class="col-md-7 align-self-center text-end">
                <div class="d-flex justify-content-end align-items-center">
                    <ol class="breadcrumb justify-content-end">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                        <li class="breadcrumb-item">Pengaturan & Konfigurasi</li>
                        <li class="breadcrumb-item">General</li>
                        <li class="breadcrumb-item active"><a href="{{ route('PelayanNonTahbisan.index') }}"
                                style="color:inherit">Pelayan Non Tahbisan</a></li>
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
                                <h4 class="card-title">Data Pelayan Non Tahbisan</h4>
                                <h6 class="card-subtitle"> Daftar Pelayan Non Tahbisan </h6>
                            </div>
                            <div class="ms-auto">
                                <a href="{{ route('PelayanNonTahbisan.create') }}" style="color:inherit"
                                    class="pull-right btn btn-info d-lg-block m-l-15 text-white"><i class="ti-plus"> </i>
                                    Tambah Baru </a>
                            </div>
                        </div>
                        <div class="table-responsive m-t-40">
                            <table id="config-table" class="table display table-striped border no-wrap">
                                <thead>
                                    <tr>
                                        <th>Nama Jemaat</th>
                                        <th>Gereja</th>
                                        <th>Status Pelayanan</th>
                                        <th>Nama Pelayanan Non Tahbisan</th>
                                        <th>Tanggal Pengangkatan</th>
                                        <th>Tanggal Berakhir</th>
                                        <th>Keterangan</th>
                                        <th class="text-center" style="width: 80px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($pelayanNonTahbisan) && count($pelayanNonTahbisan) > 0)
                                        @foreach ($pelayanNonTahbisan as $data)
                                            <tr>
                                                <td>{{ $data->gelar_depan }}{{ $data->nama_depan }}
                                                    {{ $data->nama_belakang }} {{ $data->gelar_belakang }}</td>
                                                <td>{{ $data->gereja_name }}</td>
                                                <td>{{ $data->status_name }}</td>
                                                <td>{{ $data->nama_pelayanan_nonTahbisan }}</td>
                                                <td>{{ $data->tgl_pengangkatan }}</td>
                                                <td>{{ $data->tgl_berakhir }}</td>
                                                <td>{{ $data->keterangan }}</td>
                                                <td class="text-center" style="padding: 12px;">
                                                    <div class=" btn-group btn-group-sm">
                                                        <button type="button" class="btn btn-outline-info dropdown-toggle"
                                                            data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <i class="ti-align-justify"></i>
                                                        </button>
                                                        <div class="dropdown-menu" style="">
                                                            <button type="button"
                                                                value="{{ $data->id_pelayanan_nonTahbisan }}"
                                                                class="dropdown-item text-dark detailBtn">
                                                                <i class="ti-target"></i>Detail
                                                            </button>
                                                            <button type="button" class="dropdown-item text-info editBtn">
                                                                <i class="ti-pencil-alt me-2"></i><a
                                                                    href="{{ route('PelayanNonTahbisan.edit', $data->id_pelayanan_nonTahbisan) }}"
                                                                    style="color:inherit">Edit</a>
                                                            </button>
                                                            <button type="button"
                                                                value="{{ $data->id_pelayanan_nonTahbisan }}"
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

    <!-- .modal for detail Pelayan Non Tahbisan -->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Detail Pelayan Non Tahbisan</h4>
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
                                <label class="control-label text-end">Pelayan Gereja:</label>
                            </div>
                            <div class="col-md-7 ms-auto">
                                <p class="form-control-static" id="detail_pelayan_gereja"> </p>
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
                                <label class="control-label text-end">Status Pelayanan:</label>
                            </div>
                            <div class="col-md-7 ms-auto">
                                <p class="form-control-static" id="detail_status_pelayanan"> </p>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-5">
                                <label class="control-label text-end">Nama Pelayanan Non Tahbisan:</label>
                            </div>
                            <div class="col-md-7 ms-auto">
                                <p class="form-control-static" id="detail_nama_pelayanan_nonTahbisan"> </p>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-5">
                                <label class="control-label text-end">Tanggal Pengangkatan:</label>
                            </div>
                            <div class="col-md-7 ms-auto">
                                <p class="form-control-static" id="detail_tgl_pengangkatan"> </p>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-5">
                                <label class="control-label text-end">Tanggal Berakhir:</label>
                            </div>
                            <div class="col-md-7 ms-auto">
                                <p class="form-control-static" id="detail_tgl_berakhir"> </p>
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

    <!-- .modal for delete Pelayan Non Tahbisan -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Pelayan Non Tahbisan</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" class="btn-close"
                        aria-label="Close">
                        <span aria-hidden="true"></span> </button>
                </div>
                <form id="editPelayanNonTahbisanForm">
                    @csrf
                    <div class="modal-body">
                        <h4>Confirm to delete the data?</h4>
                        <input type="hidden" id="deleting_id" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger text-white delete_pelayan_nonTahbisan"
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

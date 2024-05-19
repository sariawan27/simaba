@extends('layouts.master')

@section('content')
<div class="page-heading">
    <div class="row">
        <div class="col-6">
            <h3>Laporan Pengajuan</h3>
        </div>
        <div class="col-6 d-flex justify-content-end">
            <div class="btn-group me-1 mb-1">
                <div class="dropdown">
                    <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background-color: #435ebe;">
                        <i class="bi bi-person-circle"></i> {{Auth::user()->nama}}
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" style="padding: 7px;">
                        <h6>Kelola Akun</h6>
                        <a href="{{ route('users.profile') }}" class="dropdown-item">Profile</a>
                        <hr />
                        <a href="{{ route('auth.logout') }}" style="color: red;" class="dropdown-item">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="page-content">
    <section class="row">
        <!-- page section -->
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">
                            Daftar Pengajuan
                        </h5>
                    </div>
                    <div class="card-body">
                        <table id="exampleServerSide" class="table table-striped table-bordered table-hover text-center barang-table" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Kode Pengajuan</th>
                                    <th>status</th>
                                    {{-- <th>Note</th> --}}
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
        <!-- end page section -->
    </section>
</div>

<script src="{{asset('assets/compiled/js/app.js')}}"></script>
<script src="{{asset('assets/compiled/js/jquery-3.7.1.js')}}"></script>
<script src="{{asset('assets/compiled/js/dataTables.bootstrap5.js')}}"></script>
<script src="{{asset('assets/compiled/js/dataTables.js')}}"></script>
<script>
    $(function() {

        var table = $('.barang-table').DataTable({
            processing: true,
            responsive: true,
            serverSide: true,
            columnDefs: [{
                    "className": "dt-center",
                    "targets": "_all"
                },

            ],
            ajax: "{{ route('laporan.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    render: function(data, type, row, meta) {
                        return moment(row.created_at).format('DD-MM-YYYY  HH:mm:ss');
                    }
                },
                {
                    data: 'kd_pengajuan',
                    name: 'kd_pengajuan'
                },
                {
                    render: function(data, type, row, meta) {
                        if (row.status == 'waiting') {
                            return '<i class="bi bi-clock bi-middle" style="font-size: 20px; color: #cfa825;"></i>';
                        } else if (row.status == 'approved') {
                            return '<i class="bi bi-check bi-middle" style="font-size: 28px; color: green;"></i>';
                        } else {
                            return '<i class="bi bi-check-all bi-middle" style="font-size: 20px;color: green;"></i>';
                        }
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
    });
</script>
@endsection
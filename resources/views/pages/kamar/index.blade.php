@extends('layouts.master')

@section('content')
<div class="page-heading">
    <div class="row">
        <div class="col-6">
            <h3>Kamar</h3>
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
                            Daftar Kamar
                        </h5>
                    </div>
                    <div class="card-body">
                        @if(Auth::user()->level == 'pengasuh')
                        <div class="row">
                            <div class="col-2">
                                <a class="btn btn-primary" href="{{route('kamar.create')}}">Tambah Kamar</a>
                            </div>
                        </div>
                        @endif
                        <table id="exampleServerSide" class="table table-striped table-bordered table-hover text-center barang-table" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Deskripsi</th>
                                    {{-- <th>Note</th> --}}
                                    @if(Auth::user()->level == 'pengasuh')
                                    <th>Action</th>
                                    @endif
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

<script src="{{asset('assets/compiled/js/jquery-3.7.1.js')}}"></script>
<script src="{{asset('assets/compiled/js/dataTables.bootstrap5.js')}}"></script>
<script src="{{asset('assets/compiled/js/dataTables.js')}}"></script>

<script src="{{asset('assets/compiled/js/app.js')}}"></script>
<script>
    $(function() {

        if ("{{Auth::user()->level}}" == 'pengasuh') {
            var table = $('.barang-table').DataTable({
                processing: true,
                responsive: true,
                serverSide: true,
                columnDefs: [{
                        "className": "dt-center",
                        "targets": "_all"
                    },

                ],
                ajax: "{{ route('kamar.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'nama_kamar',
                        name: 'nama_kamar'
                    },
                    {
                        data: 'deskripsi',
                        name: 'deskripsi'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        } else {
            var table = $('.barang-table').DataTable({
                processing: true,
                responsive: true,
                serverSide: true,
                columnDefs: [{
                        "className": "dt-center",
                        "targets": "_all"
                    },

                ],
                ajax: "{{ route('kamar.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'nama_kamar',
                        name: 'nama_kamar'
                    },
                    {
                        data: 'deskripsi',
                        name: 'deskripsi'
                    },
                ]
            });
        }
    });
</script>
@endsection
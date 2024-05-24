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
                            Detail Kamar
                        </h5>
                    </div>
                    <div class="card-body">
                        <form id="form" class="form">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="nama-kamar-column">Nama Kamar</label>
                                        <input type="text" id="nama-kamar-column" class="form-control" placeholder="Nama Kamar" name="nama_kamar" value="{{$data->nama_kamar}}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="deskripsi-column">Deskripsi</label>
                                        <input type="text" id="deskripsi-column" class="form-control" placeholder="Deskripsi" name="deskripsi" value="{{$data->deskripsi}}">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                    <a href="{{route('kamar.index')}}" class="btn btn-light-secondary me-1 mb-1">Batal</a>
                                </div>
                            </div>
                        </form>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">
                            Daftar Taruni Kamar {{$data->nama_kamar}}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-2">
                                <!-- Button trigger for basic modal -->
                                <button type="button" class="btn btn-outline-primary block" data-bs-toggle="modal" data-bs-target="#default">
                                    Tambah Taruni
                                </button>
                                <!-- <a class="btn btn-primary" href="{{route('users.create')}}" >Tambah Taruni</a> -->
                            </div>
                        </div>
                        <table id="exampleServerSide" class="table table-striped table-bordered table-hover text-center users-table" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NIM</th>
                                    <th>Nama</th>
                                    <th>Angkatan</th>
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

        <!--Basic Modal -->
        <div class="modal fade text-left w-500" id="default" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <form id="form_add_taruni" class="form">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myModalLabel1">Tambah Taruni ke Kamar {{$data->nama_kamar}}</h5>
                            <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <div class="modal-body" style="height: 300px;">
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Taruni</label>
                                    <fieldset class="form-group">
                                        <select class="choices form-select multiple-remove" multiple="multiple" id="taruni">
                                            @foreach ($allDataTaruni as $users)
                                            <option value="{{$users->id}}">{{$users->nim." - ".$users->nama. " (" . $users->angkatan . ") "}}</option>
                                            @endforeach
                                        </select>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <button type="submit" class="btn btn-primary ms-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Accept</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- end page section -->
    </section>
</div>

<div id="alertnya" style="position: absolute; right: 0; top: 30px;">
</div>

<script src="{{asset('assets/compiled/js/jquery-3.7.1.js')}}"></script>
<script src="{{asset('assets/compiled/js/dataTables.bootstrap5.js')}}"></script>
<script src="{{asset('assets/compiled/js/dataTables.js')}}"></script>
<script>
    $(function() {

        var table = $('.users-table').DataTable({
            processing: true,
            responsive: true,
            serverSide: true,
            columnDefs: [{
                    "className": "dt-center",
                    "targets": "_all"
                },

            ],
            ajax: "{{ route('users.kamar_taruni', explode('/', (parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)))[3]) }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'nim',
                    name: 'nim'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'angkatan',
                    name: 'angkatan'
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
<script>
    $(document).ready(function() {

        if ('{{$data->level=="taruni"}}') {
            $('#data_taruni').show()
        } else {
            $('#data_taruni').hide()
        }

        $('#rolenya').change(function() {
            if ($('#rolenya').val() == 'taruni') {
                $('#data_taruni').show()
            } else {
                $('#data_taruni').hide()
            }
        })

        $('#form').submit(function(e) {
            e.preventDefault()

            $.ajax({
                type: "PUT",
                url: "{{ route('kamar.update', explode('/', (parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)))[3]) }}",
                data: $("#form").serialize(),
                dataType: "json",
                success: function(data) {
                    console.log("sukses cuk")
                    //peringatan ketika data yg diinputkan tidak sesuai
                    $('#alertnya').css({
                        display: 'block',
                        opacity: '100%'
                    });
                    $('#alertnya').html(`
                            <div class="alert alert-success alert-dismissible show fade" style="z-index: 13;">
                                <i class="bi bi-check-circle"></i> Data berhasil disimpan.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `)
                    window.setTimeout(function() {
                        $("#alertnya").fadeTo(1000, 0).slideUp(1000, function() {
                            $(this).html(``);
                        });

                        location.href = "{{ route('kamar.show', explode('/', (parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)))[3]) }}";
                    }, 2000);

                },
                error: function(jqXHR, exception) {
                    if (jqXHR.status === 422) {
                        //peringatan ketika data yg diinputkan tidak sesuai
                        errorMessage = jqXHR.responseJSON;
                        html = ''
                        html += `
                                <div class="alert alert-warning alert-dismissible show fade" style="z-index: 13;">
                                    Warning
                                    <ul>`
                        for (const property in errorMessage) {
                            errMessage = errorMessage[property];

                            for (const element of errMessage) {
                                html += '<li>' + element + '</li>'
                            }
                        }
                        html += `</ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>`

                        $('#alertnya').css({
                            display: 'block',
                            opacity: '100%'
                        });
                        $('#alertnya').html(html)

                        window.setTimeout(function() {
                            $("#alertnya").fadeTo(1000, 0).slideUp(1000, function() {
                                $(this).html(``);
                            });
                        }, 2000);
                    } else {
                        //peringatan ketika data yg diinputkan tidak sesuai
                        $('#alertnya').html(`
                                <div class="alert alert-danger alert-dismissible show fade" style="z-index: 13;">
                                    <i class="bi bi-exclamation-circle"></i> Gagal mengupdate data.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            `)
                        window.setTimeout(function() {
                            $("#alertnya").fadeTo(1000, 0).slideUp(1000, function() {
                                $(this).html(``);
                            });
                        }, 2000);
                    }
                }

            })
        })


        $('#form_add_taruni').submit(function(e) {
            e.preventDefault()

            $.ajax({
                type: "POST",
                url: "{{ route('kamar.add_taruni', explode('/', (parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)))[3]) }}",
                data: $(this).serialize() + "&taruni=" + $('#taruni').val(),
                dataType: "json",
                success: function(data) {
                    console.log("sukses cuk")
                    //peringatan ketika data yg diinputkan tidak sesuai
                    $('#alertnya').css({
                        display: 'block',
                        opacity: '100%'
                    });
                    $('#alertnya').html(`
                            <div class="alert alert-success alert-dismissible show fade" style="z-index: 13;">
                                <i class="bi bi-check-circle"></i> Data berhasil disimpan.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `)
                    window.setTimeout(function() {
                        $("#alertnya").fadeTo(1000, 0).slideUp(1000, function() {
                            $(this).html(``);
                        });

                        location.reload();
                    }, 2000);

                },
                error: function(jqXHR, exception) {
                    if (jqXHR.status === 422) {
                        //peringatan ketika data yg diinputkan tidak sesuai
                        errorMessage = jqXHR.responseJSON;
                        html = ''
                        html += `
                                <div class="alert alert-warning alert-dismissible show fade" style="z-index: 13;">
                                    Warning
                                    <ul>`
                        for (const property in errorMessage) {
                            errMessage = errorMessage[property];

                            for (const element of errMessage) {
                                html += '<li>' + element + '</li>'
                            }
                        }
                        html += `</ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>`

                        $('#alertnya').css({
                            display: 'block',
                            opacity: '100%'
                        });
                        $('#alertnya').html(html)

                        window.setTimeout(function() {
                            $("#alertnya").fadeTo(1000, 0).slideUp(1000, function() {
                                $(this).html(``);

                                location.reload();
                            });
                        }, 2000);
                    } else {
                        //peringatan ketika data yg diinputkan tidak sesuai
                        $('#alertnya').html(`
                                <div class="alert alert-danger alert-dismissible show fade" style="z-index: 13;">
                                    <i class="bi bi-exclamation-circle"></i> Gagal mengupdate data.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            `)
                        window.setTimeout(function() {
                            $("#alertnya").fadeTo(1000, 0).slideUp(1000, function() {
                                $(this).html(``);

                                location.reload();
                            });
                        }, 2000);
                    }
                }

            })
        })

    })
</script>
@endsection
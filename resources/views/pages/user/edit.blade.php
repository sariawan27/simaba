@extends('layouts.master')

@section('content')
<div class="page-heading">
    <div class="row">
        <div class="col-6">
            <h3>Users</h3>
        </div>
    </div>
</div>
<div class="page-content">
    <section class="row">
        <!-- page section -->
        <div id="alertnya" style="top: 30px; width:100% !important;"></div>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">
                            Form Edit User
                        </h5>
                    </div>
                    <div class="card-body">
                        <form id="form" class="form">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="no-identity-column">No. Identitas</label>
                                        <input type="text" id="no-identity-column" class="form-control" placeholder="Nomor Identitas" name="no_identity" value="{{$data->no_identitas}}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="name-column">Nama</label>
                                        <input type="text" id="name-column" class="form-control" placeholder="Nama Lengkap" name="nama" value="{{$data->nama}}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <label>Role</label>
                                    <fieldset class="form-group">
                                        <select name="level" class="form-select" id="rolenya">
                                            <option value="pengasuh" {{ ($data->level=='pengasuh') ? 'selected': ''}}>Pengasuh</option>
                                            <option value="kepala_asrama" {{ ($data->level=='kepala_asrama') ? 'selected': ''}}>Kepala Asrama</option>
                                            <option value="taruni" {{ ($data->level=='taruni') ? 'selected': ''}}>Taruni</option>
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="email-column">Email</label>
                                        <input type="text" id="email-column" class="form-control" placeholder="Email" name="email" value="{{$data->email}}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="no-telp-column">No Telp</label>
                                        <input type="text" id="no-telp-column" class="form-control" placeholder="No Telp" name="no_telp" value="{{$data->no_telp}}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="address-column">Alamat</label>
                                        <input type="text" id="address-column" class="form-control" placeholder="Alamat" name="alamat" value="{{$data->alamat}}">
                                    </div>
                                </div>
                            </div>

                            <div id="data_taruni" class="row" style="display: none;">
                                <div class="col-md-12 col-12">
                                    <b>Informasi Taruni</b>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="nim-column">NIM</label>
                                        <input type="text" id="nim-column" class="form-control" placeholder="NIM" name="nim" value="{{$data->nim}}">
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="form-group">
                                        <label for="angkatan-column">Angkatan</label>
                                        <input type="text" id="angkatan-column" class="form-control" placeholder="Angkatan" name="angkatan" value="{{$data->angkatan}}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                    <a href="{{route('users.index')}}" class="btn btn-light-secondary me-1 mb-1">Batal</a>
                                </div>
                            </div>
                        </form>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
        <!-- end page section -->
    </section>
</div>

</div>

<script src="{{asset('assets/compiled/js/app.js')}}"></script>
<script src="{{asset('assets/compiled/js/jquery-3.7.1.js')}}"></script>
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

        $('form').submit(function(e) {
            e.preventDefault()

            $.ajax({
                type: "PUT",
                url: "{{ route('users.update', explode('/', (parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)))[3]) }}",
                data: $("form").serialize(),
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

                        location.href = "{{ route('users.edit', explode('/', (parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)))[3]) }}";
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
                        }, 2300);
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
    })
</script>
@endsection
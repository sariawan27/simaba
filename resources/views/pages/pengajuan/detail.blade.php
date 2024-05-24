@extends('layouts.master')

@section('content')
<div class="page-heading">
    <div class="row">
        <div class="col-6">
            <h3>Pengajuan</h3>
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
                        <div class="row">
                            <div class="col-6">
                                <h5 class="card-title">
                                    Detail Pengajuan
                                </h5>
                            </div>
                            <div class="col-6 d-flex justify-content-end">
                                <b>Tanggal Pengajuan</b>: {{$dataPengajuan->created_at}}
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-center">
                                <h2>{{strtoupper($dataPengajuan->status)}}</h2>
                            </div>
                        </div>
                        @if ($dataPengajuan->status == 'approved')
                        <div class="row mt-1">
                            <div class="col-12">
                                <div class="alert alert-light-success color-success"><i class="bi bi-check-circle"></i> Pengajuan telah disetujui pada tanggal {{$dataPengajuan->assign_at}}{{ $dataAssign ? ' oleh '.$dataAssign['nama'].'.' : '.'}}</div>
                            </div>
                        </div>
                        @elseif ($dataPengajuan->status == 'rejected')
                        <div class="row mt-1">
                            <div class="col-12">
                                <div class="alert alert-light-danger color-danger"><i class="bi bi-exclamation-circle"></i> Pengajuan telah ditolak.</div>
                            </div>
                        </div>
                        @else
                        @endif
                        <form id="form" class="form">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="row">
                                        <div class="col-md-12 col-12" style="display: none;">
                                            <div class="form-group">
                                                <label for="no-column">No.</label>
                                                <input type="text" id="no-column" class="form-control" placeholder="No." name="no" value="{{$dataPengajuan->user_id}}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="nama-column">Nama Taruni</label>
                                                <input type="text" id="nama-column" class="form-control" placeholder="Nama Taruni" name="nama" value="{{$dataPengajuan->nama}}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="no-telp-column">No. Telp</label>
                                                <input type="text" id="no-telp-column" class="form-control" placeholder="No. Telp" name="no_telp" value="{{$dataPengajuan->no_telp}}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="row">
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="kamar-column">Kamar</label>
                                                <input type="text" id="kamar-column" class="form-control" placeholder="Kamar" name="nama_kamar" value="{{$dataPengajuan->nama_kamar}}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="kd-pengajuan-column">Kode Pengajuan</label>
                                                <input type="text" id="kd-pengajuan-column" class="form-control" placeholder="Kode Pengajuan" name="kd_pengajuan" value="{{$dataPengajuan->kd_pengajuan}}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12" style="display: none;">
                                            <div class="form-group">
                                                <label for="barang-dipilih-column">Data Barang yang Dipilih</label>
                                                <input type="text" id="barang-dipilih-column" class="form-control" placeholder="Kode Pengajuan" name="barang_dipilih" value="{{json_encode($detailPengajuan)}}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12 col-12 d-flex justify-content-center">
                                    <h3>Barang yang Diajukan</h3>
                                </div>
                            </div>
                            <div class="row mt-1">
                                <div class="col-md-12 col-12">
                                    <table class="table table-borderd">
                                        <thead>
                                            <tr>
                                                <th>Barang</th>
                                                <th>Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody id="body_barang">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @if (session()->get('users')['level']=='pengasuh')
                            @if ($dataPengajuan->status=='approved')
                            <div class="row">
                                <div class="col-12 d-flex justify-content-center">
                                    <a href="{{route('pengajuan.index')}}" class="btn btn-secondary me-1 mb-1">Kembali</a>
                                </div>
                            </div>
                            @elseif ($dataPengajuan->status=='arrived')
                            <div class="row">
                                <div class="col-12 d-flex justify-content-center">
                                    <a href="{{route('pengajuan.index')}}" class="btn btn-secondary me-1 mb-1">Kembali</a>
                                </div>
                            </div>
                            @else
                            <div class="row">
                                <div class="col-12 d-flex justify-content-center">
                                    <a href="{{route('pengajuan.setujui_pengajuan', $dataPengajuan->id)}}" class="btn btn-success me-1 mb-1">Setuju</a>
                                    <a href="{{route('pengajuan.index')}}" class="btn btn-secondary me-1 mb-1">Kembali</a>
                                </div>
                            </div>
                            @endif
                            @endif
                            @if (session()->get('users')['level']=='taruni')
                            @if ($dataPengajuan->status=='approved')
                            <div class="row">
                                <div class="col-12 d-flex justify-content-center">
                                    <a href="{{route('pengajuan.selesai_kirim_barang', $dataPengajuan->id)}}" class="btn btn-primary me-1 mb-1">Barang Telah Sampai</a>
                                </div>
                            </div>
                            @elseif ($dataPengajuan->status=='arrived')
                            <div class="row">
                                <div class="col-12 d-flex justify-content-center">
                                    <a href="{{route('pengajuan.index')}}" class="btn btn-secondary me-1 mb-1">Kembali</a>
                                </div>
                            </div>
                            @endif
                            @endif
                        </form>

                        @if ($dataPengajuan->status=='arrived')
                        <div class="row mt-3">
                            <div class="col-md-12 col-12 d-flex justify-content-center">
                                <h3>Ulasan</h3>
                            </div>
                        </div>
                        <div class="row mt-1">
                            <div class="col-md-12 col-12">
                                <table class="table table-borderd">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Catatan Ulasan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dataUlasan as $val)
                                        <tr>
                                            <td>{{$val['created_at']}}</td>
                                            <td>{{$val['catatan_ulasan']}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endif
                        @if (session()->get('users')['level']=='taruni'&&$dataPengajuan->status=='arrived')
                        <form id="form_ulasan" class="form">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    <div class="form-group">
                                        <textarea type="text" id="nama-column" class="form-control" placeholder="Ulasan" name="ulasan"> </textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Kirim</button>
                                </div>
                            </div>
                        </form>
                        @endif
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
        <!-- end page section -->
    </section>
</div>

<div id="alertnya" style="position: absolute; right: 0; top: 30px;">
</div>

<script src="{{asset('assets/compiled/js/app.js')}}"></script>
<script src="{{asset('assets/compiled/js/jquery-3.7.1.js')}}"></script>
<script>
    var tools = [];
    // $('#max_quantity').change(function(){
    // })

    function addTools() {
        const barangList = JSON.parse($('#data_barang').val())

        if ($('#tool_list').val() != "" && $('#qty').val() != "") {
            const getId = tools.findIndex((tool) => tool.barang_id === parseInt($('#tool_list').val()))

            const barangDipilih = barangList.find((x) => x.id == parseInt($('#tool_list').val()))
            console.log(barangDipilih);
            console.log(getId);
            console.log(tools);
            const html = "";
            if (getId !== -1 || getId == 0) {
                if (tools[getId].qty + parseInt($('#qty').val()) > barangDipilih.stok) {
                    $('#alertnya').css({
                        display: 'block',
                        opacity: '100%'
                    });
                    $('#alertnya').html(`
                    <div class="alert alert-danger alert-dismissible show fade">
                        <i class="bi bi-check-circle"></i> Qty melebihi stok.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `)
                    window.setTimeout(function() {
                        $("#alertnya").fadeTo(1000, 0).slideUp(1000, function() {
                            $(this).html(``);
                        });

                        // location.reload();
                    }, 2000);
                } else {
                    if (tools[getId].qty + parseInt($('#qty').val()) > barangDipilih.max_quantity) {
                        $('#alertnya').css({
                            display: 'block',
                            opacity: '100%'
                        });
                        $('#alertnya').html(`
                        <div class="alert alert-danger alert-dismissible show fade">
                            <i class="bi bi-check-circle"></i> Hanya boleh maksimal ${barangDipilih.max_quantity} qty.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `)
                        window.setTimeout(function() {
                            $("#alertnya").fadeTo(1000, 0).slideUp(1000, function() {
                                $(this).html(``);
                            });

                            // location.reload();
                        }, 2000);
                    } else {
                        tools[getId].qty += parseInt($('#qty').val())
                        $("table tbody tr:eq(" + getId + ")").find("td:eq(1)").text(tools[getId].qty);
                    }
                }

            } else {
                if (parseInt($('#qty').val()) > barangDipilih.stok) {
                    $('#alertnya').css({
                        display: 'block',
                        opacity: '100%'
                    });
                    $('#alertnya').html(`
                    <div class="alert alert-danger alert-dismissible show fade">
                        <i class="bi bi-check-circle"></i> Qty melebihi stok.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `)
                    window.setTimeout(function() {
                        $("#alertnya").fadeTo(1000, 0).slideUp(1000, function() {
                            $(this).html(``);
                        });

                        // location.reload();
                    }, 2000);
                } else {
                    if (parseInt($('#qty').val()) > barangDipilih.max_quantity) {
                        $('#alertnya').css({
                            display: 'block',
                            opacity: '100%'
                        });
                        $('#alertnya').html(`
                        <div class="alert alert-danger alert-dismissible show fade">
                            <i class="bi bi-check-circle"></i> Hanya boleh maksimal ${barangDipilih.max_quantity} qty.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `)
                        window.setTimeout(function() {
                            $("#alertnya").fadeTo(1000, 0).slideUp(1000, function() {
                                $(this).html(``);
                            });

                            // location.reload();
                        }, 200);
                    } else {
                        tools.push({
                            barang_id: parseInt($('#tool_list').val()),
                            name: $('#tool_list option:selected').text(),
                            qty: parseInt($('#qty').val())
                        })

                        var newRow = "<tr>";
                        newRow += "<td>" + $('#tool_list option:selected').text() + "</td>";
                        newRow += "<td>" + $('#qty').val() + "</td>";
                        newRow += "<td><button type='button' id='' class='btn btn-danger delete-row' onclick='removeBarang(" + parseInt($('#tool_list').val()) + ")'>Hapus</button></td>";
                        newRow += "</tr>";

                        $("table tbody#body_barang").append(newRow);
                    }
                }

            }

            $('#barang-dipilih-column').val(JSON.stringify(tools))
        }
    }

    function removeBarang(index) {
        // const getId = tools.findIndex((tool) => tool.barang_id === parseInt($('#tool_list').val()))

        const getId = tools.findIndex((tool) => tool.barang_id === index)
        const barangX = tools.find((x) => x.barang_id === index)

        if (barangX.qty > 1) {
            tools[getId].qty -= 1
            $("table tbody tr:eq(" + getId + ")").find("td:eq(1)").text(tools[getId].qty);
        } else {
            $("table tbody tr:eq(" + getId + ")").remove();
            alert("hebat kehapus" + getId)
            tools = tools.filter((x) => x.barang_id !== index)
            console.log(tools.filter((x) => x.barang_id !== index))
        }

        $('#barang-dipilih-column').val(JSON.stringify(tools))

    }
</script>
<script>
    $(document).ready(function() {
        //menampilkan ke table
        JSON.parse($('#barang-dipilih-column').val()).forEach(element => {

            var newRow = "<tr>";
            newRow += "<td>" + element.nama_barang + "</td>";
            newRow += "<td>" + element.quantity + " " + element.satuan + "</td>";
            newRow += "</tr>";

            $("table tbody#body_barang").append(newRow);

        });
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
                type: "POST",
                url: "{{ route('pengajuan.store') }}",
                data: $(this).serialize(),
                dataType: "json",
                success: function(data) {
                    console.log("sukses cuk")
                    //peringatan ketika data yg diinputkan tidak sesuai
                    $('#alertnya').css({
                        display: 'block',
                        opacity: '100%'
                    });
                    $('#alertnya').html(`
                            <div class="alert alert-success alert-dismissible show fade">
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
                                <div class="alert alert-warning alert-dismissible show fade">
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
                                <div class="alert alert-danger alert-dismissible show fade">
                                    <i class="bi bi-exclamation-circle"></i> Gagal menyimpan data.
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


        $('#form_ulasan').submit(function(e) {
            e.preventDefault()

            $.ajax({
                type: "POST",
                url: "{{ route('pengajuan.ulasan', explode('/', (parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)))[3]) }}",
                data: $(this).serialize(),
                dataType: "json",
                success: function(data) {
                    console.log("sukses cuk")
                    //peringatan ketika data yg diinputkan tidak sesuai
                    $('#alertnya').css({
                        display: 'block',
                        opacity: '100%'
                    });
                    $('#alertnya').html(`
                            <div class="alert alert-success alert-dismissible show fade">
                                <i class="bi bi-check-circle"></i> Data berhasil disimpan.
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        `)
                    window.setTimeout(function() {
                        $("#alertnya").fadeTo(1000, 0).slideUp(1000, function() {
                            $(this).html(``);
                            location.reload();
                        });

                        // location.reload();
                    }, 2300);

                },
                error: function(jqXHR, exception) {
                    if (jqXHR.status === 422) {
                        //peringatan ketika data yg diinputkan tidak sesuai
                        errorMessage = jqXHR.responseJSON;
                        html = ''
                        html += `
                                <div class="alert alert-warning alert-dismissible show fade">
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
                        }, 2300);
                    } else {
                        //peringatan ketika data yg diinputkan tidak sesuai
                        $('#alertnya').html(`
                                <div class="alert alert-danger alert-dismissible show fade">
                                    <i class="bi bi-exclamation-circle"></i> Gagal menyimpan data.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            `)
                        window.setTimeout(function() {
                            $("#alertnya").fadeTo(1000, 0).slideUp(1000, function() {
                                $(this).html(``);
                                location.reload();
                            });
                        }, 2300);
                    }
                }

            })
        })

    })
</script>
@endsection
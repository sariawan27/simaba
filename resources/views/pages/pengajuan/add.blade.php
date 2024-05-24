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
                        <h5 class="card-title">
                            Form Pengajuan
                        </h5>
                    </div>
                    <div class="card-body">
                        <form id="form" class="form">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 col-12">
                                    <div class="row">
                                        <div class="col-md-12 col-12" style="display: none;">
                                            <div class="form-group">
                                                <label for="no-column">No.</label>
                                                <input type="text" id="no-column" class="form-control" placeholder="No." name="no" value="{{session()->get('users')['id']}}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="nama-column">Nama Taruni</label>
                                                <input type="text" id="nama-column" class="form-control" placeholder="Nama Taruni" name="nama" value="{{session()->get('users')['nama']}}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="no-telp-column">No. Telp</label>
                                                <input type="text" id="no-telp-column" class="form-control" placeholder="No. Telp" name="no_telp" value="{{session()->get('users')['no_telp']}}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <div class="row">
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="kamar-column">Kamar</label>
                                                <input type="text" id="kamar-column" class="form-control" placeholder="Kamar" name="nama_kamar" value="{{session()->get('users')['nama_kamar']}}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12">
                                            <div class="form-group">
                                                <label for="kd-pengajuan-column">Kode Pengajuan</label>
                                                <input type="text" id="kd-pengajuan-column" class="form-control" placeholder="Kode Pengajuan" name="kd_pengajuan" value="{{$kdPengajuan}}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-12" style="display: none;">
                                            <div class="form-group">
                                                <label for="barang-dipilih-column">Data Barang yang Dipilih</label>
                                                <input type="text" id="barang-dipilih-column" class="form-control" placeholder="Kode Pengajuan" name="barang_dipilih">
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
                                    <div class="form-group">
                                        <label for="">Daftar Barang</label>
                                        <select class="choices form-control select2" id="tool_list">
                                            <option value="">Silahkan Pilih Barang</option>
                                            @foreach ($dataBarang as $barangnya)
                                            <option value="{{$barangnya->id}}">{{$barangnya->nama_barang}}</option>
                                            @endforeach
                                        </select>
                                        <small class="text-danger" id="err_tool"></small>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Qty</label>
                                        <input type="number" min="1" id="qty" class="form-control">
                                        <small class="text-danger" id="err_qty"></small>
                                    </div>
                                    <div class="form-group" style="display: none;">
                                        <label for="">Data Barang</label>
                                        <input type="text" min="1" id="data_barang" class="form-control" value="{{json_encode($dataBarang)}}">
                                        <small class="text-danger" id="err_data_barang"></small>
                                    </div>
                                    <button class="btn btn-primary my-3" type="button" onclick="addTools()">Tambah Barang</button>
                                    <button class="btn btn-primary my-3 mx-2" type="button" onclick="getToolsNotBorrow()">Refresh</button>
                                    <table class="table table-borderd">
                                        <thead>
                                            <tr>
                                                <th>Barang</th>
                                                <th>Jumlah</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                    <a href="{{route('pengajuan.index')}}" class="btn btn-light-secondary me-1 mb-1">Batal</a>
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
                    <div class="alert alert-danger alert-dismissible show fade" style="z-index: 13;">
                        <i class="bi bi-check-circle"></i> Qty melebihi stok.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `)
                    window.setTimeout(function() {
                        $("#alertnya").fadeTo(1000, 0).slideUp(1000, function() {
                            $(this).html(``);
                        });

                        // location.reload();
                    }, 2300);
                } else {
                    if (tools[getId].qty + parseInt($('#qty').val()) > barangDipilih.max_quantity) {
                        $('#alertnya').css({
                            display: 'block',
                            opacity: '100%'
                        });
                        $('#alertnya').html(`
                        <div class="alert alert-danger alert-dismissible show fade" style="z-index: 13;">
                            <i class="bi bi-check-circle"></i> Hanya boleh maksimal ${barangDipilih.max_quantity} qty.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `)
                        window.setTimeout(function() {
                            $("#alertnya").fadeTo(1000, 0).slideUp(1000, function() {
                                $(this).html(``);
                            });

                            // location.reload();
                        }, 2300);
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
                    <div class="alert alert-danger alert-dismissible show fade" style="z-index: 13;">
                        <i class="bi bi-check-circle"></i> Qty melebihi stok.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `)
                    window.setTimeout(function() {
                        $("#alertnya").fadeTo(1000, 0).slideUp(1000, function() {
                            $(this).html(``);
                        });

                        // location.reload();
                    }, 2300);
                } else {
                    if (parseInt($('#qty').val()) > barangDipilih.max_quantity) {
                        $('#alertnya').css({
                            display: 'block',
                            opacity: '100%'
                        });
                        $('#alertnya').html(`
                        <div class="alert alert-danger alert-dismissible show fade" style="z-index: 13;">
                            <i class="bi bi-check-circle"></i> Hanya boleh maksimal ${barangDipilih.max_quantity} qty.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    `)
                        window.setTimeout(function() {
                            $("#alertnya").fadeTo(1000, 0).slideUp(1000, function() {
                                $(this).html(``);
                            });

                            // location.reload();
                        }, 2300);
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

                        $("table tbody").append(newRow);
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
            tools = tools.filter((x) => x.barang_id !== index)
            console.log(tools)
        }

        $('#barang-dipilih-column').val(JSON.stringify(tools))

    }

    function getToolsNotBorrow() {
        tools = []
        $('#barang-dipilih-column').val(tools)
        $("table tbody tr").remove();
    }
</script>
<script>
    $(document).ready(function() {
        $('#tool_list').change(function() {

        })

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
                type: "POST",
                url: "{{ route('pengajuan.store') }}",
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

                        location.href = "{{ route('pengajuan.index') }}";
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
    })
</script>
@endsection
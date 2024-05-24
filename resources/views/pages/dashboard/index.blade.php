@extends('layouts.master')

@section('content')
<div class="page-heading">
    <div class="row">
        <div class="col-6">
            <h3>Dashboard</h3>
        </div>
    </div>
</div>
<div class="page-content">
    <section class="row">
        <!-- page section -->

        <div class="row">
            <div class="col-6 col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-body px-4 py-4-5" style="cursor: pointer;" onclick="return location.href=`{{route('pengajuan.index')}}`">
                        <div class="row">
                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                <div class="stats-icon mb-2" style="background-color: #435ebe;">
                                    <i class="bi-book-half"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                <h6 class="text-muted font-semibold">Riwayat Pengajuan</h6>
                                <h6 class="font-extrabold mb-0">Info lebih lanjut <i class="bi-arrow-right-circle-fill"></i></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if(Auth::user()->level != 'taruni')
            <div class="col-6 col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-body px-4 py-4-5" style="cursor: pointer;" onclick="return location.href=`{{route('barang.index')}}`">
                        <div class="row">
                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                <div class="stats-icon mb-2" style="background-color: #435ebe;">
                                    <i class="bi-box-fill"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                <h6 class="text-muted font-semibold">Informasi Barang</h6>
                                <h6 class="font-extrabold mb-0">Info lebih lanjut <i class="bi-arrow-right-circle-fill"></i></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-body px-4 py-4-5" style="cursor: pointer;" onclick="return location.href=`{{route('kamar.index')}}`">
                        <div class="row">
                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                <div class="stats-icon mb-2" style="background-color: #435ebe;">
                                    <i class="bi-door-closed-fill"></i>
                                </div>
                            </div>
                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                <h6 class="text-muted font-semibold">Informasi Kamar</h6>
                                <h6 class="font-extrabold mb-0">Info lebih lanjut <i class="bi-arrow-right-circle-fill"></i></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        @if(Auth::user()->level != 'taruni')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Stok Barang Tersedia</h4>
                    </div>
                    <div class="card-body">
                        @foreach (json_decode($barangAkanHabis) as $value)
                        <div class="row mt-1">
                            <div class="col-12">
                                <div class="alert alert-light-danger alert-dismissible color-danger">
                                    <i class="bi bi-exclamation-circle"></i> {{$value->nama_barang}} akan habis.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <div id="barang-chart"></div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Transaksi Pengajuan Barang</h4>
                    </div>
                    <div class="card-body">
                        <div id="wkwk"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page section -->
    </section>
</div>

<script src="{{asset('assets/compiled/js/app.js')}}"></script>
<!-- Need: Apexcharts -->
<script src="{{asset('assets/extensions/apexcharts/apexcharts.min.js')}}"></script>
<script>
    console.log(JSON.parse('{!!$barangGraf!!}'))
    var optionsPengajuan = {
        annotations: {
            position: "back",
        },
        dataLabels: {
            enabled: false,
        },
        chart: {
            type: "bar",
            height: 300,
        },
        fill: {
            opacity: 1,
        },
        plotOptions: {},
        tooltip: {
            custom: function({
                series,
                seriesIndex,
                dataPointIndex,
                w
            }) {
                console.log("series: ", series)
                console.log("data: ", JSON.parse('{!!$arrBarang!!}')[dataPointIndex])
                console.log("dataPointIndex: ", dataPointIndex)
                var html = '<div class="row"><div class="col-8"></div></div>';
                JSON.parse('{!!$arrBarang!!}')[dataPointIndex].forEach(element => {
                    html += '<div class="row"><div class="col-8">' + element?.nama_barang + ': ' + '</div> <div class="col-4 d-flex justify-content-end">' + element?.quantity + '</div> </div>'
                });
                return '<div class="arrow_box" style="margin:5px 8px 5px 8px;">' +
                    '<div class=" text-center" style="margin:5px 8px 5px 8px;"><h5>Info</h5></div>' +
                    html +
                    '</div>'
            }
        },
        series: [{
            name: "sales",
            data: JSON.parse("{{$pengajuanGraf}}"),
        }, ],
        colors: "#435ebe",
        xaxis: {
            categories: [
                "Jan",
                "Feb",
                "Mar",
                "Apr",
                "May",
                "Jun",
                "Jul",
                "Aug",
                "Sep",
                "Oct",
                "Nov",
                "Dec",
            ],
        },
    }

    var chartPengajuan = new ApexCharts(
        document.querySelector("#wkwk"),
        optionsPengajuan
    )

    chartPengajuan.render()

    var optionsBarang = {
        annotations: {
            position: "back",
        },
        dataLabels: {
            enabled: false,
        },
        chart: {
            type: "bar",
            height: 300,
        },
        fill: {
            opacity: 1,
        },
        tooltip: {
            theme: 'dark',
            x: {
                show: false
            },
            y: {
                title: {
                    formatter: function() {
                        return ''
                    }
                }
            }
        },
        plotOptions: {
            bar: {
                barHeight: '100%',
                distributed: true,
                dataLabels: {
                    position: 'bottom'
                },
            }
        },
        series: [{
            data: JSON.parse('{!!$barangGraf!!}').value,
        }, ],
        colors: ['#F44236', '#435ebe', '#F44236'],
        xaxis: {
            categories: JSON.parse('{!!$barangGraf!!}').xaxis,
        },
    }

    var chartBarang = new ApexCharts(
        document.querySelector("#barang-chart"),
        optionsBarang
    )

    chartBarang.render()
</script>
@endsection
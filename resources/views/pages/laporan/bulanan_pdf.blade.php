<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Invoice</title>

    <style>
        table,
        .wkwk,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>

<body>
    <table class="w-full border-1" style="width: 100%">
        <tr>
            <td style="width: 20%; text-align: center" rowspan="2">
                <img src="https://akupintar.id/documents/20143/0/20190709015648732_48346779.png/9ed84478-3a51-5d33-e29f-9bd1bd64b5db?version=1.0&t=1562637408871&imageThumbnail=1" alt="laravel daily" width="60" />
            </td>
            <td style="text-align: center" rowspan="1">
                <div style="font-size: 18px; margin-bottom: 0.5rem">
                    <b>AKADEMI MARITIM NUSANTARA</b>
                </div>
                <div style="font-size: 12px">
                    Jl Kendeng 307 Cilacap, Phone (0282) 541254
                </div>
            </td>
            <td style="width: 25%">
                <b>Bulan: {{$bulan}}</b>
            </td>
        </tr>
        <tr>
            <td style="text-align: center">
                <b>PERMINTAAN BARANG DALAM 1 BULAN</b>
            </td>
            <td style="width: 25%">
                <span><b>Halaman:</b> ..... dari .....</span>
            </td>
        </tr>
    </table>

    <div style="margin-top: 1.5rem">
        <div>Kepada</div>
        <div>Yth. Kepala Asrama</div>
        <div>Di tempat</div>
    </div>

    <div style="margin-top: 2rem">
        <div>Diajukan kebutuhan asrama sebagai berikut:</div>
        <table style="margin-top: 1rem; width: 100%">
            <tr>
                <th style="width: 7%; text-align: center">No.</th>
                <th style="width: 68%; text-align: center">Nama Barang</th>
                <th style="width: 25%; text-align: center">Jumlah</th>
            </tr>
            @foreach($detailPengajuan as $key => $item)
            <tr class="items">
                <td style="width: 7%; text-align: center">{{ $key+1 }}</td>
                <td>{{ $item["nama_barang"] }}</td>
                <td style="width: 15%; text-align: center">
                    {{ $item["quantity"] }}
                </td>
            </tr>
            @endforeach
        </table>
    </div>

    <table style="width: 100%; border: unset; margin-top: 1.5rem">
        <tr style="border: unset">
            <td style="border: unset; text-align: center; width: 50%">
                <div style="height: 14px; margin-bottom: 1rem"></div>
                <div>Mengetahui,</div>
                <div>Pengasuh Asrama</div>
                <div style="margin-top: 5.5rem">.........</div>
            </td>
            <td style="border: unset; text-align: center; width: 50%">
                <div style="height: 14px; margin-bottom: 1rem">
                    Cilacap, ..... ............... ......
                </div>
                <div>Mengetahui,</div>
                <div>Kepala Asrama</div>
                <div style="margin-top: 5.5rem">.........</div>
            </td>
        </tr>
    </table>
</body>

</html>
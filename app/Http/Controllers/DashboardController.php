<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\DetailPengajuan;
use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $arr = [];
        $arrBarangPengajuan = [];
        $sessionnya = session()->get('users');
        if ($sessionnya['level'] == 'taruni') {
            for ($i = 1; $i <= 12; $i++) {
                // $dataPengajuan = Pengajuan::select('pengajuan.*', 'users.nama', 'users.email', 'users.alamat', 'users.nama', 'users.no_identitas', 'users.no_telp', 'users.level', 'taruni.nim', 'taruni.angkatan', 'kamar.nama_kamar')->leftJoin('users', 'pengajuan.user_id', '=', 'users.id')->leftJoin('taruni', 'users.id', '=', 'taruni.user_id')->leftJoin('kamar', 'kamar.id', '=', 'taruni.kamar_id')->where('pengajuan.id',  $id)->orderBy('pengajuan.created_at', 'desc')->first();
                // $dataDetailPengajuan = Pengajuan::leftJoin('detail_pengajuan', 'detail_pengajuan.pengajuan_id', '=', 'pengajuan.id')->leftJoin('barang', 'detail_pengajuan.barang_id', '=', 'barang.id')->where('pengajuan.user_id', $sessionnya->id)->whereMonth('pengajuan.created_at', $i)->get();
                $data = Pengajuan::where('user_id', $sessionnya->id)->whereMonth('created_at', $i)->count();
                $dataDetailPengajuan = DetailPengajuan::select('barang.id', 'barang.nama_barang', 'barang.satuan')->selectRaw(DB::raw('sum(`detail_pengajuan`.`quantity`) as quantity'))->leftJoin('barang', 'detail_pengajuan.barang_id', '=', 'barang.id')->leftJoin('pengajuan', 'detail_pengajuan.pengajuan_id', '=', 'pengajuan.id')->where('pengajuan.user_id', $sessionnya->id)->whereMonth('detail_pengajuan.created_at', $i)->groupBy('detail_pengajuan.barang_id')->get();
                // foreach ($dataDetailPengajuan as $key => $value) {
                //     $data = [
                //         "name" => $value->nama_barang,
                //         "data" => 
                //     ];
                // }
                array_push($arrBarangPengajuan, $dataDetailPengajuan->toArray());
                // array_push($arrBarang, [
                //     "nama_barang" => array_map(function ($row) {
                //         return $row->nama_barang;
                //     }, $dataDetailPengajuan),
                //     "quantity" => "wkwk",
                // ]);
                array_push($arr, $data);
            }
        } else {
            for ($i = 1; $i <= 12; $i++) {
                // $dataDetailPengajuan = Pengajuan::leftJoin('detail_pengajuan', 'detail_pengajuan.pengajuan_id', '=', 'pengajuan.id')->leftJoin('barang', 'detail_pengajuan.barang_id', '=', 'barang.id')->whereMonth('pengajuan.created_at', $i)->get();

                $dataDetailPengajuan = DetailPengajuan::select('barang.id', 'barang.nama_barang', 'barang.satuan')->selectRaw(DB::raw('sum(`detail_pengajuan`.`quantity`) as quantity'))->leftJoin('barang', 'detail_pengajuan.barang_id', '=', 'barang.id')->whereMonth('detail_pengajuan.created_at', $i)->groupBy('detail_pengajuan.barang_id')->get();
                $data = Pengajuan::whereMonth('created_at', $i)->count();

                array_push($arrBarangPengajuan, $dataDetailPengajuan->toArray());
                // die();
                array_push($arr, $data);
            }
        }

        $barangData = Barang::get();
        $arrBarang = [];
        $xaxis = [];
        $color = [];
        foreach ($barangData as $key => $value) {
            array_push($arrBarang, $value->stok);
            array_push($xaxis, $value->nama_barang);
            $colorCondition = ($value->stok <= 5 ? "#F44236" : "#435ebe");
            array_push($color, $colorCondition);
        }

        $barangWillBeEmpty = Barang::where('stok', '<=', 5)->where('stok', '>', 0)->get();
        return view("pages.dashboard.index", [
            "pengajuanGraf" => json_encode($arr),
            "barangGraf" => json_encode(array(
                "xaxis" => $xaxis,
                "value" => $arrBarang,
                "color" => $color,
            )),
            "arrBarang" => json_encode($arrBarangPengajuan),
            "barangAkanHabis" => json_encode($barangWillBeEmpty)
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\DetailPengajuan;
use App\Models\Pengajuan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $arr = [];
        $sessionnya = session()->get('users');
        if ($sessionnya['level'] == 'taruni') {
            for ($i = 1; $i <= 12; $i++) {
                $dataDetailPengajuan = DetailPengajuan::select('barang.id', 'barang.nama_barang', 'barang.satuan')->selectRaw(DB::raw('sum(`detail_pengajuan`.`quantity`) as quantity'))->leftJoin('barang', 'detail_pengajuan.barang_id', '=', 'barang.id')->where('detail_pengajuan.created_at', 'like', '%' . $request->bulan . '%')->groupBy('detail_pengajuan.barang_id')->get();

                array_push($arr, $dataDetailPengajuan);
            }
        } else {
            for ($i = 1; $i <= 12; $i++) {
                $data = Pengajuan::whereMonth('created_at', $i)->count();
                array_push($arr, $data);
            }
        }
        return view("pages.dashboard.index", [
            "pengajuanGraf" => json_encode($arr)
        ]);
    }
}

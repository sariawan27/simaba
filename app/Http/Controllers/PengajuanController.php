<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\DetailPengajuan;
use App\Models\Pengajuan;
use App\Models\Ulasan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class PengajuanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $sessionnya = session()->get('users');
            if ($sessionnya['level']=='taruni') {
                $data = Pengajuan::where('user_id', $sessionnya->id)->get();
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $actionBtn = '<a href="'.route('pengajuan.show', $row->id).'" class="edit btn btn-info btn-sm">Detail</a> <a href="'.route('pengajuan.delete', $row->id).'" class="delete btn btn-danger btn-sm">Delete</a>';
                        return $actionBtn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            } else {
                $data = Pengajuan::get();
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $actionBtn = '<a href="'.route('pengajuan.show', $row->id).'" class="edit btn btn-info btn-sm">Detail</a>';
                        return $actionBtn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
        }

        return view('pages.pengajuan.index', []);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sessionnya = session()->get('users');
        if ($sessionnya['level']!='taruni') {
            return view('pages.error.error404');
        }

        $barang =  Barang::latest()->get();

        $barangTerakhir = Pengajuan::orderBy('created_at', 'desc')->first();
        if ($barangTerakhir) {
            $kodePengajuan = "KP".str_pad(intval(substr($barangTerakhir->kd_pengajuan, -1))+1, 7, '0', STR_PAD_LEFT);
        } else {
            $kodePengajuan = "KP".str_pad("0", 7, '0', STR_PAD_LEFT);
        }
        return view('pages.pengajuan.add', [
            'dataBarang' => $barang,
            'kdPengajuan' => $kodePengajuan
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no'              => 'required',
            'kd_pengajuan'              => 'required',
            'barang_dipilih'              => 'required',
        ]);

        if ($validator->fails()) return response()->json($validator->messages(), 422);


        $pengajuan = new Pengajuan();
        $pengajuan->user_id = $request->no;
        $pengajuan->kd_pengajuan = $request->kd_pengajuan;
        $pengajuan->status = "waiting";
        $pengajuan->save();

        try {
            if (json_decode($request->barang_dipilih)) {
                foreach (json_decode($request->barang_dipilih) as $key => $value) {
                    $barang = Barang::where('id', $value->barang_id);
                    $dataBarang = $barang->first();

                    $barang->update([
                        "stok" => $dataBarang->stok - $value->qty
                    ]);

                    $detail = new DetailPengajuan();
                    $detail->barang_id = $value->barang_id;
                    $detail->quantity = $value->qty;
                    $detail->pengajuan_id = $pengajuan->id;
                    $detail->save();
                }
            } else {
                return response()->json(['message' => 'Gagal menyimpan data pengajuan']);
            }
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['message' => 'Gagal menyimpan data pengajuan']);
        }

        return response()->json(['message' => 'Data saved successfully', 'data' => $pengajuan]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id=null)
    {
        // $sessionnya = session()->get('users');

        $dataPengajuan = Pengajuan::select('pengajuan.*', 'users.nama', 'users.email', 'users.alamat', 'users.nama', 'users.no_identitas', 'users.no_telp', 'users.level', 'taruni.nim', 'taruni.angkatan', 'kamar.nama_kamar')->leftJoin('users', 'pengajuan.user_id', '=', 'users.id')->leftJoin('taruni', 'users.id', '=', 'taruni.user_id')->leftJoin('kamar', 'kamar.id', '=', 'taruni.kamar_id')->where('pengajuan.id',  $id)->orderBy('pengajuan.created_at', 'desc')->first();
        $dataDetailPengajuan = DetailPengajuan::leftJoin('barang', 'detail_pengajuan.barang_id', '=', 'barang.id')->where('detail_pengajuan.pengajuan_id', $id)->get();

        $dataAssign = User::where('id', $dataPengajuan->assign_by)->first();

        $dataUlasan = Ulasan::where('pengajuan_id', $id)->get();

        return view('pages.pengajuan.detail', [
            'dataPengajuan' => $dataPengajuan,
            'detailPengajuan' => $dataDetailPengajuan,
            'dataAssign' => $dataAssign,
            'dataUlasan' => $dataUlasan
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengajuan $pengajuan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengajuan $pengajuan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id=null)
    {
        $pengajuan = Pengajuan::find($id);

        // delete related
        $pengajuan->detailPengajuan()->delete();
        $pengajuan->ulasan()->delete();
        $pengajuan->delete();

        return redirect()->route('pengajuan.index')->with(['success' => 'Data telah dihapus!']);
    }

    function wkwk() {
        $allData = session()->all();

        return response()->json(['message' => 'Data saved successfully', 'data' => $allData]);
    }

    function setujuiPengajuan($id=null) {
        $sessionnya = session()->get('users');
        if ($sessionnya['level']!='pengasuh') {
            return view('pages.error.error404');
        }

        Pengajuan::where('id', intval($id))->update([
            "status" => "approved",
            "assign_by" => $sessionnya["id"],
            "assign_at" => date("Y-m-d H:i:s")
        ]);

        return redirect()->route('pengajuan.show', $id);
    }

    function tolakPengajuan($id=null) {
        $sessionnya = session()->get('users');
        if ($sessionnya['level']!='pengasuh') {
            return view('pages.error.error404');
        }

        Pengajuan::where('id', intval($id))->update([
            "status" => "rejected"
        ]);

        return redirect()->route('pengajuan.show', $id);
    }

    function selesaiKirimBarang($id=null) {
        $sessionnya = session()->get('users');
        if ($sessionnya['level']!='taruni') {
            return view('pages.error.error404');
        }

        Pengajuan::where('id', intval($id))->update([
            "status" => "arrived"
        ]);

        return redirect()->route('pengajuan.show', $id);
    }

    function ulasanPengajuan(Request $request, $id=null) {
        $sessionnya = session()->get('users');
        if ($sessionnya['level']!='taruni') {
            return view('pages.error.error404');
        }

        $ulasan = new Ulasan();
        $ulasan->pengajuan_id = $id;
        $ulasan->catatan_ulasan = $request->ulasan;
        $ulasan->save();

        return response(200);
    }
}

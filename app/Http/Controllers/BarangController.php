<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Barang::latest()->get();
            $userSession = session()->get('users');
            if ($userSession->level == 'pengasuh') {
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $actionBtn = '<a href="' . route('barang.edit', $row->id) . '" class="edit btn btn-info btn-sm">Edit</a> <a href="' . route('barang.delete', $row->id) . '" class="delete btn btn-danger btn-sm">Delete</a>';
                        return $actionBtn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            } else {
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->make(true);
            }
        }

        return view('pages.barang.index', []);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.barang.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_barang'              => 'required',
            'stok' => 'required',
            'satuan' => 'required',
            'max_quantity' => 'required'
        ]);

        if ($validator->fails()) return response()->json($validator->messages(), 422);


        $barang = new Barang();
        $barang->nama_barang = $request->nama_barang;
        $barang->stok = $request->stok;
        $barang->satuan = $request->satuan;
        $barang->description = $request->description;
        $barang->max_quantity = $request->max_quantity;
        $barang->save();

        return response()->json(['message' => 'Data saved successfully', 'data' => $barang]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id = null)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id = null)
    {
        $dataBarang = Barang::where('id', $id)->first();

        return view('pages.barang.edit', [
            'data' => $dataBarang
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id = null)
    {
        $validator = Validator::make($request->all(), [
            'nama_barang'              => 'required',
            'stok' => 'required',
            'satuan' => 'required',
            'max_quantity' => 'required'
        ]);

        if ($validator->fails()) return response()->json($validator->messages(), 422);

        $barangUpdated = Barang::where('id', intval($id))->update([
            "nama_barang" => $request->nama_barang,
            "stok"  => $request->stok,
            "satuan" => $request->satuan,
            "description" => $request->description,
            "max_pengajuan" => $request->max_pengajuan,
            "max_quantity" => $request->max_quantity

        ]);

        return response()->json(['message' => 'Data updated successfully', 'data' => $barangUpdated]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $barang = Barang::where('id', $id)->delete();

        return redirect()->route('barang.index')->with(['success' => 'Data telah dihapus!']);
    }
}

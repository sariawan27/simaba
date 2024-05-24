<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Taruni;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class KamarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Kamar::latest()->get();
            $userSession = session()->get('users');
            if ($userSession->level == 'pengasuh') {
                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $actionBtn = '<a href="' . route('kamar.show', $row->id) . '" class="edit btn btn-info btn-sm">Detail</a> <a href="' . route('kamar.delete', $row->id) . '" class="delete btn btn-danger btn-sm">Delete</a>';
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

        return view('pages.kamar.index', []);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.kamar.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kamar'              => 'required',
        ]);

        if ($validator->fails()) return response()->json($validator->messages(), 422);


        $kamar = new Kamar();
        $kamar->nama_kamar = $request->nama_kamar;
        $kamar->deskripsi = $request->deskripsi;
        $kamar->save();

        return response()->json(['message' => 'Data saved successfully', 'data' => $kamar]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id = null)
    {
        $dataKamar = Kamar::where('id', $id)->first();

        $dataUser = User::leftJoin('taruni', 'taruni.user_id', '=', 'users.id')->where('taruni.kamar_id', $id)->get();

        $allDataTaruni = User::leftJoin('taruni', 'taruni.user_id', '=', 'users.id')->where('users.level', 'taruni')->where('taruni.kamar_id', null)->get();

        return view('pages.kamar.edit', [
            'data' => $dataKamar,
            'allDataTaruni' => $allDataTaruni,
            'dataUser' =>  $dataUser
        ]);
    }

    /**
     * Tambah Taruni ke kamar X
     */
    public function addTaruni(Request $request, $id = null)
    {
        if ($request->taruni) {
            $taruni = explode(",", $request->taruni);

            foreach ($taruni as $key => $value) {
                $taruni = new Taruni();
                $taruni->where('id', intval($value))->update([
                    "kamar_id" => $id,
                ]);
            }

            return response()->json(['message' => 'Data saved successfully']);
        } else {
            return response()->json("Gagal menyimpan data", 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id = null)
    {
        $validator = Validator::make($request->all(), [
            'nama_kamar'              => 'required',
        ]);

        if ($validator->fails()) return response()->json($validator->messages(), 422);


        $kamar = Kamar::where('id', $id)->update([
            "nama_kamar" =>  $request->nama_kamar,
            "deskripsi" => $request->deskripsi
        ]);

        return response()->json(['message' => 'Data saved successfully', 'data' => $kamar]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id = null)
    {
        $kamar = Kamar::find($id);

        // delete related
        Taruni::where("kamar_id", $id)->update([
            "kamar_id" => null
        ]);
        $kamar->delete();

        return redirect()->route('kamar.index')->with(['success' => 'Data telah dihapus!']);
    }
}

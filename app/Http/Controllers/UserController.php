<?php

namespace App\Http\Controllers;

use App\Models\Taruni;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('users.edit', $row->id) . '" class="edit btn btn-primary btn-sm">Edit</a> <a href="' . route('users.delete', $row->id) . '" class="delete btn btn-danger btn-sm" onclick="return confirm(' . "'Yakin ingin menghapus ini?'" . ');">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.user.index', []);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.user.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_identity'              => 'required',
            'nama'              => 'required',
            'email'             => 'required',
            'level'             => 'required',
            'alamat'             => 'required',
            'no_telp'             => 'required|numeric'
        ]);

        if ($validator->fails()) return response()->json($validator->messages(), 422);


        $user = new User();
        $user->password = Hash::make('123');
        $user->no_identitas  = $request->no_identity;
        $user->nama  = $request->nama;
        $user->email = $request->email;
        $user->no_telp = $request->no_telp;
        $user->level = $request->level;
        $user->alamat = $request->alamat;
        $user->save();

        if ($request->level == 'taruni') {
            try {
                $taruni = new Taruni();
                $taruni->nim = $request->nim;
                $taruni->angkatan = $request->angkatan;
                $taruni->user_id = $user->id;
                $taruni->save();
            } catch (\Throwable $th) {
                //throw $th;
                return response()->json(['message' => 'Gagal menyimpan data taruni']);
            }
        }

        return response()->json(['message' => 'Data saved successfully', 'data' => $user]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id = null)
    {
        $dataUser = User::leftJoin('taruni', 'users.id', '=', 'taruni.user_id')->leftJoin('kamar', 'kamar.id', '=', 'taruni.kamar_id')->where('users.id', $id)->first();

        return view('pages.user.edit', [
            'data' => $dataUser
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id = null)
    {
        $validator = Validator::make($request->all(), [
            'no_identity'              => 'required',
            'nama'              => 'required',
            'email'             => 'required',
            'level'             => 'required',
            'alamat'             => 'required',
            'no_telp'             => 'required|numeric'
        ]);

        if ($validator->fails()) return response()->json($validator->messages(), 422);


        $userUpdated = User::where('id', intval($id))->update([
            "no_identitas" => $request->no_identity,
            "nama"  => $request->nama,
            "email" => $request->email,
            "no_telp" => $request->no_telp,
            "level" => $request->level,
            "alamat" => $request->alamat,

        ]);

        if ($request->level == 'taruni') {
            try {
                $taruni = new Taruni();
                $taruni->where('user_id', $id)->update([
                    "nim" => $request->nim,
                    "angkatan" => $request->angkatan
                ]);
            } catch (\Throwable $th) {
                //throw $th;
                return response()->json(['message' => 'Gagal mengupdate data taruni']);
            }
        }

        return response()->json(['message' => 'Data saved successfully', 'data' => $userUpdated]);
    }

    /**
     * Kamar Taruni
     */
    public function kamarTaruni(Request $request, $id = null)
    {
        if ($request->ajax()) {
            $data = User::leftJoin('taruni', 'users.id', '=', 'taruni.user_id')->leftJoin('kamar', 'kamar.id', '=', 'taruni.kamar_id')->where('kamar.id', $id)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('users.edit', $row->id) . '" class="edit btn btn-primary btn-sm">Edit</a> <a href="' . route('users.delete_kamar_taruni', [$row->id, $row->user_id]) . '" class="delete btn btn-danger btn-sm" onclick="return confirm(' . "'Yakin ingin menghapus ini?'" . ');">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }


        return view('pages.kamar.show', []);
    }

    public function deleteKamarTaruni($id = null, $userId = null)
    {
        Taruni::where("kamar_id", $id)->where('user_id', $userId)->update([
            "kamar_id" => null
        ]);

        return redirect()->route('kamar.show', $id)->with(['success' => 'Data telah dihapus!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id = null)
    {
        $user = User::find($id);

        // delete related
        $user->taruni()->delete();
        $user->delete();

        return redirect()->route('users.index')->with(['success' => 'Data telah dihapus!']);
    }

    public function profile()
    {
        $userSession = session()->get('users');
        if (!$userSession) {
            return redirect()->route('dashboard.index');
        }

        $dataUser = User::select('users.id', 'users.nama', 'users.email', 'users.password', 'users.alamat', 'users.no_identitas', 'users.no_telp', 'users.level', 'users.created_at', 'users.updated_at', 'taruni.kamar_id', 'taruni.nim', 'taruni.angkatan', 'taruni.id as taruni_id', 'kamar.nama_kamar')->leftJoin('taruni', 'taruni.user_id', '=', 'users.id')->leftJoin('kamar', 'kamar.id', '=', 'taruni.kamar_id')->where('users.id', $userSession->id)->first();

        return view('pages.user.profile', [
            'data' => $dataUser
        ]);
    }

    public function updateProfile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_identity'              => 'required',
            'nama'              => 'required',
            'email'             => 'required',
            'alamat'             => 'required',
            'no_telp'             => 'required|numeric'
        ]);

        if ($validator->fails()) return response()->json($validator->messages(), 422);

        if ($request->password == null) {
            $userUpdated = User::where('id', intval($request->id))->update([
                "no_identitas" => $request->no_identity,
                "nama"  => $request->nama,
                "email" => $request->email,
                "no_telp" => $request->no_telp,
                "level" => $request->level,
                "alamat" => $request->alamat,

            ]);
        } else {
            $userUpdated = User::where('id', intval($request->id))->update([
                "no_identitas" => $request->no_identity,
                "nama"  => $request->nama,
                "email" => $request->email,
                "no_telp" => $request->no_telp,
                "level" => $request->level,
                "alamat" => $request->alamat,
                "password" =>  Hash::make($request->password)

            ]);
        }

        if ($request->level == 'taruni') {
            try {
                $taruni = new Taruni();
                $taruni->where('user_id', $request->id)->update([
                    "nim" => $request->nim,
                    "angkatan" => $request->angkatan
                ]);
            } catch (\Throwable $th) {
                //throw $th;
                return response()->json(['message' => 'Gagal mengupdate data taruni']);
            }
        }

        return response()->json(['message' => 'Data saved successfully', 'data' => $userUpdated]);
    }
}

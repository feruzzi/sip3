<?php

namespace App\Http\Controllers;

use App\Models\Group1;
use App\Models\Group2;
use Exception;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Haruncpi\LaravelIdGenerator\IdGenerator;


use Illuminate\Http\Request;

class UserGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.user-group.index', [
            'set_active' => 'user_group',
            // 'users' => $users
        ]);
    }
    public function group1_view()
    {
        $group1 = Group1::all();
        return Datatables::of($group1)
            ->addIndexColumn()
            ->addColumn('status', function ($group1) {
                return view('dashboard.user-group.group1.style-status')->with('group1', $group1);
            })
            ->addColumn('action', function ($group1) {
                return view('dashboard.user-group.group1.action-buttons')->with('group1', $group1);
            })
            ->make(true);
    }
    public function group2_view()
    {
        $group2 = Group2::all();
        return Datatables::of($group2)
            ->addIndexColumn()
            ->addColumn('status', function ($group2) {
                return view('dashboard.user-group.group2.style-status')->with('group2', $group2);
            })
            ->addColumn('action', function ($group2) {
                return view('dashboard.user-group.group2.action-buttons')->with('group2', $group2);
            })
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function group1_store(Request $request)
    {
        // return response()->json($request);
        $validate = Validator::make($request->all(), [
            'group1_name' => 'required|unique:group1|max:10|min:4',
        ], [
            'group1_name.required' => 'Nama Angkatan Wajib Diisi',
            'group1_name.unique' => 'Nama Angkatan Sudah Digunakan',
            'group1_name.min' => 'Nama Angkatan Minimal 4 Digit',
            'group1_name.max' => 'Nama Angkatan Maksimal 10 Digit',
        ]);
        if ($validate->fails()) {
            return response()->json(['msg' => "Angkatan Gagal Ditambahkan", 'errors' => $validate->errors()]);
        } else {
            $group1_id = IdGenerator::generate(['table' => 'group1', 'field' => 'group1_id', 'length' => 6, 'prefix' => 'gp1-']);
            //output: gp1-01
            Group1::create([
                'group1_id' => $group1_id,
                'group1_name' => $request->group1_name,
                'group1_status' => 1
            ]);
            return response()->json(['msg' => "Angkatan $request->group1_name Berhasil ditambahkan"]);
        }
    }

    public function group2_store(Request $request)
    {
        // return response()->json($request);
        $validate = Validator::make($request->all(), [
            'group2_name' => 'required|unique:group2|max:10|min:4',
        ], [
            'group2_name.required' => 'Nama Angkatan Wajib Diisi',
            'group2_name.unique' => 'Nama Angkatan Sudah Digunakan',
            'group2_name.min' => 'Nama Angkatan Minimal 4 Digit',
            'group2_name.max' => 'Nama Angkatan Maksimal 10 Digit',
        ]);
        if ($validate->fails()) {
            return response()->json(['msg' => "Angkatan Gagal Ditambahkan", 'errors' => $validate->errors()]);
        } else {
            $group2_id = IdGenerator::generate(['table' => 'group2', 'field' => 'group2_id', 'length' => 6, 'prefix' => 'gp2-']);
            //output: gp1-01
            Group2::create([
                'group2_id' => $group2_id,
                'group2_name' => $request->group2_name,
                'group2_status' => 1
            ]);
            return response()->json(['msg' => "Jurusan $request->group2_name Berhasil ditambahkan"]);
        }
    }

    public function group1_set($id)
    {
        $set = Group1::where('group1_id', $id)->first();
        if ($set->group1_status == "1") {
            Group1::where('group1_id', $id)->update([
                'group1_status' => 0
            ]);
            $status = "Di Non-Aktifkan";
        } else {
            Group1::where('group1_id', $id)->update([
                'group1_status' => 1
            ]);
            $status = "Di Aktifkan";
        }
        return response()->json(['msg' => "Status Angkatan Berhasil $status"]);
    }

    public function group2_set($id)
    {
        $set = Group2::where('group2_id', $id)->first();
        if ($set->group2_status == "1") {
            Group2::where('group2_id', $id)->update([
                'group2_status' => 0
            ]);
            $status = "Di Non-Aktifkan";
        } else {
            Group2::where('group2_id', $id)->update([
                'group2_status' => 1
            ]);
            $status = "Di Aktifkan";
        }
        return response()->json(['msg' => "Status Jurusan Berhasil $status"]);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function group1_edit($id)
    {
        $data = Group1::where('group1_id', $id)->first();
        return response()->json(['result' => $data]);
    }

    public function group2_edit($id)
    {
        $data = Group2::where('group2_id', $id)->first();
        return response()->json(['result' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function group1_update(Request $request, $id)
    {
        $data = Group1::where('group1_id', $id)->first();
        if ($request->group1_name == $data->group1_name) {
            return response()->json(["msg" => "$request->group1_name Tidak terjadi perubahan"]);
        } else {
            $validate = Validator::make($request->all(), [
                'group1_name' => 'required|unique:group1|max:10|min:4',
            ], [
                'group1_name.required' => 'Nama Angkatan Wajib Diisi',
                'group1_name.unique' => 'Nama Angkatan Sudah Digunakan',
                'group1_name.min' => 'Nama Angkatan Minimal 4 Digit',
                'group1_name.max' => 'Nama Angkatan Maksimal 10 Digit',
            ]);
            if ($validate->fails()) {
                return response()->json(['msg' => "Angkatan Gagal Ditambahkan", 'errors' => $validate->errors()]);
            } else {
                Group1::where('group1_id', $id)->update([
                    'group1_name' => $request->group1_name
                ]);
                return response()->json(['msg' => "$data->group1_name Berhasil diperbarui Menjadi $request->group1_name"]);
            }
        }
    }

    public function group2_update(Request $request, $id)
    {
        $data = Group2::where('group2_id', $id)->first();
        if ($request->group2_name == $data->group2_name) {
            return response()->json(["msg" => "$request->group2_name Tidak terjadi perubahan"]);
        } else {
            $validate = Validator::make($request->all(), [
                'group2_name' => 'required|unique:group2|max:10|min:4',
            ], [
                'group2_name.required' => 'Nama Angkatan Wajib Diisi',
                'group2_name.unique' => 'Nama Angkatan Sudah Digunakan',
                'group2_name.min' => 'Nama Angkatan Minimal 4 Digit',
                'group2_name.max' => 'Nama Angkatan Maksimal 10 Digit',
            ]);
            if ($validate->fails()) {
                return response()->json(['msg' => "Angkatan Gagal Ditambahkan", 'errors' => $validate->errors()]);
            } else {
                Group2::where('group2_id', $id)->update([
                    'group2_name' => $request->group2_name
                ]);
                return response()->json(['msg' => "$data->group2_name Berhasil diperbarui Menjadi $request->group2_name"]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function group1_destroy($id)
    {
        try {
            Group1::where('group1_id', $id)->delete();
            return response()->json(['msg' => "$id Berhasil dihapus"]);
        } catch (Exception $e) {
            return response()->json(['errors' => "Terjadi Kesalahan, Tidak Dapat Menghapus Data"]);
        }
    }
    public function group2_destroy($id)
    {
        try {

            Group2::where('group2_id', $id)->delete();
            return response()->json(['msg' => "$id Berhasil dihapus"]);
        } catch (Exception $e) {
            return response()->json(['errors' => "Terjadi Kesalahan, Tidak Dapat Menghapus Data"]);
        }
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Group1;
use App\Models\Group2;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Imports\UsersImport;
use Exception;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $users = User::all();
        return view('dashboard.users.index', [
            'set_active' => 'users',
            'groups1' => Group1::all(),
            'groups2' => Group2::all(),
            // 'users' => $users
        ]);
    }
    public function ajax_view()
    {
        // $users = User::all();
        $users = DB::table('users')
            ->join('group1', 'users.group1', '=', 'group1.group1_id')
            ->join('group2', 'users.group2', '=', 'group2.group2_id')
            ->select('users.username', 'users.name', 'group1.group1_name AS group1', 'group2.group2_name AS group2', 'users.level', 'users.status')->get();
        return Datatables::of($users)
            ->addIndexColumn()
            ->addColumn('level', function ($users) {
                return view('dashboard.users.style-level-user')->with('user', $users);
            })
            ->addColumn('status', function ($users) {
                return view('dashboard.users.style-status-user')->with('user', $users);
            })
            ->addColumn('action', function ($users) {
                return view('dashboard.users.action-buttons')->with('user', $users);
            })
            ->make(true);
    }
    public function set_user($id)
    {
        // return response()->json($id);
        $set = User::where('username', $id)->first();
        if ($set->status == "1") {
            User::where('username', $id)->update([
                'status' => 0
            ]);
            $status = "Di Non-Aktifkan";
        } else {
            User::where('username', $id)->update([
                'status' => 1
            ]);
            $status = "Di Aktifkan";
        }
        return response()->json(['msg' => "Status User Berhasil $status"]);
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
    public function store(Request $request)
    {
        // return response()->json($request);
        $validate = Validator::make($request->all(), [
            'username' => 'required|unique:users|max:10|min:4',
            'name' => 'required',
            'password' => 'required|min:4',
        ], [
            'username.required' => 'Username Wajib Diisi',
            'username.unique' => 'Username Sudah Digunakan',
            'username.min' => 'Username Minimal 4 Digit',
            'username.max' => 'Username Maksimal 16 Digit',
            'name.required' => 'Nama Wajib Diisi',
            'password.required' => 'Password Wajib Diisi',
            'password.min' => 'Password Minimal 4 Digit',
        ]);
        if ($validate->fails()) {
            return response()->json(['msg' => "User Gagal Ditambahkan", 'errors' => $validate->errors()]);
        } else {
            User::create([
                'username' => $request->username,
                'name' => $request->name,
                'password' => bcrypt($request->password),
                'group1' => $request->group1,
                'group2' => $request->group2,
                'level' => $request->level,
                'status' => 1,
            ]);
            return response()->json(['msg' => "$request->username Berhasil Ditambahkan"]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user, $id)
    {
        $data = User::where('username', $id)->first();
        return response()->json(['result' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        // return response()->json($request);
        // return response()->json($user);
        if ($request->password) {
            $validate = Validator::make($request->all(), [
                'name' => 'required',
                'password' => 'required|min:4',
            ], [
                'name.required' => 'Nama Wajib Diisi',
                'password.required' => 'Password Wajib Diisi',
                'password.min' => 'Password Minimal 4 Digit',
            ]);
            if ($validate->fails()) {
                return response()->json(['msg' => "User Gagal Diperbarui", 'errors' => $validate->errors()]);
            } else {
                User::where('username', $request->username)->update([
                    'name' => $request->name,
                    'password' => bcrypt($request->password),
                    'group1' => $request->group1,
                    'group2' => $request->group2,
                    'level' => $request->level,
                ]);
                return response()->json(['msg' => "$request->username Berhasil Diperbarui"]);
            }
        } else {
            $validate = Validator::make($request->all(), [
                'name' => 'required',
            ], [
                'name.required' => 'Nama Wajib Diisi',
            ]);
            if ($validate->fails()) {
                return response()->json(['msg' => "User Gagal Diperbarui", 'errors' => $validate->errors()]);
            } else {
                User::where('username', $request->username)->update([
                    'name' => $request->name,
                    'group1' => $request->group1,
                    'group2' => $request->group2,
                    'level' => $request->level,
                ]);
                return response()->json(['msg' => "$request->username Berhasil Diperbarui"]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, $id)
    {
        // return response()->json($id);
        try {
            User::where('username', $id)->delete();
            return response()->json(['msg' => "$id Berhasil Dihapus"]);
        } catch (Exception $e) {
            return response()->json(['errors' => 'Terjadi Kesalahan, Tidak Dapat Menghapus Data']);
        }
    }
    public function import_users(Request $request)
    {
        Excel::import(new UsersImport, request()->file('file'));
        return response()->json(['msg' => "Data User Berhasil Di Upload"]);
    }
}
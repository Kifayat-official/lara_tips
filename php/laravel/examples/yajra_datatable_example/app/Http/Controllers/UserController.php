<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = DB::table('users')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('user');
    }

    public function create()
    {
        // Logic for displaying the create user form
    }

    public function store(Request $request)
    {
        // Logic for storing a new user
    }

    public function show($id)
    {
        // Logic for displaying a specific user
    }

    public function edit($id)
    {
        // Logic for displaying the edit user form
    }

    public function update(Request $request, $id)
    {
        // Logic for updating a user
    }

    public function destroy($id)
    {
        // Logic for deleting a user
    }
}

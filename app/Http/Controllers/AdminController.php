<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherRequest;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash as FacadesHash;
use Yajra\DataTables\DataTables;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (request()->ajax()) {
            $users = User::whereRole('1')->select('id', 'name', 'email'); // Adjust fields as per your User model
            return DataTables::of($users)->make(true);
        }
        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(request()->ajax()) {
            $users = User::whereRole('2')->select('id', 'name', 'email'); // Adjust fields as per your User model
            return DataTables::of($users)->make(true);
        }
        return view('admin.teachers.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TeacherRequest $request)
    {
        $data = $request->validated();

        $data['password'] = FacadesHash::make($data['password']);
        $data['role'] = 2; // Assuming 1 is the role for teachers

        User::create($data);

        return response()->json(['success' => true, 'message' => 'Teacher added successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

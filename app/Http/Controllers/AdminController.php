<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeacherRequest;
use App\Models\Quiz;
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
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::where('role', 1) // Only normal users
                ->select('id', 'name', 'email');

            return DataTables::of($users)
                ->addIndexColumn()

                // 👇 Add average column
                ->addColumn('average_score', function ($user) {
                    $scores = $user->scores()->pluck('percentage');

                    if ($scores->count() > 0) {
                        return round($scores->avg(), 2) . '%';
                    }

                    return 'N/A';
                })

                ->make(true);
        }

        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (request()->ajax()) {
            $users = User::whereRole('2')->select('id', 'name', 'email'); // Adjust fields as per your User model
            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '
                    <button class="btn btn-sm btn-danger delete-teacher" data-id="' . $row->id . '">
                        🗑 Delete
                    </button>';
                })
                ->rawColumns(['action']) // to render HTML
                ->make(true);
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
        $data['role'] = 2;
        $data['semester'] = 1;

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
        $user = User::findOrFail($id);

        if ($user->role == 2) {
            $user->delete();
            return response()->json(['success' => true, 'message' => 'Teacher deleted successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
    }

    public function dashboard()
    {
        $users = User::where('role', 1)->count();      // Regular users
        $teachers = User::where('role', 2)->count();   // Teachers
        $quizzes = Quiz::count();

        return view('admin.dashboard', compact('users', 'teachers', 'quizzes'));
    }
}

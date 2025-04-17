<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(RegisterRequest $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegisterRequest $request)
    {
        // dd($request->all());
        $data = $request->validated();
        // Hash the password before saving
        $data['password'] = bcrypt($data['password']);

        unset($data['password_confirmation']);

        User::create($data);

        return response()->json(['success' => true, 'redirectUrl' => route('quiz.index')]);
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

    public function login(LoginRequest $request){

        $data = $request->validated();

        $user = User::where('email', $data['email'])->first();

        if ($user && password_verify($data['password'], $user->password)) {
            if($user->role == 1){
                return response()->json(['success' => true, 'redirectUrl' => route('quiz.index')]);
            } else if($user->role == 2){
                return response()->json(['success' => true, 'redirectUrl' => route('teacher.index')]);
            } else if($user->role == 3){
                return response()->json(['success' => true, 'redirectUrl' => route('admin.index')]);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Invalid credentials'], 401);
        }
    }
}

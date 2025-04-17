@extends('layouts.app')

@section('title', 'Quiz Interface')

@section('content')
<div class="container mt-5">
    <ul class="nav nav-tabs" id="authTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="role-tab" data-bs-toggle="tab" data-bs-target="#role" type="button" role="tab" aria-controls="role" aria-selected="false">Select Role</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab" aria-controls="login" aria-selected="false">Login</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab" aria-controls="register" aria-selected="false">Register</button>
        </li>
    </ul>
    <div class="tab-content" id="authTabContent">
        <div class="tab-pane fade" id="role" role="tabpanel" aria-labelledby="role-tab">
            <div class="text-center">
                <h1 class="mb-4">Choose Your Role</h1>
                <div class="d-flex justify-content-center">
                    <div class="card m-3" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">User</h5>
                            <button class="btn btn-primary select-role" data-role="1">Select</button>
                        </div>
                    </div>
                    <div class="card m-3" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">Admin</h5>
                            <button class="btn btn-primary select-role" data-role="2">Select</button>
                        </div>
                    </div>
                    <div class="card m-3" style="width: 18rem;">
                        <div class="card-body">
                            <h5 class="card-title">Teacher</h5>
                            <button class="btn btn-primary select-role" data-role="3">Select</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="login" role="tabpanel" aria-labelledby="login-tab">
            <form method="POST" action="" id="loginForm">
                <input type="hidden" name="role" id="loginRole" value="1">
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                </div>
                <a href="#" class="forgot-password">Forgot password?</a>
                <button type="submit" class="btn btn-primary mt-3">Login</button>
                <a href="#" class="signup-link">Not registered? Signup now</a>
            </form>
        </div>
        <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
            <form method="POST" action="" id="registerForm">
                <input type="hidden" name="role" id="registerRole" value="1">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password">
                </div>
                <button type="submit" class="btn btn-primary">Register</button>
            </form>
        </div>
    </div>
</div>
@endsection

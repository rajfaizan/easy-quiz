@extends('layouts.app')

@section('title', 'Login')
<style>
    .container {
        max-width: 300px;
        margin-top: 50px;
        padding: 20px;
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .nav-tabs .nav-link {
        background: #f8f9fa;
        border: none;
        color: #000;
        font-weight: bold;
    }

    .nav-tabs .nav-link.active {
        background: #1da1f2;
        color: #fff;
    }

    .form-label {
        font-weight: bold;
    }

    .btn-primary {
        background-color: #1da1f2;
        border: none;
        width: 100%;
        padding: 10px;
        font-weight: bold;
    }

    .btn-primary:hover {
        background-color: #1a91da;
    }

    .forgot-password {
        text-align: right;
        margin-bottom: 10px;
        color: #1da1f2;
        text-decoration: none;
    }

    .signup-link {
        text-align: center;
        margin-top: 10px;
        color: #1da1f2;
        text-decoration: none;
    }
</style>
@section('content')
    <div class="container mt-5">
        <ul class="nav nav-tabs" id="authTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="role-tab" data-bs-toggle="tab" data-bs-target="#role" type="button"
                    role="tab" aria-controls="role" aria-selected="true">Select Role</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button"
                    role="tab" aria-controls="login" aria-selected="false">Login</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button"
                    role="tab" aria-controls="register" aria-selected="false">Register</button>
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
                    @csrf
                    <input type="hidden" name="role" id="loginRole" value="">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter email">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Login</button>
                </form>
            </div>
            <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
                <form method="POST" action="" id="registerForm">
                    @csrf
                    <input type="hidden" name="role" id="registerRole">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Enter name">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email"
                            placeholder="Enter email">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Password">
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation"
                            name="password_confirmation" placeholder="Confirm Password">
                    </div>
                    <button type="submit" class="btn btn-primary">Register</button>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        $('.select-role').on('click', function() {
            const role = $(this).data('role');
            $('#loginRole').val(role);
            $('#registerRole').val(role);

            // Enable and show Login tab
            document.querySelector('#login-tab').classList.remove('disabled');
            new bootstrap.Tab(document.querySelector('#login-tab')).show();

            // Enable Register tab only for User role (role = 1)
            if (role === 1) { // Assuming 1 is User
                document.querySelector('#register-tab').classList.remove('disabled');
            } else { // Disable Register tab for Admin (2) and Teacher (3)
                document.querySelector('#register-tab').classList.add('disabled');
            }

            // Enable Login tab regardless of role
            document.querySelector('#login-tab').classList.remove('disabled');
        });

        // Disable Login and Register tabs by default
        document.addEventListener('DOMContentLoaded', function() {
            const loginTab = document.querySelector('#login-tab');
            const registerTab = document.querySelector('#register-tab');
            loginTab.classList.add('disabled');
            registerTab.classList.add('disabled');

            // Override Bootstrap tab click to enforce role selection
            document.querySelectorAll('.nav-link').forEach(tab => {
                tab.addEventListener('click', function(e) {
                    if (this.getAttribute('id') !== 'role-tab' && $('#loginRole').val() === '') {
                        e.preventDefault();
                        toastr.error('Please select a role first.', 'Error');
                    } else if (this.classList.contains('disabled')) {
                        e.preventDefault();
                        toastr.error('Please select a role first.', 'Error');
                    }
                });
            });
        });
        // Login form submission
        $('#loginForm').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            $.ajax({
                url: '{{ route('login') }}',
                type: 'post',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        window.location.href = response.redirectUrl;
                    } else {
                        toastr.error(response.message, 'Error');
                    }
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.message;
                        if (errors) {
                            toastr.error(errors);
                            return;
                        }
                    }
                    toastr.error('Error during login. Please try again.', 'Error');
                },
            });
        });

        // Register form submission
        $('#registerForm').submit(function(e) {
            e.preventDefault();
            var formData = $(this).serialize();
            // Clear previous validation messages
            $('.error-message').remove();

            $.ajax({
                url: '{{ route('auth.store') }}',
                type: 'post',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        window.location.href = response.redirectUrl;
                    } else {
                        toastr.error(response.message, 'Error');
                    }
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.message;
                        if (errors) {
                            // Check if errors is an object (Laravel validation format)
                            if (typeof errors === 'object' && errors !== null && !Array.isArray(
                                    errors)) {
                                $.each(errors, function(key, value) {
                                    // Find the input field with the error using the name attribute
                                    var input = $('[name="' + key + '"]');
                                    if (input.length) {
                                        // Add error message below the input
                                        input.after(
                                            '<div class="error-message text-danger mt-1 mb-2">' +
                                            value[0] + '</div>');
                                    }
                                });
                            } else if (typeof errors === 'string' || Array.isArray(errors)) {
                                // Handle string or array response (e.g., a general error message)
                                var errorMessage = Array.isArray(errors) ? errors.join('<br>') : errors;
                                $('#registerForm').prepend(
                                    '<div class="error-message text-danger mt-1 mb-2">' + errorMessage +
                                    '</div>');
                            }
                            return;
                        }
                    }
                    toastr.error('Error during registration. Please try again.', 'Error');
                },
            });
        });
    </script>
@stop

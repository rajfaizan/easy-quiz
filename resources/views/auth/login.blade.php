<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>SmartQuiz | Login/Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS + SweetAlert + Animate -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <style>
        body {
            background: linear-gradient(to right, #e0eafc, #cfdef3);
            min-height: 100vh;
            font-family: 'Arial', sans-serif;
        }

        .welcome-header {
            background: linear-gradient(90deg, #4e73df, #224abe);
            color: white;
            padding: 1.5rem;
            border-radius: 15px 15px 0 0;
            text-align: center;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .welcome-header h1 {
            font-size: 2rem;
            font-weight: 700;
            margin: 0;
        }

        .auth-box {
            max-width: 750px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
            padding: 2rem;
        }

        .nav-tabs .nav-link {
            font-weight: bold;
            color: #555;
        }

        .nav-tabs .nav-link.active {
            background-color: #0d6efd;
            color: #fff;
        }

        .role-card {
            width: 180px;
            height: 200px;
            border: none;
            border-radius: 15px;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            background: linear-gradient(135deg, #ffffff, #f8f9fa);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .role-card:hover {
            transform: scale(1.05) translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .role-card .card-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: #4e73df;
        }

        .role-card .card-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .btn-primary {
            background-color: #0d6efd;
            border: none;
            padding: 0.5rem 1.5rem;
        }

        .btn-primary:hover {
            background-color: #0b5ed7;
        }

        @media (max-width: 768px) {
            .role-card {
                width: 140px;
                height: 180px;
                margin: 0.5rem;
            }

            .role-card .card-icon {
                font-size: 2.5rem;
            }

            .role-card .card-title {
                font-size: 1rem;
            }

            .welcome-header h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="auth-box w-100">
            <!-- Welcome Header -->
            <div class="welcome-header">
                <h1>Welcome to SmartQuiz</h1>
            </div>

            <ul class="nav nav-tabs justify-content-center mb-4" id="authTab" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" id="role-tab" data-bs-toggle="tab" data-bs-target="#role"
                        type="button" role="tab">🎭 Select Role</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button"
                        role="tab">🔐 Login</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register"
                        type="button" role="tab">📝 Register</button>
                </li>
            </ul>

            <div class="tab-content" id="authTabContent">
                <!-- Role Selection -->
                <div class="tab-pane fade show active" id="role" role="tabpanel">
                    <div class="text-center">
                        <h4 class="mb-4">Choose Your Role</h4>
                        <div class="d-flex justify-content-center flex-wrap">
                            @php
                                $roles = [
                                    1 => ['label' => 'User', 'icon' => '👥', 'color' => '#4e73df'],
                                    2 => ['label' => 'Admin', 'icon' => '🛡️', 'color' => '#28a745'],
                                    3 => ['label' => 'Teacher', 'icon' => '👨‍🏫', 'color' => '#17a2b8'],
                                ];
                            @endphp
                            @foreach ($roles as $role => $data)
                                <div class="role-card m-3"
                                    style="background: linear-gradient(135deg, #ffffff, {{ $data['color'] }}33);">
                                    <div class="card-body">
                                        <span class="card-icon"
                                            style="color: {{ $data['color'] }};">{{ $data['icon'] }}</span>
                                        <h5 class="card-title">{{ $data['label'] }}</h5>
                                        <button class="btn btn-primary btn mt-3 select-role"
                                            data-role="{{ $role }}">
                                            Select
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Login -->
                <div class="tab-pane fade" id="login" role="tabpanel">
                    <form id="loginForm">
                        @csrf
                        <input type="hidden" name="role" id="loginRole">
                        <div class="mb-3">
                            <label class="form-label">📧 Email</label>
                            <input type="email" class="form-control" name="email">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">🔒 Password</label>
                            <input type="password" class="form-control" name="password">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                </div>

                <!-- Register -->
                <div class="tab-pane fade" id="register" role="tabpanel">
                    <form id="registerForm">
                        @csrf
                        <input type="hidden" name="role" id="registerRole">
                        <div class="mb-3">
                            <label class="form-label">👤 Name</label>
                            <input type="text" class="form-control" name="name">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">📧 Email</label>
                            <input type="email" class="form-control" name="email">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">🔒 Password</label>
                            <input type="password" class="form-control" name="password">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">🔒 Confirm Password</label>
                            <input type="password" class="form-control" name="password_confirmation">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">🎓 Semester</label>
                            <select class="form-select" name="semester">
                                <option selected disabled>Choose...</option>
                                @for ($i = 1; $i <= 8; $i++)
                                    <option value="{{ $i }}">Semester {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        // Role selection logic
        $('.select-role').on('click', function() {
            const role = $(this).data('role');
            $('#loginRole').val(role);
            $('#registerRole').val(role);

            new bootstrap.Tab(document.querySelector('#login-tab')).show();

            // Enable Login tab always
            document.querySelector('#login-tab').classList.remove('disabled');

            // Register tab only for User (1)
            if (role == 1) {
                document.querySelector('#register-tab').classList.remove('disabled');
            } else {
                document.querySelector('#register-tab').classList.add('disabled');
            }
        });

        // Disable tabs unless role is selected
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelector('#login-tab').classList.add('disabled');
            document.querySelector('#register-tab').classList.add('disabled');

            document.querySelectorAll('.nav-link').forEach(tab => {
                tab.addEventListener('click', function(e) {
                    if (this.id !== 'role-tab' && !$('#loginRole').val()) {
                        e.preventDefault();
                        toastr.error('Please select a role first.');
                    }
                });
            });
        });

        // AJAX login
        // AJAX login
        $('#loginForm').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route('login') }}',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(res) {
                    if (res.success) {
                        window.location.href = res.redirectUrl;
                    } else {
                        // Handle validation errors, show only the first error
                        if (res.errors && Object.keys(res.errors).length > 0) {
                            const firstErrorField = Object.keys(res.errors)[0];
                            const firstErrorMessage = res.errors[firstErrorField][0];
                            toastr.error(firstErrorMessage);
                        } else {
                            toastr.error(res.message || 'An unexpected error occurred.');
                        }
                    }
                },
                error: function(err) {
                    // Handle 422 validation errors, show only the first error
                    if (err.status === 422) {
                        const response = err.responseJSON;
                        if (response.errors && Object.keys(response.errors).length > 0) {
                            const firstErrorField = Object.keys(response.errors)[0];
                            const firstErrorMessage = response.errors[firstErrorField][0];
                            toastr.error(firstErrorMessage);
                        }
                    }
                    toastr.error('Login failed. Please try again.');
                }
            });
        });

        // AJAX register
        $('#registerForm').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route('auth.store') }}',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(res) {
                    if (res.success) {
                        window.location.href = res.redirectUrl;
                    } else {
                        // Handle validation errors, show only the first error
                        if (res.errors && Object.keys(res.errors).length > 0) {
                            const firstErrorField = Object.keys(res.errors)[0];
                            const firstErrorMessage = res.errors[firstErrorField][0];
                            toastr.error(firstErrorMessage);
                        } else {
                            toastr.error(res.message || 'An unexpected error occurred.');
                        }
                    }
                },
                error: function(err) {
                    // Handle 422 validation errors, show only the first error
                    if (err.status === 422) {
                        const response = err.responseJSON;
                        if (response.errors && Object.keys(response.errors).length > 0) {
                            const firstErrorField = Object.keys(response.errors)[0];
                            const firstErrorMessage = response.errors[firstErrorField][0];
                            toastr.error(firstErrorMessage);
                        }
                    }
                    toastr.error('Registration failed. Please try again.');
                }
            });
        });
    </script>
</body>

</html>

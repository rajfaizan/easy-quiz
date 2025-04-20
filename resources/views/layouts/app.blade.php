<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <title>@yield('title', 'Easy Quiz')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SweetAlert2 (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        .navbar-custom {
            background-color: #4a90e2;
            font-family: 'Poppins', sans-serif;
        }

        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link,
        .navbar-custom .dropdown-toggle {
            color: #fff;
            font-weight: 600;
        }

        .navbar-custom .nav-link:hover,
        .navbar-custom .dropdown-menu a:hover {
            color: #dcdcdc;
        }

        .navbar-custom .dropdown-menu {
            background-color: #4a90e2;
            border: none;
        }

        .navbar-custom .dropdown-item {
            color: #fff;
        }

        .navbar-custom .dropdown-item:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .navbar-toggler {
            border: none;
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='%23fff' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255,255,255,1%29' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        body {
            background: linear-gradient(to right, #e0eafc, #cfdef3);
        }
    </style>
</head>

<body>
    <!-- 🌐 Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">SmartExam</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
                aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    @auth
                        @if (auth()->user()->role == 1)
                            <li class="nav-item"><a class="nav-link" href="{{ route('quiz.index') }}">📝 Quizzes</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('quiz.create') }}">📊 My Scores</a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('ranking.index') }}">🏆 Rankings</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#semesterModal">🎓
                                    Semester</a>
                            </li>
                        @elseif(auth()->user()->role == 2)
                            <li class="nav-item"><a class="nav-link" href="{{ route('teacher.create') }}">📚 My Quizzes</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('teacher.index') }}">📝 Add Quizzes</a>
                            </li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('results') }}">📈 Student Results</a>
                            </li>
                        @endif

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-bs-toggle="dropdown">
                                👤 {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="{{ route('auth.create') }}">🚪 Logout</a></li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="">🔐 Login</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
    <div class="modal fade" id="semesterModal" tabindex="-1" aria-labelledby="semesterModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="semesterForm">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="semesterModalLabel">🎓 Update Semester</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <label for="semesterSelect" class="form-label">Choose Semester</label>
                        <select class="form-select" id="semesterSelect" name="semester" required>
                            @for ($i = 1; $i <= 4; $i++)
                                <option value="{{ $i }}"
                                    {{ auth()->user()->semester == $i ? 'selected' : '' }}>
                                    Semester {{ $i }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Content -->
    <div class="container mt-4">
        @yield('content')
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @yield('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var dropdowns = document.querySelectorAll('.dropdown-toggle');
            dropdowns.forEach(function(dropdown) {
                new bootstrap.Dropdown(dropdown);
            });
        });
        $('#semesterForm').on('submit', function(e) {
            e.preventDefault();

            const semester = $('#semesterSelect').val();

            fetch('{{ route('quiz.store') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        semester
                    })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = '{{ route('quiz.index') }}';
                    } else {
                        alert('Something went wrong!');
                    }
                });
        });
    </script>
</body>

</html>

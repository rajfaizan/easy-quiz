@extends('admin.main')

@section('title', 'Admin Dashboard')

@section('content')
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }

        .dashboard-header {
            background: linear-gradient(90deg, #4e73df 0%, #224abe 100%);
            color: white;
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .dashboard-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            height: 100%;
            overflow: hidden;
            position: relative;
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .dashboard-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .card-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .card-badge {
            font-size: 1.5rem;
            font-weight: 600;
            background: #4e73df;
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 20px;
            margin-bottom: 1rem;
            display: inline-block;
        }

        .card-title {
            font-weight: 600;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .card-text {
            color: #6c757d;
            font-size: 0.9rem;
            line-height: 1.4;
        }

        @media (max-width: 768px) {
            .dashboard-card {
                margin-bottom: 1.5rem;
            }

            .card-icon {
                font-size: 2rem;
            }

            .card-badge {
                font-size: 1.2rem;
                padding: 0.4rem 1.2rem;
            }
        }
    </style>

    <div class="container py-3">
        <!-- Header Section -->
        <div class="dashboard-header">
            <h2 class="mb-3 fw-bold">📊 Welcome to the Admin Dashboard</h2>
            <p class="welcome-text">Manage users, teachers with ease. Get started below!</p>
        </div>

        <!-- Stats Row -->
        <div class="row g-4">
            <!-- Users Card -->
            <div class="col-md-4 col-sm-6">
                <div class="dashboard-card" onclick="window.location.href='{{ route('admin.index') }}'" role="button">
                    <span class="card-icon">👥</span>
                    <span class="card-badge">{{ $users }}</span>
                    <h5 class="card-title">Users</h5>
                </div>
            </div>

            <!-- Teachers Card -->
            <div class="col-md-4 col-sm-6">
                <div class="dashboard-card" onclick="window.location.href='{{ route('admin.create') }}'" role="button">
                    <span class="card-icon">👨‍🏫</span>
                    <span class="card-badge" style="background: #28a745;">{{ $teachers }}</span>
                    <h5 class="card-title">Teachers</h5>
                </div>
            </div>
        </div>
    </div>
@endsection
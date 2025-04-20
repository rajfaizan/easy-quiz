@extends('layouts.app')

@section('title', 'Quiz Home')

@section('content')
<style>
    .card:hover {
        transform: translateY(-5px);
    }
</style>

<div class="container py-5">
    <h1 class="mb-4 text-center">📚 Available Quizzes</h1>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        @foreach($quizzes as $quiz)
        <div class="col">
            <div class="card h-100 shadow-sm">
                <div class="card-body d-flex flex-column justify-content-between">
                    <div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h5 class="card-title fw-semibold mb-0">{{ $quiz['name'] }}</h5>
                            <span class="text-primary small fw-medium">📘 Semester {{ $quiz['semester'] }}</span>
                        </div>
                        <p class="card-text text-muted">{{ $quiz['description'] }}</p>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <small class="text-secondary">🕒 {{ \Carbon\Carbon::parse($quiz['created_at'])->diffForHumans() }}</small>
                        <a href="{{ route('quiz.show', $quiz['id']) }}" class="btn btn-primary btn-sm">🚀 Start Quiz</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

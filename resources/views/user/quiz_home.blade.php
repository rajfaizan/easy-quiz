@extends('layouts.app')

@section('title', 'Quiz Home')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Quiz List by Semester</h1>
    <div class="mb-3">
        <label for="semester" class="form-label">Select Semester</label>
        <select class="form-select" id="semester">
            <option selected>Choose...</option>
            <option value="1">Semester 1</option>
            <option value="2">Semester 2</option>
            <option value="3">Semester 3</option>
        </select>
    </div>
    <div class="list-group">
        @foreach(['Quiz 1', 'Quiz 2', 'Quiz 3'] as $quiz)
        <a href="#" class="list-group-item list-group-item-action">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">{{ $quiz }}</h5>
                <small>3 days ago</small>
            </div>
            <p class="mb-1">Some placeholder content for the quiz description.</p>
            <button class="btn btn-primary">Start Quiz</button>
        </a>
        @endforeach
    </div>
</div>
@endsection

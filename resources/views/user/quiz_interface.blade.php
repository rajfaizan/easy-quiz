@extends('layouts.app')

@section('title', 'Quiz Interface')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Quiz Title</h1>
    <form method="POST" action="#">
        @csrf
        @foreach(['Question 1', 'Question 2', 'Question 3'] as $question)
        <div class="mb-4">
            <h5>{{ $question }}</h5>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="{{ $question }}" id="{{ $question }}1" value="option1">
                <label class="form-check-label" for="{{ $question }}1">
                    Option 1
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="{{ $question }}" id="{{ $question }}2" value="option2">
                <label class="form-check-label" for="{{ $question }}2">
                    Option 2
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="{{ $question }}" id="{{ $question }}3" value="option3">
                <label class="form-check-label" for="{{ $question }}3">
                    Option 3
                </label>
            </div>
        </div>
        @endforeach
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection 
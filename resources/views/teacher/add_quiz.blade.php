@extends('layouts.app')

@section('title', 'Add Quiz')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Add New Quiz</h1>
    <form method="POST" action="#">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Quiz Title</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Enter quiz title">
        </div>
        <div class="mb-3">
            <label for="semester" class="form-label">Semester</label>
            <select class="form-select" id="semester" name="semester">
                <option selected>Choose...</option>
                <option value="1">Semester 1</option>
                <option value="2">Semester 2</option>
                <option value="3">Semester 3</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter quiz description"></textarea>
        </div>
        <div id="questions">
            <div class="question-block mb-4">
                <h5>Question 1</h5>
                <input type="text" class="form-control mb-2" name="questions[]" placeholder="Enter question">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="correct_answer[0]" value="option1">
                    <input type="text" class="form-control" name="options[0][]" placeholder="Option 1">
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="correct_answer[0]" value="option2">
                    <input type="text" class="form-control" name="options[0][]" placeholder="Option 2">
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="correct_answer[0]" value="option3">
                    <input type="text" class="form-control" name="options[0][]" placeholder="Option 3">
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-secondary mb-3" id="add-question">Add Question</button>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
<script>
    document.getElementById('add-question').addEventListener('click', function() {
        const questionCount = document.querySelectorAll('.question-block').length;
        const newQuestion = document.createElement('div');
        newQuestion.classList.add('question-block', 'mb-4');
        newQuestion.innerHTML = `
            <h5>Question ${questionCount + 1}</h5>
            <input type="text" class="form-control mb-2" name="questions[]" placeholder="Enter question">
            <div class="form-check">
                <input class="form-check-input" type="radio" name="correct_answer[${questionCount}]" value="option1">
                <input type="text" class="form-control" name="options[${questionCount}][]" placeholder="Option 1">
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="correct_answer[${questionCount}]" value="option2">
                <input type="text" class="form-control" name="options[${questionCount}][]" placeholder="Option 2">
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="correct_answer[${questionCount}]" value="option3">
                <input type="text" class="form-control" name="options[${questionCount}][]" placeholder="Option 3">
            </div>
        `;
        document.getElementById('questions').appendChild(newQuestion);
    });
</script>
@endsection 
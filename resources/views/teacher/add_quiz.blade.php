@extends('layouts.app')

@section('title', 'Add Quiz')

@section('content')
    <style>
        body {
            background: linear-gradient(to right, #e0eafc, #cfdef3);
        }

        .quiz-card {
            background-color: #ffffff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .question-block {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
            position: relative;
        }

        .remove-question {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .form-check-input {
            margin-top: 0.6rem;
        }
    </style>

    <div class="container py-5">
        <div class="quiz-card">
            <h1 class="mb-4 text-center">📝 Add New Quiz</h1>

            <form id="quizForm" method="POST" action="{{ route('teacher.store') }}">
                @csrf
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="mb-3">
                    <label for="title" class="form-label">📘 Quiz Title</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter quiz title">
                </div>

                <div class="mb-3">
                    <label for="semester" class="form-label">🎓 Semester</label>
                    <select class="form-select" id="semester" name="semester">
                        <option selected disabled>Choose...</option>
                        <option value="1">Semester 1</option>
                        <option value="2">Semester 2</option>
                        <option value="3">Semester 3</option>
                        <option value="4">Semester 4</option>
                        <option value="5">Semester 5</option>
                        <option value="6">Semester 6</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">🗒️ Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" placeholder="Enter quiz description"></textarea>
                </div>

                <div id="questions">
                    <div class="question-block mb-4">
                        <button type="button" class="btn btn-sm btn-danger remove-question d-none">Remove</button>
                        <h5>Question 1</h5>
                        <input type="text" class="form-control mb-3" name="questions[]" placeholder="Enter question">

                        @for ($i = 1; $i <= 4; $i++)
                            <div class="form-check mb-2 d-flex align-items-center">
                                <input class="form-check-input me-2" type="radio" name="correct_answer[0]" value="option{{ $i }}">
                                <input type="text" class="form-control" name="options[0][]" placeholder="Option {{ $i }}">
                            </div>
                        @endfor
                    </div>
                </div>

                <button type="button" class="btn btn-secondary" id="add-question">Add Question</button>
                <button type="submit" class="btn btn-primary">✅ Submit</button>
            </form>
        </div>
    </div>

    <!-- Include Toastify and SweetAlert2 -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        let questionIndex = 1;

        // Add new question
        document.getElementById('add-question').addEventListener('click', function() {
            const questionsContainer = document.getElementById('questions');

            const newBlock = document.createElement('div');
            newBlock.className = 'question-block mb-4';
            newBlock.innerHTML = `
                <button type="button" class="btn btn-sm btn-danger remove-question">Remove</button>
                <h5>Question ${questionIndex + 1}</h5>
                <input type="text" class="form-control mb-3" name="questions[]" placeholder="Enter question">
                ${[1, 2, 3, 4].map(i => `
                    <div class="form-check mb-2 d-flex align-items-center">
                        <input class="form-check-input me-2" type="radio" name="correct_answer[${questionIndex}]" value="option${i}">
                        <input type="text" class="form-control" name="options[${questionIndex}][]" placeholder="Option ${i}">
                    </div>
                `).join('')}
            `;

            questionsContainer.appendChild(newBlock);
            questionIndex++;
        });

        // Remove question
        document.getElementById('questions').addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-question')) {
                e.target.parentElement.remove();
            }
        });

        // Form validation and submission
        document.getElementById('quizForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            // Sequential validation
            // Check quiz title
            const title = document.getElementById('title').value.trim();
            if (!title) {
                showToastError('Please enter a quiz title.');
                return;
            }

            // Check semester
            const semester = document.getElementById('semester').value;
            if (!semester || semester === 'Choose...') {
                showToastError('Please select a semester.');
                return;
            }

            // Check description
            const description = document.getElementById('description').value.trim();
            if (!description) {
                showToastError('Please enter a quiz description.');
                return;
            }

            // Check if at least one question exists
            const questionBlocks = document.querySelectorAll('.question-block');
            if (questionBlocks.length === 0) {
                showToastError('Please add at least one question.');
                return;
            }

            // Validate each question and its options
            for (let index = 0; index < questionBlocks.length; index++) {
                const block = questionBlocks[index];

                // Check question text
                const questionInput = block.querySelector('input[name="questions[]"]').value.trim();
                if (!questionInput) {
                    showToastError(`Please enter text for Question ${index + 1}.`);
                    return;
                }

                // Check options
                const options = block.querySelectorAll('input[name^="options["]');
                for (let optIndex = 0; optIndex < options.length; optIndex++) {
                    if (!options[optIndex].value.trim()) {
                        showToastError(`Please enter text for Option ${optIndex + 1} in Question ${index + 1}.`);
                        return;
                    }
                }

                // Check correct answer
                const correctAnswer = block.querySelector(`input[name="correct_answer[${index}]"]:checked`);
                if (!correctAnswer) {
                    showToastError(`Please select a correct answer for Question ${index + 1}.`);
                    return;
                }
            }

            // If validation passes, submit form via AJAX
            $.ajax({
                url: '{{ route("teacher.store") }}',
                type: 'POST',
                data: $('#quizForm').serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            title: 'Success!',
                            text: response.message || 'Quiz created successfully!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = '{{ route("teacher.create") }}'; // Redirect to quizzes list
                        });
                    } else {
                        showToastError(response.message || 'Failed to create quiz.');
                    }
                },
                error: function(xhr) {
                    const errorMessage = xhr.responseJSON?.message || 'Failed to create quiz.';
                    showToastError(errorMessage);
                }
            });
        });

        // Helper function to show Toastify error
        function showToastError(message) {
            Toastify({
                text: message,
                duration: 3000,
                close: true,
                gravity: 'top',
                position: 'right',
                backgroundColor: '#dc3545',
            }).showToast();
        }
    </script>

    <!-- CSRF Token Meta Tag -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
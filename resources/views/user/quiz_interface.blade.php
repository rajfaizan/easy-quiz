@extends('layouts.app')

@section('title', 'Take Quiz')

@section('content')
    <style>
        .quiz-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .question-box {
            border-left: 4px solid #007bff;
            padding: 15px;
            margin-bottom: 25px;
            background: #f9f9f9;
        }

        .question-number {
            font-weight: bold;
            margin-bottom: 10px;
        }

        .timer {
            font-size: 1.2rem;
            font-weight: bold;
            color: red;
            text-align: right;
        }
    </style>

    <div class="container py-5">
        <div class="quiz-container">
            <div class="d-flex justify-content-between mb-4">
                <h3>{{ $quiz->name }}</h3>
                <div class="timer">⏱️ Time Left: <span id="time">10:00</span></div>
            </div>

            <form id="quizForm" method="POST" action="{{ route('score', $quiz->id) }}">
                @csrf
                @foreach ($quiz->questions as $index => $question)
                    <div class="question-box">
                        <div class="question-number">Question {{ $index + 1 }}</div>
                        <p>{{ $question->name }}</p>
                        @foreach ($question->options as $optIndex => $option)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="answers[{{ $question->id }}]"
                                    value="{{ $option->id }}" id="q{{ $question->id }}_opt{{ $optIndex }}">
                                <label class="form-check-label" for="q{{ $question->id }}_opt{{ $optIndex }}">
                                    {{ $option->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                @endforeach
                <button type="submit" class="btn btn-success mt-3 w-100">✅ Submit Quiz</button>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/animate.css@4.1.1/animate.min.css" />

    <script>
        // Timer auto submission
        let totalSeconds = 600; // 10 minutes
        let timerInterval;

        // Function to handle the beforeunload event
        const handleBeforeUnload = (e) => {
            e.preventDefault();
            e.returnValue = ''; // Required for Chrome
        };

        function startTimer() {
            const timerDisplay = document.getElementById('time');

            timerInterval = setInterval(() => {
                let minutes = Math.floor(totalSeconds / 60);
                let seconds = totalSeconds % 60;
                seconds = seconds < 10 ? '0' + seconds : seconds;
                minutes = minutes < 10 ? '0' + minutes : minutes;

                timerDisplay.textContent = `${minutes}:${seconds}`;

                if (totalSeconds <= 0) {
                    clearInterval(timerInterval);
                    // Remove beforeunload listener before auto-submission
                    window.removeEventListener('beforeunload', handleBeforeUnload);
                    Swal.fire({
                        icon: 'warning',
                        title: '⏰ Time\'s Up!',
                        text: 'Submitting your quiz with the answers provided...',
                        showConfirmButton: false,
                        timer: 1500,
                        customClass: {
                            popup: 'animated fadeInDown'
                        }
                    }).then(() => {
                        submitQuiz(); // Submit with current answers
                    });
                }

                totalSeconds--;
            }, 1000);
        }

        function setupProtection() {
            // Disable tab switch
            document.addEventListener('visibilitychange', () => {
                if (document.visibilityState === 'hidden') {
                    clearInterval(timerInterval);
                    // Remove beforeunload listener before submission
                    window.removeEventListener('beforeunload', handleBeforeUnload);
                    Swal.fire({
                        icon: 'error',
                        title: '⚠️ Tab Switch Detected!',
                        text: 'Quiz will be submitted with current answers.',
                        showConfirmButton: false,
                        timer: 1500,
                        customClass: {
                            popup: 'animated fadeInDown'
                        }
                    }).then(() => {
                        submitQuiz(); // Submit with current answers
                    });
                }
            });

            // Disable right-click
            document.addEventListener('contextmenu', e => e.preventDefault());

            // Disable F5, Ctrl+R
            window.addEventListener("keydown", function(e) {
                if ((e.key === "F5") || (e.ctrlKey && e.key === 'r')) {
                    e.preventDefault();
                }
            });

            // Add leave warning
            window.addEventListener('beforeunload', handleBeforeUnload);
        }

        function validateAnswers() {
            const questions = document.querySelectorAll('.question-box');
            let unanswered = [];

            questions.forEach((question, index) => {
                const radios = question.querySelectorAll('input[type="radio"]:checked');
                if (radios.length === 0) {
                    unanswered.push(index + 1);
                }
            });

            return unanswered;
        }

        // Reusable function to submit quiz and display results
        function submitQuiz() {
            const form = document.getElementById('quizForm');
            const formData = new FormData(form);

            fetch('{{ route('score', $quiz->id) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                // Remove beforeunload listener after successful submission
                window.removeEventListener('beforeunload', handleBeforeUnload);

                // Custom message based on score %
                let message = '';
                if (data.percentage >= 90) {
                    message = '🚀 Genius! You nailed it!';
                } else if (data.percentage >= 75) {
                    message = '🎯 Great job! Almost perfect!';
                } else if (data.percentage >= 50) {
                    message = '👍 Good effort! Keep practicing.';
                } else {
                    message = '📚 Needs improvement. Try again!';
                }

                Swal.fire({
                    icon: 'info',
                    title: '📊 Quiz Result',
                    html: `
                        <div style="font-size: 1.1rem; line-height: 1.8;">
                            <p>✅ <strong>${data.correct}</strong> correct out of <strong>${data.total}</strong> questions</p>
                            <p>📈 Accuracy: <strong>${data.percentage}%</strong></p>
                            <hr>
                            <p style="font-size: 1.2rem; font-weight: bold; color: #3c3c3c;">${message}</p>
                        </div>
                    `,
                    confirmButtonText: 'Okay',
                    confirmButtonColor: '#28a745',
                    customClass: {
                        popup: 'animated fadeInDown'
                    }
                }).then(() => {
                    window.location.href = "{{ route('quiz.index') }}"; // Redirect to quiz list
                });
            })
            .catch(error => {
                // Remove beforeunload listener even on error
                window.removeEventListener('beforeunload', handleBeforeUnload);
                Swal.fire({
                    icon: 'error',
                    title: 'Submission Failed',
                    text: 'An error occurred while submitting the quiz. Please try again.',
                    confirmButtonText: 'Okay',
                    confirmButtonColor: '#dc3545',
                    customClass: {
                        popup: 'animated fadeInDown'
                    }
                });
            });
        }

        document.getElementById('quizForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Validate all questions are answered
            const unanswered = validateAnswers();
            if (unanswered.length > 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Incomplete Quiz',
                    text: `Please answer all questions. Unanswered: Question${unanswered.length > 1 ? 's' : ''} ${unanswered.join(', ')}.`,
                    confirmButtonText: 'Okay',
                    confirmButtonColor: '#007bff',
                    customClass: {
                        popup: 'animated fadeInDown'
                    }
                });
                return;
            }

            submitQuiz(); // Use the same submission logic
        });

        window.onload = function() {
            startTimer();
            setupProtection();
        };
    </script>
@endsection
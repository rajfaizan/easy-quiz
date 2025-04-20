@extends('layouts.app')

@section('title', 'Student Results')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">📊 Student Results for Your Quizzes</h2>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped" id="resultsTable" width="100%">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Quiz</th>
                        <th>Student</th>
                        <th>Email</th>
                        <th>Score</th>
                        <th>Taken At</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<!-- DataTables CSS + JS (via CDN or local) -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    $('#resultsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('results') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'quiz', name: 'quiz.title' },
            { data: 'student', name: 'user.name' },
            { data: 'email', name: 'user.email' },
            { data: 'score_display', name: 'score' },
            { data: 'created_at', name: 'created_at' },
        ]
    });
});
</script>
@endsection

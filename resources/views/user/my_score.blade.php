@extends('layouts.app')

@section('title', 'My Score')
<style>
    .history-container {
        background-color: #f4f9ff;
        border-radius: 10px;
        padding: 2rem;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }

    .history-title {
        text-align: center;
        font-size: 2rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 2rem;
    }

    table.dataTable thead {
        background-color: #0d6efd;
        color: white;
    }

    table.dataTable th,
    table.dataTable td {
        text-align: center;
        vertical-align: middle;
        padding: 12px 10px;
    }

    table.dataTable tbody tr {
        background-color: #ffffff;
        transition: all 0.3s ease-in-out;
    }

    table.dataTable tbody tr:hover {
        background-color: #f1f8ff;
    }

    .dataTables_wrapper .dataTables_filter input,
    .dataTables_wrapper .dataTables_length select {
        border-radius: 8px;
        padding: 6px 10px;
        border: 1px solid #ccc;
    }

    .dataTables_paginate .paginate_button {
        padding: 4px 10px !important;
        margin: 0 2px;
        border-radius: 5px !important;
    }

    .dataTables_paginate .paginate_button.current {
        background-color: #0d6efd !important;
        color: white !important;
    }
</style>
@section('content')
<div class="container py-5">
    <div class="history-container">
        <h2 class="history-title">📊 My Quiz History</h2>

        <table class="table table-bordered table-hover w-100" id="scoreTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Quiz Name</th>
                    <th>Semester</th>
                    <th>Score</th>
                    <th>Percentage</th>
                    <th>Attempted On</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Yajra DataTables -->
<script>
    $(document).ready(function() {
        $('#scoreTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('quiz.create') }}',
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'quiz_name', name: 'quiz.name' },
                { data: 'semester', name: 'quiz.semester' },
                { data: 'score_display', name: 'score' },
                { data: 'percentage', name: 'percentage' },
                { data: 'attempted_at', name: 'created_at' },
            ]
        });
    });
</script>
@endsection

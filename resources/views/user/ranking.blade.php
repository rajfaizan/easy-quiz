@extends('layouts.app')

@section('title', 'Rankings')
<style>
    .leaderboard-container {
        background-color: #e6f0ff;
        border-radius: 10px;
        padding: 2rem;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }

    .leaderboard-title {
        text-align: center;
        font-size: 2rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 2rem;
    }

    .leaderboard-title i {
        color: #ffc107;
        margin-right: 0.5rem;
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

    table.dataTable tbody tr.table-success td {
        background-color: #d1e7dd !important; /* Consistent green highlight */
        font-weight: 600;
    }

    .dataTables_wrapper .dataTables_filter input {
        border-radius: 8px;
        padding: 6px 10px;
        border: 1px solid #ccc;
    }

    .dataTables_wrapper .dataTables_length select {
        border-radius: 8px;
        padding: 5px 8px;
        border: 1px solid #ccc;
    }
</style>
@section('content')
<div class="leaderboard-container">
    <h2 class="leaderboard-title">🏆Semester {{ auth()->user()->semester }} Leaderboard</h2>
    <table id="rankingTable" class="table table-bordered table-hover w-100">
        <thead>
            <tr>
                <th>Rank</th>
                <th>User</th>
                <th>Score</th>
                <th>Accuracy</th>
            </tr>
        </thead>
    </table>
</div>
@endsection

@section('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(function() {
            $('#rankingTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('ranking.index') }}',
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: 'user_name',
                        name: 'user.name'
                    },
                    {
                        data: 'score_display',
                        name: 'score'
                    },
                    {
                        data: 'percentage',
                        name: 'percentage'
                    }
                ],
                rowCallback: function(row, data, index) {
                    if (data.is_current_user === 'You') {
                        $(row).addClass('table-success'); // Bootstrap green background
                    }
                }
            });
        });
    </script>
@endsection

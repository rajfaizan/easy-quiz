@extends('admin.main')
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
    <div class="container mt-5">
        <div class="history-container">
            <h2 class="history-title">👥 Users List</h2>

            <table class="table table-bordered table-hover w-100" id="usersTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Avg. Quiz %</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

    </div>
@stop
@section('scripts')
    <!-- Required Datatables Scripts -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#usersTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('admin.index') }}',
                    type: 'GET'
                },
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'average_score',
                        name: 'average_score',
                        orderable: false,
                        searchable: false
                    } // ✅ new column
                ]
            });
        });
    </script>
@stop

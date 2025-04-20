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
    <div class="container mt-5"> <!-- Fixed typo: constainer to container -->
        <div class="history-container mt-5">
            <h2 class="history-title">👨‍🏫 Teachers List</h2>

            <div class="d-flex justify-content-end mb-3">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTeacherModal">
                    ➕ Add New Teacher
                </button>
            </div>

            <table class="table table-bordered table-hover w-100" id="usersTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Actions</th> <!-- optional: for delete/edit -->
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

    </div>

    <!-- Add Teacher Modal -->
    <div class="modal fade" id="addTeacherModal" tabindex="-1" aria-labelledby="addTeacherModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTeacherModalLabel">Add New Teacher</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addTeacherForm">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
@section('scripts')
    <!-- Required Datatables Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#usersTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('admin.create') }}',
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
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // Handle Add Teacher Form Submission
            $('#addTeacherForm').submit(function(e) {
                e.preventDefault();
                var formData = $(this).serialize();

                $.ajax({
                    url: '{{ route('admin.store') }}', // Route to store the new teacher
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $('#addTeacherModal').modal('hide'); // Close modal on success
                            $('#usersTable').DataTable().ajax.reload(); // Reload datatable
                            window.location.reload();
                        }
                    },
                    error: function(xhr, status, error) {
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.message;
                            if (errors) {
                                $.each(errors, function(key, value) {
                                    var input = $('[name="' + key + '"]');
                                    if (input.length) {
                                        input.after(
                                            '<div class="error-message text-danger mt-1">' +
                                            value[0] + '</div>');
                                    }
                                });
                                return;
                            }
                        }
                        // toastr.error('Error during registration. Please try again.', 'Error');
                    }
                });
            });
        });
        $(document).on('click', '.delete-teacher', function() {
            const teacherId = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "This will permanently delete the teacher.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('admin.destroy', ':id') }}'.replace(':id',
                        teacherId), // Replace :id with teacherId
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(res) {
                            if (res.success) {
                                $('#usersTable').DataTable().ajax.reload();
                                Swal.fire('Deleted!', res.message, 'success');
                            } else {
                                Swal.fire('Error', res.message, 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('Error', 'Failed to delete teacher.', 'error');
                        }
                    });
                }
            });
        });
    </script>
@stop

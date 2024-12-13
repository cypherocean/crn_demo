@extends('layouts.app')

@section('meta')
@endsection

@section('title')
Users
@endsection

@section('styles')
@endsection

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">User</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('users') }}" class="text-muted">Users</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">List</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="col-5 align-self-center">
            <div class="customize-input float-right">
                <a class="btn waves-effect waves-light btn-rounded btn-outline-primary pull-right" href="{{ route('users.create') }}">Add New</a>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered data-table" id="data-table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    var datatable;

    $(function() {
        if ($('#data-table').length > 0) {
            datatable = $('#data-table').DataTable({
                processing: true,
                serverSide: true,

                // "pageLength": 10,
                // "iDisplayLength": 10,
                "responsive": true,
                "aaSorting": [],
                "ajax": {
                    "url": "{{ route('users') }}",
                    "type": "POST",
                    "dataType": "json",
                    "data": {
                        _token: "{{csrf_token()}}"
                    }
                },
                "columnDefs": [{
                    //"targets": [0, 5], //first column / numbering column
                    "orderable": true, //set not orderable
                }, ],
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
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
                    },
                ]
            });
        }
    });

    function change_status(object) {
        var id = $(object).data("id");

        if (confirm('Are you sure?')) {
            $.ajax({
                url: "{!! route('users.delete') !!}",
                "dataType": "json",
                "type": "POST",
                "data": {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response.code == 200) {
                        datatable.ajax.reload();
                        toastr.success('Status changed successfully', 'Success');
                    } else {
                        toastr.error('Failed to change status', 'Error');
                    }
                }
            });
        }
    }
</script>
@endsection

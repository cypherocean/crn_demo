@extends('layouts.app')

@section('meta')
@endsection

@section('title')
    User Update
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
                        <li class="breadcrumb-item"><a href="{{ route('users') }}" class="text-muted">User</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">Update</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('users.update') }}" name="form" id="form" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <input type="hidden" name="id" value="{{ $data->id }}">

                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Please enter name" value="{{ $data->name ??'' }}">
                                <span class="kt-form__help error name"></span>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Please enter email" value="{{ $data->email ??'' }}">
                                <span class="kt-form__help error email"></span>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Please enter password">
                                <span class="text-danger">* Leave blank for not update password</span>
                                <span class="kt-form__help error password"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn waves-effect waves-light btn-rounded btn-outline-primary">Submit</button>
                            <a href="{{ route('users') }}" class="btn waves-effect waves-light btn-rounded btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('assets/js/dropify.min.js') }}"></script>
<script src="{{ asset('assets/js/promise.min.js') }}"></script>
<script src="{{ asset('assets/js/sweetalert2.bundle.js') }}"></script>

<script>
    $(document).ready(function () {
        var form = $('#form');
        $('.kt-form__help').html('');
        form.submit(function(e) {
            $('.help-block').html('');
            $('.m-form__help').html('');
            $.ajax({
                url : form.attr('action'),
                type : form.attr('method'),
                data: new FormData($(this)[0]),
                dataType: 'json',
                async: false,
                processData: false,
                contentType: false,
                success : function(json){
                    return true;
                },
                error: function(json){
                    if(json.status === 422) {
                        e.preventDefault();
                        var errors_ = json.responseJSON;
                        $('.kt-form__help').html('');
                        $.each(errors_.errors, function (key, value) {
                            $('.'+key).html(value);
                        });
                    }
                }
            });
        });
    });
</script>
@endsection

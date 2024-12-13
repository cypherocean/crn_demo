@extends('layouts.app')

@section('meta')
@endsection

@section('title')
Teachers View
@endsection

@section('styles')
@endsection

@section('content')
<div class="page-breadcrumb">
    <div class="row">
        <div class="col-7 align-self-center">
            <h4 class="page-title text-truncate text-dark font-weight-medium mb-1">Teachers</h4>
            <div class="d-flex align-items-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb m-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}" class="text-muted">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('teacher') }}" class="text-muted">Teachers</a></li>
                        <li class="breadcrumb-item text-muted active" aria-current="page">View</li>
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
                    <form action="{{ route('teacher.update') }}" name="form" id="form" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Please enter name" value="{{ $data->name ??'' }}" readonly>
                                <span class="kt-form__help error name"></span>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="Please enter email" value="{{ $data->email ??'' }}" readonly>
                                <span class="kt-form__help error email"></span>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="education">Education</label>
                                <input type="text" name="education" class="form-control" placeholder="Please enter education" value="{{ $data->education ??'' }}" readonly>
                                <span class="kt-form__help error education"></span>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Please enter password" readonly>
                                <span class="text-danger">* Leave blank for not update password</span>
                                <span class="kt-form__help error password"></span>
                            </div>
                        </div>
                        <div class="form-group">
                            <a href="{{ route('teacher') }}" class="btn waves-effect waves-light btn-rounded btn-outline-secondary">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection

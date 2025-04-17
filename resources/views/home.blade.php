@extends('layouts.app')

@section('title', 'Choose Your Role')

@section('content')
<div class="text-center">
    <h1 class="mb-4">Choose Your Role</h1>
    <div class="d-flex justify-content-center">
        <div class="card m-3" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">User</h5>
                <a href="{{ route('auth.index') }}" class="btn btn-primary">Select</a>
            </div>
        </div>
        <div class="card m-3" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Admin</h5>
                <a href="{{ route('auth.index') }}" class="btn btn-primary">Select</a>
            </div>
        </div>
        <div class="card m-3" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">Teacher</h5>
                <a href="{{ route('auth.index') }}" class="btn btn-primary">Select</a>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')
@section('content')
    <h1 style="position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);">
        Product Feedback Tool
        <p class="text-center mt-3">
            <a href="{{route('feed.form')}}" type="button" class="btn btn-outline-warning">Get Started</a>
            @can('isAdmin')
                <a href="{{route('admin.dashboard')}}" type="button" class="btn btn-outline-dark">Admin Dashboard</a>
            @endcan
        </p>
    </h1>
@endsection

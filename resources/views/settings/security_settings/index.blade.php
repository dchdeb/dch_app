@extends('layouts.layout')

@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Home</a>
    <span>›</span>
    <a href="{{ route('settings.index') }}">Settings</a>
    <span>›</span>
    <span>Security Settings</span>
@endsection

@section('title', 'security_settings')
@section('content')
{{-- <h1>  Settings</h1> --}}


<div class="row">

    <div class="col-md-2 ">
        <a href="{{ route('settings.security_settings.users.index') }}" class="text-decoration-none ">
            <div class="card setting-card px-2 py-3 text-center settings-hover-design">
                <i class="bi bi-shield-lock fs-4 text-success"></i>
                <h6 class="mt-1">Create Users</h6>
            </div>
        </a>

        {{-- {{ route('settings.security') }} --}}
    </div>
    <div class="col-md-2">
        <a href="#" class="text-decoration-none">
            <div class="card setting-card px-2 py-3 text-center">
                <i class="bi bi-shield-lock fs-4 text-success"></i>
                <h6 class="mt-1">create Group</h6>
            </div>
        </a>

        {{-- {{ route('settings.security') }} --}}
    </div>

</div>

@endsection
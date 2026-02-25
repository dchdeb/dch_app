@extends('layouts.layout')

@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Home</a>
    <span>›</span>
    <a href="{{ route('settings.index') }}">Settings</a>
    <span>›</span>
    <a href="{{ route('settings.security_settings.index') }}">Security Settings</a>
    <span>›</span>
    <span>Create User</span>
@endsection

@section('title', 'security_settings')
@section('content')
    {{-- <h1>  Settings</h1> --}}


    <div class="row justify-content-center">

        <div class="col-12 col-md-8 col-lg-6 d-flex justify-content-center">

            <div class="card filter-card mb-4 p-4 w-100" style="max-width: 500px;">

                <div class="fw-semibold dashboard-home p-2 text-center">
                    Filter Option
                </div>
                <hr>

                <form method="GET" action="">

                    <!-- Employee Name -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Employee Name</label>
                        <input type="text" name="name" value="{{ request('name') }}" class="form-control"
                            placeholder="Enter employee name">
                    </div>

                    <!-- Status -->
                    <div class="text-center mb-4">
                        

                        <div class="status-group justify-content-center">

                            <label class="form-label fw-semibold d-block mb-3">Status</label>

                            <label class="status-option">
                                <input type="radio" name="status" value="all"
                                    {{ request('status', 'all') == 'all' ? 'checked' : '' }}>
                                <span>All</span>
                            </label>

                            <label class="status-option">
                                <input type="radio" name="status" value="active"
                                    {{ request('status') == 'active' ? 'checked' : '' }}>
                                <span>Active</span>
                            </label>

                            <label class="status-option">
                                <input type="radio" name="status" value="inactive"
                                    {{ request('status') == 'inactive' ? 'checked' : '' }}>
                                <span>Inactive</span>
                            </label>

                        </div>
                    </div>

                    <!-- Button -->
                    <div class="text-center">
                        <button type="submit" class="btn btn-success px-3">
                            <i class="bi bi-search me-1"></i> Filter
                        </button>
                    </div>

                </form>
            </div>

        </div>
    </div>

@endsection

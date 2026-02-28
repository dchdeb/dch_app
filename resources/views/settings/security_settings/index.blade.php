{{-- @extends('layouts.layout')

@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Home</a>
    <span>›</span>
    <a href="{{ route('settings.index') }}">Settings</a>
    <span>›</span>
    <span>Security Settings</span>
@endsection

@section('title', 'security_settings')
@section('content')



<div class="row">

    <div class="col-md-2 ">
        <a href="{{ route('settings.security_settings.users.index') }}" class="text-decoration-none ">
            <div class="card setting-card px-2 py-3 text-center settings-hover-design">
                <i class="bi bi-shield-lock fs-4 text-success"></i>
                <h6 class="mt-1">Create Users</h6>
            </div>
        </a>

    </div>
    <div class="col-md-2">
        <a href="#" class="text-decoration-none">
            <div class="card setting-card px-2 py-3 text-center">
                <i class="bi bi-shield-lock fs-4 text-success"></i>
                <h6 class="mt-1">create Group</h6>
            </div>
        </a>

    </div>

</div>

@endsection --}}






@extends('layouts.layout')

@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Home</a>
    <span>›</span>
    <a href="{{ route('settings.index') }}">Settings</a>
    <span>›</span>
    <span>Security Settings</span>
@endsection

@section('title', 'Security Settings')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h4><i class="bi bi-shield-lock me-2"></i>Security Settings</h4>
            <p class="text-muted">Manage users, roles, and permissions for the hospital ERP system.</p>
        </div>
    </div>

    <div class="row">
        {{-- User Management Card --}}
        <div class="col-md-3 mb-3">
            <a href="{{ route('settings.security_settings.users.index') }}" class="text-decoration-none">
                <div class="card setting-card h-100 hover-card">
                    <div class="card-body text-center py-4">
                        <div class="icon-circle bg-primary text-white mb-3 mx-auto">
                            <i class="bi bi-people fs-4"></i>
                        </div>
                        <h5 class="card-title">User Management</h5>
                        <p class="card-text text-muted small">Create, edit, and manage system users</p>
                        <div class="mt-2">
                            <span class="badge bg-primary">Manage Users</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        {{-- Role Management Card --}}
        <div class="col-md-3 mb-3">
            <a href="{{ route('settings.security_settings.roles.index') }}" class="text-decoration-none">
                <div class="card setting-card h-100 hover-card">
                    <div class="card-body text-center py-4">
                        <div class="icon-circle bg-success text-white mb-3 mx-auto">
                            <i class="bi bi-shield-check fs-4"></i>
                        </div>
                        <h5 class="card-title">Role Management</h5>
                        <p class="card-text text-muted small">Define roles and assign permissions</p>
                        <div class="mt-2">
                            <span class="badge bg-success">Manage Roles</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        {{-- Permission Management Card --}}
        <div class="col-md-3 mb-3">
            <a href="{{ route('settings.security_settings.permissions.index') }}" class="text-decoration-none">
                <div class="card setting-card h-100 hover-card">
                    <div class="card-body text-center py-4">
                        <div class="icon-circle bg-warning text-white mb-3 mx-auto">
                            <i class="bi bi-key fs-4"></i>
                        </div>
                        <h5 class="card-title">Permissions</h5>
                        <p class="card-text text-muted small">View and manage all system permissions</p>
                        <div class="mt-2">
                            <span class="badge bg-warning text-dark">View Permissions</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        {{-- Create User (Old Link) Card --}}
        <div class="col-md-3 mb-3">
            <a href="{{ route('settings.security_settings.create_user.index') }}" class="text-decoration-none">
                <div class="card setting-card h-100 hover-card">
                    <div class="card-body text-center py-4">
                        <div class="icon-circle bg-info text-white mb-3 mx-auto">
                            <i class="bi bi-person-plus fs-4"></i>
                        </div>
                        <h5 class="card-title">Quick Create User</h5>
                        <p class="card-text text-muted small">Quick create a new user (Legacy)</p>
                        <div class="mt-2">
                            <span class="badge bg-info">Create User</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    {{-- Quick Stats Section --}}
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-bar-chart me-2"></i>Quick Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4">
                            <div class="border-end">
                                <h3 class="text-primary">{{ \App\Models\User::count() }}</h3>
                                <p class="text-muted mb-0">Total Users</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border-end">
                                <h3 class="text-success">{{ \Spatie\Permission\Models\Role::count() }}</h3>
                                <p class="text-muted mb-0">Total Roles</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div>
                                <h3 class="text-warning">{{ \Spatie\Permission\Models\Permission::count() }}</h3>
                                <p class="text-muted mb-0">Total Permissions</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Role Overview Section --}}
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-list-check me-2"></i>Role Overview</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>Role</th>
                                    <th>Users</th>
                                    <th>Permissions</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $roles = \Spatie\Permission\Models\Role::withCount('permissions')->get();
                                @endphp
                                @foreach($roles as $role)
                                    <tr>
                                        <td>
                                            <span class="badge bg-primary">
                                                {{ ucfirst(str_replace('-', ' ', $role->name)) }}
                                            </span>
                                        </td>
                                        <td>
                                            {{ \App\Models\User::whereHas('roles', function($q) use ($role) {
                                                $q->where('name', $role->name);
                                            })->count() }}
                                        </td>
                                        <td>{{ $role->permissions_count }}</td>
                                        <td>
                                            <a href="{{ route('settings.security_settings.roles.edit', $role->id) }}" 
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-pencil"></i> Edit
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.icon-circle {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.hover-card {
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    border-color: #0d6efd;
}

.hover-card:hover .card-title {
    color: #0d6efd;
}
</style>
@endsection
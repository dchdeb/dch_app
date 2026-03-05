@extends('layouts.layout')

@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Home</a>
    <span>›</span>
    <a href="{{ route('settings.index') }}">Settings</a>
    <span>›</span>
    <a href="{{ route('settings.security_settings.index') }}">Security</a>
    <span>›</span>
    <a href="{{ route('settings.security_settings.users.index') }}">Users</a>
    <span>›</span>
    <span>Create</span>
@endsection

@section('title', 'Create User')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <h4><i class="bi bi-person-plus me-2"></i>Create New User</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('settings.security_settings.users.store') }}" method="POST">
                        @csrf
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" 
                                       value="{{ old('name') }}" required placeholder="Enter full name">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" 
                                       value="{{ old('email') }}" required placeholder="Enter email address">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" name="password" class="form-control" required minlength="8" placeholder="Min 8 characters">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                <input type="password" name="password_confirmation" class="form-control" required placeholder="Confirm password">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Assign Roles <span class="text-danger">*</span>
                                @if(!$isSuperAdmin)
                                    <span class="badge bg-warning text-dark ms-2">
                                        <i class="bi bi-lock me-1"></i>Super Admin role locked
                                    </span>
                                @endif
                            </label>
                            
                            <div class="row">
                                @foreach($roles as $role)
                                    @php
                                        $isProtected = in_array($role->name, $protectedRoles);
                                        $isDisabled = $isProtected && !$isSuperAdmin;
                                    @endphp
                                    <div class="col-md-4 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" 
                                                   name="roles[]" value="{{ $role->name }}" 
                                                   id="role_{{ $role->id }}"
                                                   {{ in_array($role->name, old('roles', [])) ? 'checked' : '' }}
                                                   {{ $isDisabled ? 'disabled' : '' }}>
                                            <label class="form-check-label {{ $isProtected ? 'fw-bold text-warning' : '' }}" for="role_{{ $role->id }}">
                                                @if($isProtected)
                                                    <i class="bi bi-lock-fill me-1"></i>
                                                @endif
                                                {{ ucfirst(str_replace('-', ' ', $role->name)) }}
                                            </label>
                                            @if($role->name === 'super-admin')
                                                <span class="badge bg-danger ms-1">System</span>
                                            @elseif($role->name === 'hospital-admin')
                                                <span class="badge bg-info text-dark ms-1">Protected</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            @if(!$isSuperAdmin)
                                <small class="text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Only Super Admin can assign Super Admin role to new users.
                                </small>
                            @endif
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('settings.security_settings.users.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Create User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            {{-- Password Guidelines --}}
            <div class="card bg-light">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-shield-lock me-1"></i>Password Guidelines</h6>
                </div>
                <div class="card-body">
                    <ul class="text-muted small mb-0">
                        <li>Minimum 8 characters</li>
                        <li>Use mix of letters and numbers</li>
                        <li>Include special characters</li>
                        <li>Avoid common passwords</li>
                    </ul>
                </div>
            </div>

            {{-- Role Information --}}
            <div class="card bg-light mt-3">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-people me-1"></i>Role Guidelines</h6>
                </div>
                <div class="card-body">
                    <ul class="text-muted small mb-0">
                        <li>Users can have multiple roles</li>
                        <li>Permissions are inherited from roles</li>
                        <li>Super Admin has all permissions</li>
                        <li>Choose roles based on job responsibilities</li>
                    </ul>
                </div>
            </div>

            {{-- Protected Roles Info --}}
            <div class="card border-warning mt-3">
                <div class="card-header bg-warning text-dark">
                    <h6 class="mb-0"><i class="bi bi-lock me-1"></i>Protected Roles</h6>
                </div>
                <div class="card-body">
                    <p class="small mb-2">
                        <strong class="text-danger"><i class="bi bi-shield-fill me-1"></i>Super Admin</strong>
                    </p>
                    <ul class="small text-muted mb-3">
                        <li>Full system access</li>
                        <li>Can manage all users & roles</li>
                        <li>Only Super Admin can assign this role</li>
                    </ul>
                    
                    <p class="small mb-2">
                        <strong class="text-info"><i class="bi bi-building me-1"></i>Hospital Admin</strong>
                    </p>
                    <ul class="small text-muted mb-0">
                        <li>Manage hospital operations</li>
                        <li>Cannot manage Super Admin</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
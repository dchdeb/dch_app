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
    <span>Edit</span>
@endsection

@section('title', 'Edit User')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <h4><i class="bi bi-pencil-square me-2"></i>Edit User: {{ $user->name }}</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
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

                    <form action="{{ route('settings.security_settings.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" 
                                       value="{{ old('name', $user->name) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control" 
                                       value="{{ old('email', $user->email) }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Assign Roles <span class="text-danger">*</span></label>
                            <div class="row">
                                @foreach($roles as $role)
                                    <div class="col-md-4 mb-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" 
                                                   name="roles[]" value="{{ $role->name }}" 
                                                   id="role_{{ $role->id }}"
                                                   {{ in_array($role->name, old('roles', $userRoles)) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="role_{{ $role->id }}">
                                                {{ ucfirst(str_replace('-', ' ', $role->name)) }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('settings.security_settings.users.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Update User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-light">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-key me-1"></i>Current Permissions</h6>
                </div>
                <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                    @php
                        $allPermissions = [];
                        foreach($user->roles as $role) {
                            foreach($role->permissions as $perm) {
                                $allPermissions[$perm->name] = $perm;
                            }
                        }
                        ksort($allPermissions);
                    @endphp
                    
                    @if(count($allPermissions) > 0)
                        <div class="d-flex flex-wrap gap-1">
                            @foreach($allPermissions as $perm)
                                <span class="badge bg-secondary mb-1">{{ $perm->name }}</span>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted small mb-0">No permissions assigned</p>
                    @endif
                </div>
            </div>

            <div class="card bg-light mt-3">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-clock-history me-1"></i>User Info</h6>
                </div>
                <div class="card-body">
                    <p class="small mb-1">
                        <strong>Created:</strong> {{ $user->created_at->format('d M Y, h:i A') }}
                    </p>
                    <p class="small mb-0">
                        <strong>Updated:</strong> {{ $user->updated_at->format('d M Y, h:i A') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
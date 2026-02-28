@extends('layouts.layout')

@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Home</a>
    <span>›</span>
    <a href="{{ route('settings.index') }}">Settings</a>
    <span>›</span>
    <a href="{{ route('settings.security_settings.index') }}">Security</a>
    <span>›</span>
    <a href="{{ route('settings.security.permissions.index') }}">Permissions</a>
    <span>›</span>
    <span>Edit</span>
@endsection

@section('title', 'Edit Permission')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <h4><i class="bi bi-key me-2"></i>Edit Permission</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('settings.security.permissions.update', $permission->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label">Permission Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" 
                                   value="{{ old('name', $permission->name) }}" required>
                            <small class="text-muted">Format: module.action</small>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('settings.security.permissions.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Update Permission
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-light">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-info-circle me-1"></i>Permission Info</h6>
                </div>
                <div class="card-body">
                    <p class="small mb-2">
                        <strong>Created:</strong><br>
                        {{ $permission->created_at->format('d M Y, h:i A') }}
                    </p>
                    <p class="small mb-0">
                        <strong>Last Updated:</strong><br>
                        {{ $permission->updated_at->format('d M Y, h:i A') }}
                    </p>
                </div>
            </div>

            <div class="card bg-light mt-3">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-exclamation-triangle me-1"></i>Warning</h6>
                </div>
                <div class="card-body">
                    <p class="small text-muted mb-0">
                        Changing permission name may affect existing roles that use this permission. 
                        Make sure to update role permissions after renaming.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

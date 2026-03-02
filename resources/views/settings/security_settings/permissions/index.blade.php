@extends('layouts.layout')

@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Home</a>
    <span>›</span>
    <a href="{{ route('settings.index') }}">Settings</a>
    <span>›</span>
    <a href="{{ route('settings.security_settings.index') }}">Security Settings</a>
    <span>›</span>
    <span>Permissions</span>
@endsection

@section('title', 'Permission Management')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="bi bi-key me-2"></i>Permission Management</h4>
                <a href="{{ route('settings.security_settings.permissions.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> Add New Permission
                </a>
            </div>
        </div>
    </div>

    @if($groupedPermissions->count() == 0)
        <div class="alert alert-warning">
            <h5><i class="bi bi-exclamation-triangle me-2"></i>No Permissions Found</h5>
            <p>Please run the seeder to create default permissions:</p>
            <code>php artisan db:seed --class=RolePermissionSeeder</code>
        </div>
    @endif

    {{-- Permissions by Module --}}
    <div class="row">
        @foreach($groupedPermissions as $module => $perms)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0">
                            <i class="bi bi-folder me-1"></i>
                            {{ ucfirst(str_replace('-', ' ', $module)) }}
                        </h6>
                    </div>
                    <div class="card-body p-2">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Permission</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($perms as $perm)
                                        <tr>
                                            <td>
                                                <small>{{ $perm->name }}</small>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('settings.security_settings.permissions.edit', $perm->id) }}" 
                                                       class="btn btn-outline-primary btn-sm" title="Edit">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <form action="{{ route('settings.security_settings.permissions.destroy', $perm->id) }}" 
                                                          method="POST" 
                                                          class="d-inline"
                                                          onsubmit="return confirm('Delete this permission?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger btn-sm" title="Delete">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer text-center py-2">
                        <small class="text-muted">{{ $perms->count() }} permissions</small>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
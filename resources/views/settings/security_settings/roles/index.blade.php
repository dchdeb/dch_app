@extends('layouts.layout')

@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Home</a>
    <span>›</span>
    <a href="{{ route('settings.index') }}">Settings</a>
    <span>›</span>
    <a href="{{ route('settings.security_settings.index') }}">Security</a>
    <span>›</span>
    <span>Roles</span>
@endsection

@section('title', 'Role Management')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="bi bi-shield-lock me-2"></i>Role Management</h4>
                <a href="{{ route('settings.security_settings.roles.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> Add New Role
                </a>
            </div>
        </div>
    </div>

    {{-- Info Alert for Protected Roles --}}
    <div class="row mb-3">
        <div class="col-12">
            <div class="alert alert-info d-flex align-items-center" role="alert">
                <i class="bi bi-info-circle-fill me-2 fs-5"></i>
                <div>
                    <strong>🔒 Protected Roles:</strong> <code>super-admin</code> এবং <code>hospital-admin</code> হলো System Roles।
                    এই Roles গুলো শুধুমাত্র <strong>Super Admin</strong> edit করতে পারবে। Delete করা যাবে না।
                </div>
            </div>
        </div>
    </div>

    {{-- Roles Table --}}
    <div class="row">
        <div class="col-12">
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

                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Role Name</th>
                                    <th>Guard</th>
                                    <th class="text-center">Permissions</th>
                                    <th>Created</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $protectedRoles = ['super-admin', 'hospital-admin'];
                                    $isSuperAdmin = auth()->user()->hasRole('super-admin');
                                @endphp
                                
                                @forelse($roles as $index => $role)
                                    @php
                                        $isProtected = in_array($role->name, $protectedRoles);
                                    @endphp
                                    <tr>
                                        <td>{{ $roles->firstItem() + $index }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                @if($isProtected)
                                                    <i class="bi bi-lock-fill text-warning" title="Protected Role"></i>
                                                @endif
                                                <span class="badge {{ $isProtected ? 'bg-warning text-dark' : 'bg-primary' }} fs-6">
                                                    {{ ucfirst(str_replace('-', ' ', $role->name)) }}
                                                </span>
                                                @if($role->name === 'super-admin')
                                                    <span class="badge bg-danger"><i class="bi bi-shield-fill me-1"></i>Super Admin</span>
                                                @elseif($role->name === 'hospital-admin')
                                                    <span class="badge bg-info text-dark"><i class="bi bi-building me-1"></i>Hospital Admin</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>{{ $role->guard_name }}</td>
                                        <td class="text-center">
                                            <span class="badge bg-info">{{ $role->permissions_count }} permissions</span>
                                        </td>
                                        <td>{{ $role->created_at->format('d M Y') }}</td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                {{-- View Button - Always visible --}}
                                                <button type="button" class="btn btn-sm btn-outline-info" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#rolePermissionsModal{{ $role->id }}" 
                                                        title="View Permissions">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                
                                                {{-- Edit Button - Only Super Admin can edit protected roles --}}
                                                @if($isProtected && !$isSuperAdmin)
                                                    <button type="button" class="btn btn-sm btn-outline-secondary disabled" 
                                                            title="Only Super Admin can edit this role" disabled>
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                @else
                                                    <a href="{{ route('settings.security_settings.roles.edit', $role->id) }}" 
                                                       class="btn btn-sm btn-outline-primary" title="Edit">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                @endif
                                                
                                                {{-- Clone Button - Cannot clone protected roles --}}
                                                @if($isProtected)
                                                    <button type="button" class="btn btn-sm btn-outline-secondary disabled" 
                                                            title="Cannot clone protected roles" disabled>
                                                        <i class="bi bi-copy"></i>
                                                    </button>
                                                @else
                                                    <a href="{{ route('settings.security_settings.roles.clone', $role->id) }}" 
                                                       class="btn btn-sm btn-outline-success" title="Clone">
                                                        <i class="bi bi-copy"></i>
                                                    </a>
                                                @endif
                                                
                                                {{-- Delete Button - Protected roles cannot be deleted --}}
                                                @if($isProtected)
                                                    <button type="button" class="btn btn-sm btn-outline-secondary disabled" 
                                                            title="Protected role - cannot delete" disabled>
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                @else
                                                    <form action="{{ route('settings.security_settings.roles.destroy', $role->id) }}" 
                                                          method="POST" 
                                                          class="d-inline"
                                                          onsubmit="return confirm('Are you sure you want to delete this role?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- Role Permissions Modal --}}
                                    <div class="modal fade" id="rolePermissionsModal{{ $role->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">
                                                        @if($isProtected)
                                                            <i class="bi bi-lock-fill text-warning me-2"></i>
                                                        @endif
                                                        Permissions for: {{ ucfirst(str_replace('-', ' ', $role->name)) }}
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body" style="max-height: 500px; overflow-y: auto;">
                                                    @php
                                                        $rolePerms = $role->permissions->pluck('name')->toArray();
                                                    @endphp
                                                    
                                                    @foreach($groupedPermissions as $module => $perms)
                                                        <div class="card mb-3">
                                                            <div class="card-header bg-light">
                                                                <strong>{{ ucfirst(str_replace('-', ' ', $module)) }}</strong>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="d-flex flex-wrap gap-2">
                                                                    @foreach($perms as $perm)
                                                                        @if(in_array($perm->name, $rolePerms))
                                                                            <span class="badge bg-success" title="{{ $perm->description ?? '' }}">
                                                                                <i class="bi bi-check-circle me-1"></i>
                                                                                {{ $perm->display_name ?? $perm->name }}
                                                                            </span>
                                                                        @else
                                                                            <span class="badge bg-secondary opacity-50" title="{{ $perm->description ?? '' }}">
                                                                                <i class="bi bi-x-circle me-1"></i>
                                                                                {{ $perm->display_name ?? $perm->name }}
                                                                            </span>
                                                                        @endif
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="modal-footer">
                                                    @if($isProtected && !$isSuperAdmin)
                                                        <span class="text-muted small">
                                                            <i class="bi bi-lock me-1"></i>Only Super Admin can edit this role
                                                        </span>
                                                    @elseif($isProtected && $isSuperAdmin)
                                                        <a href="{{ route('settings.security_settings.roles.edit', $role->id) }}" class="btn btn-warning">
                                                            <i class="bi bi-pencil me-1"></i>Edit as Super Admin
                                                        </a>
                                                    @else
                                                        <a href="{{ route('settings.security_settings.roles.edit', $role->id) }}" class="btn btn-primary">
                                                            <i class="bi bi-pencil me-1"></i>Edit Permissions
                                                        </a>
                                                    @endif
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <i class="bi bi-shield fs-1 text-muted d-block mb-2"></i>
                                            No roles found. Please run the seeder first:
                                            <br>
                                            <code>php artisan db:seed --class=RolePermissionSeeder</code>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="d-flex justify-content-center mt-3">
                       {{$roles->links('pagination::bootstrap-5')}} 
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Permission Summary Card --}}
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-list-check me-1"></i>All Permissions by Module</h6>
                </div>
                <div class="card-body">
                    @if($groupedPermissions->count() > 0)
                        <div class="row">
                            @foreach($groupedPermissions as $module => $perms)
                                <div class="col-md-3 mb-3">
                                    <div class="card h-100">
                                        <div class="card-header py-2 bg-light">
                                            <strong class="small">{{ ucfirst(str_replace('-', ' ', $module)) }}</strong>
                                        </div>
                                        <div class="card-body py-2">
                                            @foreach($perms as $perm)
                                                <span class="badge bg-secondary mb-1" title="{{ $perm->description ?? '' }}">
                                                    {{ $perm->display_name ?? $perm->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            No permissions found. Please run the seeder to create permissions:
                            <code>php artisan db:seed --class=RolePermissionSeeder</code>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
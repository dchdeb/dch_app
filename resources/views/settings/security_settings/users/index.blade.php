@extends('layouts.layout')

@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Home</a>
    <span>›</span>
    <a href="{{ route('settings.index') }}">Settings</a>
    <span>›</span>
    <a href="{{ route('settings.security_settings.index') }}">Security</a>
    <span>›</span>
    <span>Users</span>
@endsection

@section('title', 'User Management')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="bi bi-people me-2"></i>User Management</h4>
                <a href="{{ route('settings.security_settings.users.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> Add New User
                </a>
            </div>
        </div>
    </div>

    {{-- Search and Filter --}}
    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('settings.security_settings.users.index') }}" class="row g-3">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Search by name or email..." 
                                   value="{{ request('search') }}">
                        </div>
                        <div class="col-md-3">
                            <select name="role" class="form-select">
                                <option value="">All Roles</option>
                                @isset($roles)
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                                            {{ ucfirst(str_replace('-', ' ', $role->name)) }}
                                        </option>
                                    @endforeach
                                @endisset
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="bi bi-search me-1"></i> Search
                            </button>
                            <a href="{{ route('settings.security_settings.users.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-counterclockwise"></i> Reset
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Users Table --}}
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
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Roles</th>
                                    <th>Created</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @isset($users)
                                    @forelse($users as $index => $userItem)
                                        @php
                                            $isSuperAdminUser = $userItem->hasRole('super-admin');
                                            $isLoggedInUser = ($userItem->id === auth()->id());
                                        @endphp
                                        <tr>
                                            <td>{{ $users->firstItem() + $index }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-circle bg-primary text-white me-2">
                                                        {{ strtoupper(substr($userItem->name, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        {{ $userItem->name }}
                                                        @if($isSuperAdminUser)
                                                            <span class="badge bg-danger ms-1"><i class="bi bi-shield-fill"></i></span>
                                                        @endif
                                                        @if($isLoggedInUser)
                                                            <span class="badge bg-success ms-1">You</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $userItem->email }}</td>
                                            <td>
                                                @foreach($userItem->roles as $role)
                                                    @php
                                                        $isProtected = in_array($role->name, ['super-admin', 'hospital-admin']);
                                                    @endphp
                                                    <span class="badge {{ $isProtected ? 'bg-warning text-dark' : 'bg-info' }} me-1">
                                                        @if($isProtected)
                                                            <i class="bi bi-lock-fill me-1"></i>
                                                        @endif
                                                        {{ ucfirst(str_replace('-', ' ', $role->name)) }}
                                                    </span>
                                                @endforeach
                                            </td>
                                            <td>{{ $userItem->created_at->format('d M Y') }}</td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('settings.security_settings.users.edit', $userItem->id) }}" 
                                                       class="btn btn-sm btn-outline-primary" title="Edit">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-outline-warning" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#resetPasswordModal{{ $userItem->id }}" 
                                                            title="Reset Password">
                                                        <i class="bi bi-key"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-info" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#userDetailsModal{{ $userItem->id }}" 
                                                            title="View Details">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    @if(!$isLoggedInUser)
                                                        <button type="button" class="btn btn-sm btn-outline-danger" 
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#deleteUserModal{{ $userItem->id }}" 
                                                                title="Delete">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>

                                        {{-- Reset Password Modal --}}
                                        <div class="modal fade" id="resetPasswordModal{{ $userItem->id }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('settings.security_settings.users.reset-password', $userItem->id) }}" method="POST">
                                                        @csrf
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">
                                                                <i class="bi bi-key me-2"></i>Reset Password - {{ $userItem->name }}
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            @if($isSuperAdminUser && !auth()->user()->hasRole('super-admin'))
                                                                <div class="alert alert-warning">
                                                                    <i class="bi bi-lock me-2"></i>
                                                                    Only Super Admin can reset Super Admin password.
                                                                </div>
                                                            @else
                                                                <div class="mb-3">
                                                                    <label class="form-label">New Password <span class="text-danger">*</span></label>
                                                                    <input type="password" name="password" class="form-control" required minlength="8">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                                                    <input type="password" name="password_confirmation" class="form-control" required>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            @if($isSuperAdminUser && !auth()->user()->hasRole('super-admin'))
                                                                <button type="submit" class="btn btn-secondary" disabled>No Permission</button>
                                                            @else
                                                                <button type="submit" class="btn btn-warning">Reset Password</button>
                                                            @endif
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- User Details Modal --}}
                                        <div class="modal fade" id="userDetailsModal{{ $userItem->id }}" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">
                                                            <i class="bi bi-person me-2"></i>User Details - {{ $userItem->name }}
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <strong>Name:</strong> {{ $userItem->name }}
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>Email:</strong> {{ $userItem->email }}
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <strong>Created:</strong> {{ $userItem->created_at->format('d M Y, h:i A') }}
                                                            </div>
                                                            <div class="col-md-6">
                                                                <strong>User ID:</strong> {{ $userItem->id }}
                                                            </div>
                                                        </div>
                                                        <div class="row mb-3">
                                                            <div class="col-12">
                                                                <strong>Roles:</strong>
                                                                <div class="mt-2">
                                                                    @foreach($userItem->roles as $role)
                                                                        @php
                                                                            $isProtected = in_array($role->name, ['super-admin', 'hospital-admin']);
                                                                        @endphp
                                                                        <span class="badge {{ $isProtected ? 'bg-warning text-dark' : 'bg-info' }} me-1">
                                                                            {{ ucfirst(str_replace('-', ' ', $role->name)) }}
                                                                        </span>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <strong>Permissions:</strong>
                                                                <div class="mt-2 d-flex flex-wrap gap-1" style="max-height: 200px; overflow-y: auto;">
                                                                    @php
                                                                        $allPermissions = [];
                                                                        foreach($userItem->roles as $role) {
                                                                            foreach($role->permissions as $perm) {
                                                                                $allPermissions[$perm->name] = $perm;
                                                                            }
                                                                        }
                                                                        ksort($allPermissions);
                                                                    @endphp
                                                                    @if(count($allPermissions) > 0)
                                                                        @foreach($allPermissions as $perm)
                                                                            <span class="badge bg-secondary">{{ $perm->name }}</span>
                                                                        @endforeach
                                                                    @else
                                                                        <span class="text-muted">No permissions assigned</span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <a href="{{ route('settings.security_settings.users.edit', $userItem->id) }}" class="btn btn-primary">
                                                            <i class="bi bi-pencil me-1"></i>Edit User
                                                        </a>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- Delete User Modal --}}
                                        @if(!$isLoggedInUser)
                                            <div class="modal fade" id="deleteUserModal{{ $userItem->id }}" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-danger text-white">
                                                            <h5 class="modal-title">
                                                                <i class="bi bi-exclamation-triangle me-2"></i>Delete User
                                                            </h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            @if($isSuperAdminUser && !auth()->user()->hasRole('super-admin'))
                                                                <div class="alert alert-warning mb-0">
                                                                    <i class="bi bi-lock me-2"></i>
                                                                    Only Super Admin can delete Super Admin accounts.
                                                                </div>
                                                            @elseif($isSuperAdminUser)
                                                                <div class="alert alert-danger">
                                                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                                                    <strong>Warning!</strong> You are about to delete a Super Admin account.
                                                                    Make sure there is at least one other Super Admin.
                                                                </div>
                                                                <p>Are you sure you want to delete <strong>{{ $userItem->name }}</strong>?</p>
                                                            @else
                                                                <p>Are you sure you want to delete <strong>{{ $userItem->name }}</strong>?</p>
                                                                <p class="text-muted small mb-0">This action cannot be undone.</p>
                                                            @endif
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            @if($isSuperAdminUser && !auth()->user()->hasRole('super-admin'))
                                                                <button type="button" class="btn btn-danger" disabled>No Permission</button>
                                                            @else
                                                                <form action="{{ route('settings.security_settings.users.destroy', $userItem->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="btn btn-danger">
                                                                        <i class="bi bi-trash me-1"></i>Delete User
                                                                    </button>
                                                                </form>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4">
                                                <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                                                No users found
                                            </td>
                                        </tr>
                                    @endforelse
                                @else
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <i class="bi bi-exclamation-triangle fs-1 text-warning d-block mb-2"></i>
                                            Users data not available
                                        </td>
                                    </tr>
                                @endisset
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    @isset($users)
                        <div class="d-flex justify-content-center mt-3">
                            {{ $users->links() }}
                        </div>
                    @endisset
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-circle {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 14px;
}
</style>
@endsection

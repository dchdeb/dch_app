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
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                                        {{ ucfirst(str_replace('-', ' ', $role->name)) }}
                                    </option>
                                @endforeach
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
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
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
                                @forelse($users as $index => $user)
                                    <tr>
                                        <td>{{ $users->firstItem() + $index }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-circle bg-primary text-white me-2">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                                {{ $user->name }}
                                            </div>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @foreach($user->roles as $role)
                                                <span class="badge bg-info me-1">{{ ucfirst(str_replace('-', ' ', $role->name)) }}</span>
                                            @endforeach
                                        </td>
                                        <td>{{ $user->created_at->format('d M Y') }}</td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('settings.security_settings.users.edit', $user->id) }}" 
                                                   class="btn btn-sm btn-outline-primary" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-warning" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#resetPasswordModal{{ $user->id }}" 
                                                        title="Reset Password">
                                                    <i class="bi bi-key"></i>
                                                </button>
                                                <button type="button" class="btn btn-sm btn-outline-info" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#userDetailsModal{{ $user->id }}" 
                                                        title="View Details">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                                <form action="{{ route('settings.security_settings.users.destroy', $user->id) }}" 
                                                      method="POST" 
                                                      class="d-inline"
                                                      onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    {{-- Reset Password Modal --}}
                                    <div class="modal fade" id="resetPasswordModal{{ $user->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('settings.security_settings.users.reset-password', $user->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Reset Password - {{ $user->name }}</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">New Password</label>
                                                            <input type="password" name="password" class="form-control" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Confirm Password</label>
                                                            <input type="password" name="password_confirmation" class="form-control" required>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-warning">Reset Password</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- User Details Modal --}}
                                    <div class="modal fade" id="userDetailsModal{{ $user->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">User Details - {{ $user->name }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <strong>Name:</strong> {{ $user->name }}
                                                        </div>
                                                        <div class="col-md-6">
                                                            <strong>Email:</strong> {{ $user->email }}
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-12">
                                                            <strong>Roles:</strong>
                                                            <div class="mt-2">
                                                                @foreach($user->roles as $role)
                                                                    <span class="badge bg-info me-1">{{ ucfirst(str_replace('-', ' ', $role->name)) }}</span>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <strong>Permissions:</strong>
                                                            <div class="mt-2 d-flex flex-wrap gap-1">
                                                                @php
                                                                    $allPermissions = [];
                                                                    foreach($user->roles as $role) {
                                                                        foreach($role->permissions as $perm) {
                                                                            $allPermissions[$perm->name] = $perm;
                                                                        }
                                                                    }
                                                                @endphp
                                                                @foreach($allPermissions as $perm)
                                                                    <span class="badge bg-secondary">{{ $perm->name }}</span>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <i class="bi bi-inbox fs-1 text-muted d-block mb-2"></i>
                                            No users found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    {{ $users->links() }}
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
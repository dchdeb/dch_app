@extends('layouts.layout')

@section('breadcrumb')
    <a href="{{ route('dashboard') }}">Home</a>
    <span>›</span>
    <a href="{{ route('settings.index') }}">Settings</a>
    <span>›</span>
    <a href="{{ route('settings.security_settings.index') }}">Security</a>
    <span>›</span>
    <a href="{{ route('settings.security_settings.roles.index') }}">Roles</a>
    <span>›</span>
    <span>Edit</span>
@endsection

@section('title', 'Edit Role')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <h4><i class="bi bi-shield-lock me-2"></i>Edit Role: {{ ucfirst(str_replace('-', ' ', $role->name)) }}</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-9">
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

                    <form action="{{ route('settings.security_settings.roles.update', $role->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label class="form-label">Role Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" 
                                   value="{{ old('name', $role->name) }}" required>
                            @if(in_array($role->name, ['super-admin', 'hospital-admin']))
                                <small class="text-danger">
                                    <i class="bi bi-exclamation-triangle me-1"></i>
                                    Warning: This is a system role. Changing name may affect system functionality.
                                </small>
                            @endif
                        </div>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label mb-0">Permissions</label>
                                <div>
                                    <button type="button" class="btn btn-sm btn-outline-primary" onclick="selectAll()">
                                        Select All
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="deselectAll()">
                                        Deselect All
                                    </button>
                                </div>
                            </div>

                            @if($groupedPermissions->count() > 0)
                                <div class="accordion" id="permissionsAccordion">
                                    @php
                                        $loopIndex = 0;
                                    @endphp
                                    @foreach($groupedPermissions as $module => $perms)
                                        <div class="accordion-item">
                                            <h2 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" 
                                                        data-bs-toggle="collapse" 
                                                        data-bs-target="#collapse{{ $loopIndex }}">
                                                    <strong>{{ ucfirst(str_replace('-', ' ', $module)) }}</strong>
                                                    <span class="badge bg-secondary ms-2">{{ $perms->count() }} permissions</span>
                                                    @php
                                                        $selectedCount = $perms->whereIn('name', $rolePermissions)->count();
                                                    @endphp
                                                    @if($selectedCount > 0)
                                                        <span class="badge bg-success ms-1">{{ $selectedCount }} selected</span>
                                                    @endif
                                                </button>
                                            </h2>
                                            <div id="collapse{{ $loopIndex }}" class="accordion-collapse collapse" 
                                                 data-bs-parent="#permissionsAccordion">
                                                <div class="accordion-body">
                                                    <div class="row">
                                                        @foreach($perms as $perm)
                                                            <div class="col-md-4 mb-2">
                                                                <div class="form-check">
                                                                    <input class="form-check-input perm-check" 
                                                                           type="checkbox" 
                                                                           name="permissions[]" 
                                                                           value="{{ $perm->name }}" 
                                                                           id="perm_{{ $perm->id }}"
                                                                           data-module="{{ $module }}"
                                                                           {{ in_array($perm->name, old('permissions', $rolePermissions)) ? 'checked' : '' }}>
                                                                    <label class="form-check-label small" for="perm_{{ $perm->id }}">
                                                                        {{ $perm->name }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @php
                                            $loopIndex++;
                                        @endphp
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                    No permissions found. Please run the seeder first.
                                </div>
                            @endif
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('settings.security_settings.roles.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Update Role
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-light sticky-top" style="top: 20px;">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-info-circle me-1"></i>Role Info</h6>
                </div>
                <div class="card-body">
                    <p class="small mb-2">
                        <strong>Created:</strong><br>
                        {{ $role->created_at->format('d M Y, h:i A') }}
                    </p>
                    <p class="small mb-2">
                        <strong>Last Updated:</strong><br>
                        {{ $role->updated_at->format('d M Y, h:i A') }}
                    </p>
                    <p class="small mb-0">
                        <strong>Total Permissions:</strong><br>
                        {{ count($rolePermissions) }} permissions assigned
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function selectAll() {
    document.querySelectorAll('.perm-check').forEach(cb => cb.checked = true);
}

function deselectAll() {
    document.querySelectorAll('.perm-check').forEach(cb => cb.checked = false);
}
</script>
@endsection

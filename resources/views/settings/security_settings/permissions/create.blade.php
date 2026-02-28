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
    <span>Create</span>
@endsection

@section('title', 'Create Permission')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <h4><i class="bi bi-key me-2"></i>Create New Permission</h4>
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

                    <form action="{{ route('settings.security.permissions.store') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Module</label>
                            <select name="module" id="moduleSelect" class="form-select" onchange="updatePermissionName()">
                                <option value="">-- Select Module --</option>
                                @foreach($modules as $key => $name)
                                    <option value="{{ $key }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Action</label>
                            <select name="action" id="actionSelect" class="form-select" onchange="updatePermissionName()">
                                <option value="">-- Select Action --</option>
                                <option value="view">View</option>
                                <option value="create">Create</option>
                                <option value="edit">Edit</option>
                                <option value="delete">Delete</option>
                                <option value="print">Print</option>
                                <option value="export">Export</option>
                                <option value="approve">Approve</option>
                                <option value="manage">Manage</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Permission Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="permissionName" class="form-control" 
                                   value="{{ old('name') }}" required
                                   placeholder="e.g., patient-registration.view">
                            <small class="text-muted">Format: module.action (e.g., pharmacy.create)</small>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('settings.security.permissions.index') }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-1"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Create Permission
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-light">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-info-circle me-1"></i>Permission Naming</h6>
                </div>
                <div class="card-body">
                    <p class="small text-muted">Permission names follow the pattern:</p>
                    <code class="d-block mb-2">module.action</code>
                    
                    <p class="small text-muted mt-3"><strong>Examples:</strong></p>
                    <ul class="small text-muted">
                        <li><code>patient-registration.view</code></li>
                        <li><code>pharmacy.create</code></li>
                        <li><code>ot-management.edit</code></li>
                        <li><code>settings.users.manage</code></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updatePermissionName() {
    const module = document.getElementById('moduleSelect').value;
    const action = document.getElementById('actionSelect').value;
    const permName = document.getElementById('permissionName');
    
    if (module && action) {
        permName.value = module + '.' + action;
    }
}
</script>
@endsection
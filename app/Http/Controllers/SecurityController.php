<?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;

// class SecurityController extends Controller
// {
//        public function index()
//     {
//         return view('settings.security_settings.index');
//     }

//     public function createUser()
//     {
//         return view('settings.security.create_user');
//     }

//     public function createGroup()
//     {
//         return view('settings.security.create_group');
//     }

//     public function roles()
//     {
//         return view('settings.security.roles');
//     }

//     public function permissions()
//     {
//         return view('settings.security.permissions');
//     }
// }














namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\{DB, Hash};
use App\Models\User;
use Spatie\Permission\Models\{Permission, Role};

class SecurityController extends Controller
{
    /**
     * Display security settings index
     */
    public function index()
    {
        return view('settings.security_settings.index');
    }
    

    // ============================================
    // USER MANAGEMENT
    // ============================================

    /**
     * Display list of users
     */
    public function userList(Request $request)
    {
        $query = User::with('roles');

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->has('role') && $request->role != '') {
            $query->whereHas('roles', function($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);
        $roles = Role::all();

        return view('settings.security_settings.users.index', compact('users', 'roles'));
    }

    /**
     * Show create user form
     */
    public function createUser()
    {
        $roles = Role::all();
        return view('settings.security_settings.users.create', compact('roles'));
    }

    /**
     * Store new user
     */
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name',
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            // Assign roles
            $user->assignRole($request->roles);

            DB::commit();

            return redirect()->route('settings.security.users.index')
                ->with('success', 'User created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error creating user: ' . $e->getMessage());
        }
    }

    /**
     * Show edit user form
     */
    public function editUser($id)
    {
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::all();
        $userRoles = $user->roles->pluck('name')->toArray();

        return view('settings.security_settings.users.edit', compact('user', 'roles', 'userRoles'));
    }

    /**
     * Update user
     */
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,name',
        ]);

        DB::beginTransaction();
        try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            // Sync roles (remove old, add new)
            $user->syncRoles($request->roles);

            DB::commit();

            return redirect()->route('settings.security.users.index')
                ->with('success', 'User updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error updating user: ' . $e->getMessage());
        }
    }

    /**
     * Delete user
     */
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting self
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account!');
        }

        $user->delete();

        return redirect()->route('settings.security.users.index')
            ->with('success', 'User deleted successfully!');
    }

    /**
     * Reset user password
     */
    public function resetPassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password reset successfully!');
    }

    // ============================================
    // ROLE MANAGEMENT
    // ============================================

    /**
     * Display list of roles
     */
    public function roleList()
    {
        $roles = Role::withCount('permissions')->with('permissions')->paginate(15);
        $permissions = Permission::all();
        
        // Group permissions by module
        $groupedPermissions = $permissions->groupBy(function($permission) {
            $parts = explode('.', $permission->name);
            return $parts[0];
        });

        return view('settings.security_settings.roles.index', compact('roles', 'permissions', 'groupedPermissions'));
    }

    /**
     * Show create role form
     */
    public function createRole()
    {
        $permissions = Permission::orderBy('name')->get();
        
        // Group permissions by module
        $groupedPermissions = $permissions->groupBy(function($permission) {
            $parts = explode('.', $permission->name);
            return $parts[0];
        });

        return view('settings.security_settings.roles.create', compact('permissions', 'groupedPermissions'));
    }

    /**
     * Store new role
     */
    public function storeRole(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'description' => 'nullable|string|max:500',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        DB::beginTransaction();
        try {
            $role = Role::create([
                'name' => $request->name,
                'guard_name' => 'web',
                'description' => $request->description,
            ]);

            // Assign permissions
            if ($request->has('permissions')) {
                $role->givePermissionTo($request->permissions);
            }

            DB::commit();

            return redirect()->route('settings.security.roles.index')
                ->with('success', 'Role created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error creating role: ' . $e->getMessage());
        }
    }

    /**
     * Show edit role form
     */
    public function editRole($id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        $permissions = Permission::orderBy('name')->get();
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        
        // Group permissions by module
        $groupedPermissions = $permissions->groupBy(function($permission) {
            $parts = explode('.', $permission->name);
            return $parts[0];
        });

        return view('settings.security_settings.roles.edit', compact('role', 'permissions', 'rolePermissions', 'groupedPermissions'));
    }

    /**
     * Update role
     */
    public function updateRole(Request $request, $id)
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $id,
            'description' => 'nullable|string|max:500',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,name',
        ]);

        DB::beginTransaction();
        try {
            $role->update([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            // Sync permissions
            $permissions = $request->has('permissions') ? $request->permissions : [];
            $role->syncPermissions($permissions);

            DB::commit();

            return redirect()->route('settings.security.roles.index')
                ->with('success', 'Role updated successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error updating role: ' . $e->getMessage());
        }
    }

    /**
     * Delete role
     */
    public function deleteRole($id)
    {
        $role = Role::findOrFail($id);

        // Prevent deleting system roles
        $protectedRoles = ['super-admin', 'hospital-admin'];
        if (in_array($role->name, $protectedRoles)) {
            return back()->with('error', 'Cannot delete system role!');
        }

        // Check if role is assigned to users
        $usersCount = User::whereHas('roles', function($q) use ($role) {
            $q->where('name', $role->name);
        })->count();

        if ($usersCount > 0) {
            return back()->with('error', "Cannot delete role. It is assigned to {$usersCount} user(s)!");
        }

        $role->delete();

        return redirect()->route('settings.security.roles.index')
            ->with('success', 'Role deleted successfully!');
    }

    // ============================================
    // PERMISSION MANAGEMENT
    // ============================================

    /**
     * Display list of permissions
     */
    public function permissionList()
    {
        $permissions = Permission::orderBy('name')->paginate(50);
        
        // Group permissions by module
        $groupedPermissions = Permission::all()->groupBy(function($permission) {
            $parts = explode('.', $permission->name);
            return $parts[0];
        });

        return view('settings.security_settings.permissions.index', compact('permissions', 'groupedPermissions'));
    }

    /**
     * Show create permission form
     */
    public function createPermission()
    {
        $modules = [
            'patient-registration' => 'Patient Registration',
            'emergency' => 'Emergency',
            'opd' => 'OPD',
            'cpd' => 'CPD',
            'ipd' => 'IPD',
            'ipminor' => 'IP Minor',
            'daily-case' => 'Daily Case',
            'ot-management' => 'OT Management',
            'pharmacy' => 'Pharmacy',
            'dental' => 'Dental',
            'physiotherapy' => 'Physiotherapy',
            'lab' => 'Lab',
            'canteen' => 'Canteen',
            'mis-report' => 'MIS Report',
            'accounts' => 'Accounts',
            'store' => 'Store',
            'inventory' => 'Inventory',
            'settings' => 'Settings',
        ];

        return view('settings.security_settings.permissions.create', compact('modules'));
    }

    /**
     * Store new permission
     */
    public function storePermission(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name',
            'display_name' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        Permission::create([
            'name' => $request->name,
            'guard_name' => 'web',
            'display_name' => $request->display_name,
            'description' => $request->description,
        ]);

        return redirect()->route('settings.security.permissions.index')
            ->with('success', 'Permission created successfully!');
    }

    /**
     * Show edit permission form
     */
    public function editPermission($id)
    {
        $permission = Permission::findOrFail($id);
        return view('settings.security_settings.permissions.edit', compact('permission'));
    }

    /**
     * Update permission
     */
    public function updatePermission(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $id,
            'display_name' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        $permission->update([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description,
        ]);

        return redirect()->route('settings.security.permissions.index')
            ->with('success', 'Permission updated successfully!');
    }

    /**
     * Delete permission
     */
    public function deletePermission($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return redirect()->route('settings.security.permissions.index')
            ->with('success', 'Permission deleted successfully!');
    }

    // ============================================
    // AJAX METHODS
    // ============================================

    /**
     * Get users by role (AJAX)
     */
    public function getUsersByRole(Request $request)
    {
        $role = $request->role;
        
        $users = User::whereHas('roles', function($q) use ($role) {
            $q->where('name', $role);
        })->get(['id', 'name', 'email']);

        return response()->json($users);
    }

    /**
     * Get role permissions (AJAX)
     */
    public function getRolePermissions($id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        return response()->json([
            'role' => $role,
            'permissions' => $role->permissions->pluck('name')
        ]);
    }

    /**
     * Get user details with roles and permissions (AJAX)
     */
    public function getUserDetails($id)
    {
        $user = User::with('roles.permissions')->findOrFail($id);
        
        // Get all permissions through roles
        $allPermissions = [];
        foreach ($user->roles as $role) {
            foreach ($role->permissions as $permission) {
                $allPermissions[$permission->name] = $permission;
            }
        }

        return response()->json([
            'user' => $user,
            'roles' => $user->roles->pluck('name'),
            'permissions' => array_keys($allPermissions)
        ]);
    }

    /**
     * Bulk assign role to users
     */
    public function bulkAssignRole(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'role' => 'required|exists:roles,name',
        ]);

        $users = User::whereIn('id', $request->user_ids)->get();
        
        foreach ($users as $user) {
            $user->assignRole($request->role);
        }

        return response()->json([
            'success' => true,
            'message' => 'Role assigned to ' . count($users) . ' user(s) successfully!'
        ]);
    }

    /**
     * Clone role with permissions
     */
    public function cloneRole($id)
    {
        $originalRole = Role::with('permissions')->findOrFail($id);
        
        DB::beginTransaction();
        try {
            $newRole = Role::create([
                'name' => $originalRole->name . '-copy',
                'guard_name' => 'web',
                'description' => 'Cloned from ' . $originalRole->name,
            ]);

            $newRole->givePermissionTo($originalRole->permissions->pluck('name')->toArray());

            DB::commit();

            return redirect()->route('settings.security.roles.index')
                ->with('success', 'Role cloned successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error cloning role: ' . $e->getMessage());
        }
    }
}
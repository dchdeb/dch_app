<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\{Permission, Role};

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Hospital ERP System - Complete Role & Permission Setup
     * Modules: Patient Registration, Emergency, OPD, CPD, IPD, IPMinor, 
     * Daily Case, OT Management, Pharmacy, Dental, Physiotherapy, Lab, 
     * Canteen, MIS Report, Accounts, Store, Inventory, Settings
     */
    public function run(): void
    {
        // Clear cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ============================================
        // DEFINE ALL MODULES AND THEIR PERMISSIONS
        // ============================================
        
        $modules = [
            // 1. Patient Registration
            'patient-registration' => [
                'display_name' => 'Patient Registration',
                'description' => 'Manage patient registration and records',
            ],
            
            // 2. Emergency
            'emergency' => [
                'display_name' => 'Emergency',
                'description' => 'Emergency department management',
            ],
            
            // 3. OPD - Out Patient Department
            'opd' => [
                'display_name' => 'OPD',
                'description' => 'Out Patient Department management',
            ],
            
            // 4. CPD
            'cpd' => [
                'display_name' => 'CPD',
                'description' => 'CPD management',
            ],
            
            // 5. IPD - In Patient Department
            'ipd' => [
                'display_name' => 'IPD',
                'description' => 'In Patient Department management',
            ],
            
            // 6. IPMinor
            'ipminor' => [
                'display_name' => 'IP Minor',
                'description' => 'IP Minor cases management',
            ],
            
            // 7. Daily Case
            'daily-case' => [
                'display_name' => 'Daily Case',
                'description' => 'Daily case management',
            ],
            
            // 8. OT Management
            'ot-management' => [
                'display_name' => 'OT Management',
                'description' => 'Operation Theater management',
            ],
            
            // 9. Pharmacy
            'pharmacy' => [
                'display_name' => 'Pharmacy',
                'description' => 'Pharmacy management',
            ],
            
            // 10. Dental
            'dental' => [
                'display_name' => 'Dental',
                'description' => 'Dental department management',
            ],
            
            // 11. Physiotherapy
            'physiotherapy' => [
                'display_name' => 'Physiotherapy',
                'description' => 'Physiotherapy department management',
            ],
            
            // 12. Lab
            'lab' => [
                'display_name' => 'Lab',
                'description' => 'Laboratory management',
            ],
            
            // 13. Canteen
            'canteen' => [
                'display_name' => 'Canteen',
                'description' => 'Canteen management',
            ],
            
            // 14. MIS Report
            'mis-report' => [
                'display_name' => 'MIS Report',
                'description' => 'Management Information System reports',
            ],
            
            // 15. Accounts
            'accounts' => [
                'display_name' => 'Accounts',
                'description' => 'Accounts and billing management',
            ],
            
            // 16. Store
            'store' => [
                'display_name' => 'Store',
                'description' => 'Store management',
            ],
            
            // 17. Inventory
            'inventory' => [
                'display_name' => 'Inventory',
                'description' => 'Inventory management',
            ],
            
            // 18. Settings
            'settings' => [
                'display_name' => 'Settings',
                'description' => 'System settings and configuration',
            ],
        ];

        // ============================================
        // DEFINE PERMISSION ACTIONS
        // ============================================
        
        $actions = [
            'view' => 'View',
            'create' => 'Create',
            'edit' => 'Edit',
            'delete' => 'Delete',
            'print' => 'Print',
            'export' => 'Export',
            'approve' => 'Approve',
        ];

        // ============================================
        // CREATE ALL PERMISSIONS
        // ============================================
        
        $allPermissions = [];

        foreach ($modules as $moduleName => $moduleInfo) {
            foreach ($actions as $action => $actionName) {
                $permissionName = "{$moduleName}.{$action}";
                
                $permission = Permission::firstOrCreate(
                    ['name' => $permissionName, 'guard_name' => 'web'],
                    [
                        'display_name' => "{$actionName} {$moduleInfo['display_name']}",
                        'description' => "Permission to {$action} in {$moduleInfo['display_name']}"
                    ]
                );
                
                $allPermissions[$moduleName][] = $permissionName;
            }
        }

        // Special Permissions for Settings
        $specialPermissions = [
            'settings.users.manage' => 'Manage Users',
            'settings.roles.manage' => 'Manage Roles',
            'settings.permissions.manage' => 'Manage Permissions',
            'settings.system.configure' => 'Configure System Settings',
            'settings.backup.manage' => 'Manage Backups',
            'settings.audit.view' => 'View Audit Logs',
        ];

        foreach ($specialPermissions as $permName => $displayName) {
            Permission::firstOrCreate(
                ['name' => $permName, 'guard_name' => 'web'],
                [
                    'display_name' => $displayName,
                    'description' => "Permission to {$displayName}"
                ]
            );
            $allPermissions['settings'][] = $permName;
        }

        // ============================================
        // DEFINE ROLES
        // ============================================

        // 1. Super Admin - Full access
        $superAdmin = Role::firstOrCreate(
            ['name' => 'super-admin', 'guard_name' => 'web'],
            ['description' => 'Super Administrator with full system access']
        );
        $superAdmin->givePermissionTo(Permission::all());

        // 2. Hospital Administrator
        $admin = Role::firstOrCreate(
            ['name' => 'hospital-admin', 'guard_name' => 'web'],
            ['description' => 'Hospital Administrator']
        );
        $adminPermissions = array_merge(
            $allPermissions['patient-registration'] ?? [],
            $allPermissions['emergency'] ?? [],
            $allPermissions['opd'] ?? [],
            $allPermissions['cpd'] ?? [],
            $allPermissions['ipd'] ?? [],
            $allPermissions['ipminor'] ?? [],
            $allPermissions['daily-case'] ?? [],
            $allPermissions['ot-management'] ?? [],
            $allPermissions['pharmacy'] ?? [],
            $allPermissions['dental'] ?? [],
            $allPermissions['physiotherapy'] ?? [],
            $allPermissions['lab'] ?? [],
            $allPermissions['canteen'] ?? [],
            $allPermissions['mis-report'] ?? [],
            $allPermissions['accounts'] ?? [],
            $allPermissions['store'] ?? [],
            $allPermissions['inventory'] ?? [],
            ['settings.users.manage', 'settings.roles.manage']
        );
        $admin->givePermissionTo($adminPermissions);

        // 3. Doctor
        $doctor = Role::firstOrCreate(
            ['name' => 'doctor', 'guard_name' => 'web'],
            ['description' => 'Doctor']
        );
        $doctorPermissions = array_merge(
            ['patient-registration.view', 'patient-registration.create', 'patient-registration.edit'],
            ['emergency.view', 'emergency.create', 'emergency.edit'],
            ['opd.view', 'opd.create', 'opd.edit', 'opd.print'],
            ['cpd.view', 'cpd.create', 'cpd.edit'],
            ['ipd.view', 'ipd.create', 'ipd.edit', 'ipd.print'],
            ['ipminor.view', 'ipminor.create', 'ipminor.edit'],
            ['daily-case.view', 'daily-case.create', 'daily-case.edit'],
            ['ot-management.view', 'ot-management.create', 'ot-management.edit'],
            ['lab.view', 'lab.create', 'lab.print'],
            ['pharmacy.view']
        );
        $doctor->givePermissionTo($doctorPermissions);

        // 4. Nurse
        $nurse = Role::firstOrCreate(
            ['name' => 'nurse', 'guard_name' => 'web'],
            ['description' => 'Nurse']
        );
        $nursePermissions = array_merge(
            ['patient-registration.view', 'patient-registration.create'],
            ['emergency.view', 'emergency.create', 'emergency.edit'],
            ['ipd.view', 'ipd.create', 'ipd.edit'],
            ['ot-management.view', 'ot-management.create'],
            ['daily-case.view', 'daily-case.create']
        );
        $nurse->givePermissionTo($nursePermissions);

        // 5. Receptionist / Front Desk
        $receptionist = Role::firstOrCreate(
            ['name' => 'receptionist', 'guard_name' => 'web'],
            ['description' => 'Receptionist / Front Desk']
        );
        $receptionistPermissions = array_merge(
            ['patient-registration.view', 'patient-registration.create', 'patient-registration.edit', 'patient-registration.print'],
            ['opd.view', 'opd.create', 'opd.edit'],
            ['emergency.view', 'emergency.create'],
            ['ipd.view', 'ipd.create'],
            ['accounts.view', 'accounts.create']
        );
        $receptionist->givePermissionTo($receptionistPermissions);

        // 6. Pharmacist
        $pharmacist = Role::firstOrCreate(
            ['name' => 'pharmacist', 'guard_name' => 'web'],
            ['description' => 'Pharmacist']
        );
        $pharmacistPermissions = array_merge(
            $allPermissions['pharmacy'] ?? [],
            ['patient-registration.view'],
            ['accounts.view', 'accounts.create']
        );
        $pharmacist->givePermissionTo($pharmacistPermissions);

        // 7. Lab Technician
        $labTech = Role::firstOrCreate(
            ['name' => 'lab-technician', 'guard_name' => 'web'],
            ['description' => 'Lab Technician']
        );
        $labTechPermissions = array_merge(
            $allPermissions['lab'] ?? [],
            ['patient-registration.view'],
            ['accounts.view', 'accounts.create']
        );
        $labTech->givePermissionTo($labTechPermissions);

        // 8. Accountant / Billing
        $accountant = Role::firstOrCreate(
            ['name' => 'accountant', 'guard_name' => 'web'],
            ['description' => 'Accountant / Billing Staff']
        );
        $accountantPermissions = array_merge(
            $allPermissions['accounts'] ?? [],
            ['patient-registration.view'],
            ['opd.view', 'ipd.view', 'emergency.view'],
            ['mis-report.view', 'mis-report.export'],
            ['canteen.view', 'canteen.create']
        );
        $accountant->givePermissionTo($accountantPermissions);

        // 9. Store Manager
        $storeManager = Role::firstOrCreate(
            ['name' => 'store-manager', 'guard_name' => 'web'],
            ['description' => 'Store Manager']
        );
        $storeManagerPermissions = array_merge(
            $allPermissions['store'] ?? [],
            $allPermissions['inventory'] ?? [],
            ['mis-report.view']
        );
        $storeManager->givePermissionTo($storeManagerPermissions);

        // 10. OT In-Charge
        $otIncharge = Role::firstOrCreate(
            ['name' => 'ot-incharge', 'guard_name' => 'web'],
            ['description' => 'Operation Theater In-Charge']
        );
        $otInchargePermissions = array_merge(
            $allPermissions['ot-management'] ?? [],
            ['patient-registration.view'],
            ['ipd.view', 'ipd.edit'],
            ['emergency.view']
        );
        $otIncharge->givePermissionTo($otInchargePermissions);

        // 11. Dental Doctor
        $dentalDoctor = Role::firstOrCreate(
            ['name' => 'dental-doctor', 'guard_name' => 'web'],
            ['description' => 'Dental Doctor']
        );
        $dentalPermissions = array_merge(
            $allPermissions['dental'] ?? [],
            ['patient-registration.view', 'patient-registration.create'],
            ['accounts.view']
        );
        $dentalDoctor->givePermissionTo($dentalPermissions);

        // 12. Physiotherapist
        $physiotherapist = Role::firstOrCreate(
            ['name' => 'physiotherapist', 'guard_name' => 'web'],
            ['description' => 'Physiotherapist']
        );
        $physioPermissions = array_merge(
            $allPermissions['physiotherapy'] ?? [],
            ['patient-registration.view', 'patient-registration.create'],
            ['accounts.view']
        );
        $physiotherapist->givePermissionTo($physioPermissions);

        // 13. Emergency Staff
        $emergencyStaff = Role::firstOrCreate(
            ['name' => 'emergency-staff', 'guard_name' => 'web'],
            ['description' => 'Emergency Department Staff']
        );
        $emergencyPermissions = array_merge(
            $allPermissions['emergency'] ?? [],
            ['patient-registration.view', 'patient-registration.create', 'patient-registration.edit'],
            ['opd.view', 'opd.create'],
            ['ipd.view', 'ipd.create']
        );
        $emergencyStaff->givePermissionTo($emergencyPermissions);

        // 14. Canteen Manager
        $canteenManager = Role::firstOrCreate(
            ['name' => 'canteen-manager', 'guard_name' => 'web'],
            ['description' => 'Canteen Manager']
        );
        $canteenPermissions = array_merge(
            $allPermissions['canteen'] ?? [],
            ['accounts.view']
        );
        $canteenManager->givePermissionTo($canteenPermissions);

        // 15. MIS Officer
        $misOfficer = Role::firstOrCreate(
            ['name' => 'mis-officer', 'guard_name' => 'web'],
            ['description' => 'MIS Officer / Report Generator']
        );
        $misPermissions = array_merge(
            $allPermissions['mis-report'] ?? [],
            ['patient-registration.view'],
            ['opd.view', 'ipd.view', 'emergency.view'],
            ['lab.view', 'pharmacy.view'],
            ['accounts.view'],
            ['settings.audit.view']
        );
        $misOfficer->givePermissionTo($misPermissions);

        // 16. Data Entry Operator
        $dataEntry = Role::firstOrCreate(
            ['name' => 'data-entry', 'guard_name' => 'web'],
            ['description' => 'Data Entry Operator']
        );
        $dataEntryPermissions = array_merge(
            ['patient-registration.view', 'patient-registration.create', 'patient-registration.edit'],
            ['opd.view', 'opd.create', 'opd.edit'],
            ['ipd.view', 'ipd.create', 'ipd.edit'],
            ['daily-case.view', 'daily-case.create', 'daily-case.edit']
        );
        $dataEntry->givePermissionTo($dataEntryPermissions);

        // Clear cache again
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $this->command->info('✅ Role Permission Seeder completed successfully!');
        $this->command->info('');
        $this->command->info('📋 Created Roles:');
        $this->command->info('   1. super-admin - Super Administrator');
        $this->command->info('   2. hospital-admin - Hospital Administrator');
        $this->command->info('   3. doctor - Doctor');
        $this->command->info('   4. nurse - Nurse');
        $this->command->info('   5. receptionist - Receptionist');
        $this->command->info('   6. pharmacist - Pharmacist');
        $this->command->info('   7. lab-technician - Lab Technician');
        $this->command->info('   8. accountant - Accountant');
        $this->command->info('   9. store-manager - Store Manager');
        $this->command->info('   10. ot-incharge - OT In-Charge');
        $this->command->info('   11. dental-doctor - Dental Doctor');
        $this->command->info('   12. physiotherapist - Physiotherapist');
        $this->command->info('   13. emergency-staff - Emergency Staff');
        $this->command->info('   14. canteen-manager - Canteen Manager');
        $this->command->info('   15. mis-officer - MIS Officer');
        $this->command->info('   16. data-entry - Data Entry Operator');
        $this->command->info('');
        $this->command->info('🔐 Total Permissions: ' . Permission::count());
        $this->command->info('👥 Total Roles: ' . Role::count());
    }
}
<?php

namespace Database\Seeders;

use App\Http\Services\GlobalServices;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionTableSeeder extends Seeder
{
    protected string $guard = 'api';

    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        $permissions = $this->getPermissions();
        foreach ($permissions as $permission)
            Permission::firstOrCreate([
                'name' => $permission['name'],
                'guard_name' => $this->guard
            ]);
        $role = Role::firstOrCreate(['name' => Role::TEACHER, 'guard_name' => $this->guard]);
        $permissions = Permission::get();
        $role->syncPermissions($permissions);

        $student = Role::firstOrCreate(['name' => Role::STUDENT, 'guard_name' => $this->guard]);
    }


    protected function getPermissions(): array
    {
        return (new GlobalServices())->getTotalPermissions();
    }
}

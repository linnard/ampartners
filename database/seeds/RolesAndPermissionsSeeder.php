<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // this can be done as separate statements
        $partner  = Role::create(['name' => \App\Models\User::ROLE_PARTNER]);
        $operator = Role::create(['name' => \App\Models\User::ROLE_ADMIN]);


        // create partner permissions
        /*Permission::create(['name' => 'info']);
        Permission::create(['name' => 'employment']);
        Permission::create(['name' => 'users']);
        Permission::create(['name' => 'visa_support']);
        Permission::create(['name' => 'get_reward']);

        // create admin permissions
        Permission::create(['name' => 'info']);


        // create roles and assign created permissions

        // this can be done as separate statements
        $role = Role::create(['name' => 'writer']);
        $role->givePermissionTo('edit articles');

        // or may be done by chaining
        $role = Role::create(['name' => 'moderator'])
            ->givePermissionTo(['publish articles', 'unpublish articles']);

        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());*/
    }
}

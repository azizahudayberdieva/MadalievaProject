<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    private $permissions = ['publish_posts', 'create_posts', 'edit_posts',
        'delete_posts', 'create_categories', 'create_admin',
        'edit_categories', 'delete_categories', 'view_posts',
        'view_categories', 'create_users', 'edit_users',
        'delete_users'];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createPermissions();

        $adminRole = Role::create(['name' => 'admin']);
        $admin = factory(\App\Models\User::class)->create(
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => 'qwerty123'
            ]
        );

        $managerRole = Role::create(['name' => 'manager']);
        $manger = factory(\App\Models\User::class)->create(
            [
                'name' => 'manager',
                'email' => 'manager@gmail.com',
                'password' => 'qwerty123'
            ]
        );

        $userRole = Role::create(['name' => 'subscriber']);
        $user = factory(\App\Models\User::class)->create(
            [
                'name' => 'user',
                'email' => 'user@gmail.com',
                'password' => 'qwerty123'
            ]
        );

        $adminRole->givePermissionTo(['publish_posts', 'create_posts', 'edit_posts',
            'delete_posts', 'create_categories', 'create_admin',
            'edit_categories', 'delete_categories', 'view_posts',
            'view_categories', 'create_users', 'edit_users',
            'delete_users']);

        $admin->assignRole($adminRole);

        $managerRole->givePermissionTo(['create_posts', 'edit_posts', 'delete_posts',
            'create_categories', 'edit_categories', 'delete_categories', 'view_posts', 'view_categories']);

        $manger->assignRole($managerRole);

        $userRole->givePermissionTo(['view_posts', 'view_categories']);

        $user->assignRole($userRole);

    }

    private function createPermissions()
    {
        collect($this->permissions)->each(function ($permission) {
            Permission::create([
                'name' => $permission
            ]);
        });
    }
}

<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::create(['name' => 'Админ']);
        $admin = factory(\App\Models\User::class)->create(
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => 'qwerty123'
            ]
        );

        $userRole = Role::create(['name' => 'Подписчик']);
        $user = factory(\App\Models\User::class)->create(
            [
                'name' => 'user',
                'email' => 'user@gmail.com',
                'password' => 'qwerty123'
            ]
        );

        $admin->assignRole($adminRole);
        $user->assignRole($userRole);

    }
}

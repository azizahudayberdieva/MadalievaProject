<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

// launch on production
// Route::get('/permissions', function () {
//    $permissions = ['publish_posts', 'create_posts', 'edit_posts',
//        'delete_posts', 'create_categories', 'create_admin',
//        'edit_categories', 'delete_categories', 'view_posts',
//        'view_categories', 'create_users', 'edit_users',
//        'delete_users'];
//
//    collect($permissions)->each(function($permission) {
//        Spatie\Permission\Models\Permission::create([
//            'name' => $permission
//        ]);
//    });
//
//    $adminRole = Spatie\Permission\Models\Role::find(1);
//    $adminRole->givePermissionTo(['publish_posts', 'create_posts', 'edit_posts',
//        'delete_posts', 'create_categories', 'create_admin',
//        'edit_categories', 'delete_categories', 'view_posts',
//        'view_categories', 'create_users', 'edit_users',
//        'delete_users']);
//
//    $subsRole = Spatie\Permission\Models\Role::find(2);
//    $subsRole->givePermissionTo(['view_posts', 'view_categories']);
//
//    $managerRole = Spatie\Permission\Models\Role::create([
//        'name' => 'manager'
//    ]);
//    $managerRole->givePermissionTo(['create_posts', 'edit_posts', 'delete_posts',
//        'create_categories', 'edit_categories', 'delete_categories', 'view_posts', 'view_categories']);

//    $manager = App\Models\User::create([
//        'name' => 'editor',
//        'email' => 'editor@gmail.com',
//        'password' => 'qwerty123'
//    ]);
//
//    $manager->assignRole($managerRole);
// });
Route::get('/download/{id}', 'MediaController@download');

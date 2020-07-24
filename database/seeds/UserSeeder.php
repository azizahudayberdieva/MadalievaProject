<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = factory(\App\Models\Category::class, 2)->create();

        factory(\App\Models\User::class, 2)->create()->each(function ($user) use ($categories){
            $categories->each(function ($category) use ($user){
                factory(\App\Models\Post::class)->create([
                    'user_id' => $user->id,
                    'category_id' => $category->id
                ]);
            });
        });
    }
}

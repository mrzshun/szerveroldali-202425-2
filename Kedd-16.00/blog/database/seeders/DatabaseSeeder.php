<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Post;
use App\Models\Category;
use App\Models\Comment;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'email' => 'admin@example.com',
            'is_admin' => true,
        ]);
        $usernum = fake()->numberBetween(10, 15);
        $posts = Post::factory(fake()->numberBetween(10, 15))->create();
        $categories = Category::factory(fake()->numberBetween(10, 15))->create();

        $users = collect([]);
        for ($i = 0; $i < $usernum; $i++) {
            $users[] = User::factory()->create([
                'email' => 'user' . $i . '@example.com',
            ]);
        }

        foreach ($posts as $post) {
            if (fake()->boolean()) {
                $post->author()->associate($users->random())->save();
            }
            $post->categories()->sync($categories->random(rand(1, $categories->count())));
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Database\Factories\Helpers\FactoryHelpers;
use Database\Seeders\Traits\DisableForeignKeys;
use Database\Seeders\Traits\TruncateTable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class PostSeeder extends Seeder
{
    use TruncateTable, DisableForeignKeys;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->disableForeignKey();
        $this->truncate('posts');
        $posts = \App\Models\Post::factory(3)
            ->has(Comment::factory(3), 'comments')
            ->untitled()
            ->create();

        #to populate post_user table,
        #loop through $posts and link random userId using sync
        $posts->each(function (Post $post) {
            $post->users()->sync([FactoryHelpers::getRandomModelId(User::class)]);
        });

        $this->enableForeignKey();
    }
}

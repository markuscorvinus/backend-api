<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Database\Factories\Helpers\FactoryHelpers;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $postID = FactoryHelpers::getRandomModelId(Post::class);

        $userID = FactoryHelpers::getRandomModelId(User::class);

        return [
            'body' => [],
            'user_id' => $userID,
            'post_id' => $postID,
        ];
    }
}

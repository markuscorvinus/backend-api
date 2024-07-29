<?php

namespace App\Services\User;

use App\Events\UserCreated;
use App\Exceptions\GeneralJsonException;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserService
{
    public function allPosts($attributes)
    {
        $perPage = $attributes['page_no'] ?? 10;
        $posts = Post::query()->paginate($perPage);

        return $posts;
    }

    public function createUsers($attributes)
    {
        return DB::transaction(function () use ($attributes) {
            $users = User::query()->create([
                'name' => $attributes->name,
                'email' => $attributes->email,
                'password' => bcrypt($attributes->password)
            ]);

            throw_if(!$users, GeneralJsonException::class, 'No user record created');

            event(new UserCreated($users));
            return $users;
        });
    }
}

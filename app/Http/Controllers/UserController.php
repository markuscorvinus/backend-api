<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $request['page_no'] ?? 10;
        $posts = User::query()->paginate($perPage);

        return UserResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserService $userService, Request $request)
    {
        $users = $userService->createUsers($request);
        return new UserResource($users);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $updated = $user->update([
            'name' => $request->name ?? $user->name,
            'email' => $request->email ?? $user->email,
        ]);

        if (!$updated) {
            return new JsonResponse(['data' => 'failed'], 400);
        }

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $deleted = $user->forceDelete();
        if (!$deleted) {
            return new JsonResponse(['data' => 'failed'], 400);
        }
        return new JsonResponse(['data' => $deleted]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * * GET api/users?page=2&page_size=10
     */
    public function index(Request $request)
    {
        $pageSize = $request->page_size ?? 20;

        $users = User::query()->paginate($pageSize);
        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => $request['password'],
        ]);

        return new UserResource($user);
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
            'password' => $request->password ?? $user->password,
        ]);

        if (!$updated)
        {
            return new JsonResponse([
                'errors' => [
                    'Failed to update model'
                ]
            ], 400); // Bad request
        }

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $deleted = $user->forceDelete();

        if (!$deleted)
        {
            return new JsonResponse([
                'errors' => [
                    'Failed to delete model'
                ]
            ], 400); // Bad request
        }

        return new JsonResponse([
            'data'=> 'success'
        ]);
    }
}

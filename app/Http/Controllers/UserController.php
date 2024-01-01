<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::query()->get();
        return new JsonResponse([
            'data' => $users
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $post = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => $request['password'],
        ]);

        return new JsonResponse([
            'data'=> $post
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new JsonResponse([
            'data' => $user,  
        ]);
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

        return new JsonResponse([
            'data'=> $user
        ]);
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

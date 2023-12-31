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
        return new JsonResponse([
            'data' => 'index',  
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return new JsonResponse([
            'data' => 'store',  
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
        return new JsonResponse([
            'data' => 'update',  
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        return new JsonResponse([
            'data' => 'destroy',  
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        return User::all();
    }
    
    public function store(Request $request)
    {
        $user = User::create($request->all());
        return response()->json($user, 201);
    }
    
    public function show(User $user)
    {
        return $user;
    }
    
    public function update(Request $request, User $user)
    {
        $user->update($request->all());
        return response()->json($user, 200);
    }
    
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(null, 204);
    }
}

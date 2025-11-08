<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Silber\Bouncer\BouncerFacade as Bouncer;

class UserController extends Controller
{
    // Registration endpoint
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required'], 'email' => ['required','email','unique:users'],
            'password' => ['required','min:8']
        ]);
        $user = User::create([
            'name'=>$data['name'],
            'email'=>$data['email'],
            'password'=>Hash::make($data['password'])
        ]);
        // Assign default role
        Bouncer::assign('viewer')->to($user);
        return response()->json($user, 201);
    }

    // Login endpoint
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required','email'],
            'password' => ['required']
        ]);
        if (!Auth::attempt($data)) {
            return response()->json(['error'=>'Invalid credentials'], 401);
        }
        $user = Auth::user();
        // If using Sanctum
        $token = $user->createToken('api')->plainTextToken;
        return response()->json(['user'=>$user, 'token'=>$token]);
    }

    // List users (admin only)
    public function index()
    {
        $this->authorize('viewAny', User::class); // Or Bouncer::can('view-users')
        return User::paginate();
    }

    // Show details for one user
    public function show(User $user)
    {
        $this->authorize('view', $user);
        return $user;
    }

    // Update user (admin or self)
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);
        $user->update($request->validate([
            'name' => ['sometimes'],
            'email' => ['sometimes','email','unique:users,email,'.$user->id],
            'password' => ['sometimes','min:8']
        ]));
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();
        return $user;
    }

    // Delete user (admin only)
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $user->delete();
        return response()->noContent();
    }
}
